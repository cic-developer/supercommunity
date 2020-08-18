<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Judgemission class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>미션심사 controller 입니다.
 */
class Judgemission extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/judgemission';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_judge','RS_whitelist','RS_judge_log','RS_judge_denied','RS_judge_denyreason','Member_extra_vars');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_judge_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'mis_title' => $param->sort('mis_title', 'asc'),
			'jud_id' => $param->sort('jud_id', 'asc'),
			'jud_med_wht_id' => $param->sort('jud_med_wht_id', 'asc'),
			'jud_state' => $param->sort('jud_state', 'asc'),
			'jud_wdate' => $param->sort('jud_wdate', 'asc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('mis_title','jud_med_admin', 'jud_med_url', 'jud_mem_nickname', 'jud_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mis_title','jud_id','jud_med_wht_id','jud_state','jud_wdate'); // 정렬이 가능한 필드

		
		$where = array();
		if (($jud_state = (int) $this->input->get('jud_state')) || $this->input->get('jud_state') === '0') {
			if ($jud_state >= 0) {
				$where['jud_state'] = $jud_state;
			}
		}
		if ($wht_id = (int) $this->input->get('wht_id')) {
			if ($wht_id > 0) {
				$where['jud_med_wht_id'] = $wht_id;
			}
		}
		$result = $this->{$this->modelname}
			->get_judge_list(1,$per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array(
			'mis_title' 				=> '미션제목',
			'jud_mem_nickname' 	=> '닉네임',
			'jud_med_admin'			=> '관리자명',
			'jud_med_url' 			=> '링크',
			'jud_wdate' 				=> '신청일',
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['denyreason_url'] = admin_url($this->pagedir . '/denyreason');
		$view['view']['detail_url'] = admin_url($this->pagedir . '/detail');

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	

	/**
	 * 반려사유 목록을 가져오는 메소드입니다
	 */
	public function denyreason()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_denyreason';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'judr_id' => $param->sort('judr_id', 'asc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->RS_judge_denyreason_model->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->RS_judge_denyreason_model->allow_search_field = array('judr_title','judr_reason'); // 검색이 가능한 필드
		$this->RS_judge_denyreason_model->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->RS_judge_denyreason_model->allow_order_field = array('judr_id'); // 정렬이 가능한 필드
		$result = $this->RS_judge_denyreason_model
			->get_list($per_page, $offset, array('judr_jug_id'=>1), '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				if(mb_strlen(element('judr_reason', $val))>15){
					$result['list'][$key]['memo'] = substr(element('judr_reason', $val),0,15).'...';
				} else {
					$result['list'][$key]['memo'] = element('judr_reason', $val);
				}
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->RS_judge_denyreason_model->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array(
			'judr_title'   => '제목',
			'judr_reason'   => '반려사유'
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['denyreason_url'] = admin_url($this->pagedir . '/denyreason');
		$view['view']['write_url'] = admin_url($this->pagedir . '/denyreason_write');
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/denyreason_listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'denyreason');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 반려사유추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function denyreason_write($pid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_denyreason_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($pid) {
			$pid = (int) $pid;
			if (empty($pid) OR $pid < 1) {
				show_404();
			}
		}
		$primary_key = $this->RS_judge_denyreason_model->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->RS_judge_denyreason_model->get_one($pid);
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$this->form_validation->set_rules('judr_title','제목','trim|required|min_length[2]|max_length[20]');
		$this->form_validation->set_rules('judr_reason','반려사유','trim|required');
		$form_validation = $this->form_validation->run();
		$file_error = '';
		$updatephoto = '';
		$file_error2 = '';
		$updateicon = '';


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($form_validation === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			$view['view']['data'] = $getdata;

			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'denyreason_write');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = array(
				'judr_jug_id' => 1,
				'judr_title' => $this->input->post('judr_title', null, ''),
				'judr_reason' => $this->input->post('judr_reason', null, ''),
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$judr_id = $this->input->post($primary_key);
				$this->RS_judge_denyreason_model->update($judr_id, $updatedata);

				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);

			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */

				$this->RS_judge_denyreason_model->insert($updatedata);
				

				$this->session->set_flashdata(
					'message',
					'정상적으로 입력되었습니다'
				);
			}

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir. '/denyreason' . '?' . $param->output());

			redirect($redirecturl);
		}
	}

	
	/**
	 * 화이트리스트 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function denyreason_listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_denyreason_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					
					$deletewhere = array(
						'judr_id' => $val,
					);
					$this->RS_judge_denyreason_model->delete_where($deletewhere);
				}
			}
		}

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 삭제되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir. '/denyreason' . '?' . $param->output());

		redirect($redirecturl);
	}


	/**
	 * 세부내용 페이지를 가져오는 메소드입니다
	 */
	public function detail($jid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_detail';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($jid) {
			$jid = (int) $jid;
			if (empty($jid) OR $jid < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($jid) {
			$getdata = $this->{$this->modelname}->get_one_judge($jid);
			if(empty($getdata) || element('jud_jug_id',$getdata) != 1) show_404();
		}

			$view['view']['data'] = $getdata;
			$view['view']['data']['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $getdata), 'mem_id, mem_userid, mem_nickname, mem_icon');
			$view['view']['data']['display_name'] = display_username(
				element('mem_userid', $dbmember),
				element('mem_nickname', $dbmember),
				element('mem_icon', $dbmember)
			);
			$view['view']['all_denyreason'] = $this->RS_judge_denyreason_model->get_list();
			$view['view']['this_denied_reason'] = $this->RS_judge_denied_model->get_one('','',array('judn_jud_id'=>$jid));

			/**
			 * primary key 정보를 저장합니다
			 */
			$view['view']['primary_key'] = $primary_key;

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 어드민 레이아웃을 정의합니다
			 */
			$layoutconfig = array('layout' => 'layout', 'skin' => 'detail');
			$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));

	}

	
	/**
	 * 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_excel';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$findex = $this->input->get('findex', null, $this->{$this->modelname}->primary_key);
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('mis_title', 'mis_content'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('mis_max_point'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mis_id','mis_thumb_type','mis_max_point','mis_wdate'); // 정렬이 가능한 필드

		$result = $this->{$this->modelname}
			->get_admin_list('', '', '', '', $findex, $forder, $sfield, $skeyword);

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['register_member'] = $dbmember = $this->Member_model->get_by_memid(element('mis_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['modifier_member'] = $dbmember = $this->Member_model->get_by_memid(element('mis_modifier_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				// $domainArr = $this->{$this->modelname}->get_explode_domain_list(element('wht_domains', $val));
				// if(count($domainArr)>1){
				// 	$result['list'][$key]['domain'] = '';
				// 	foreach($domainArr as $l){
				// 		$result['list'][$key]['domain'] .= $l.'\n';
				// 	}
				// } else {
				// 	$result['list'][$key]['domain'] = $domainArr[0];
				// }
			}
		}

		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=미션목록_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir  . '/excel', $view, true);
	}

	/*
	** 수정페이지에서 ajax로 마감하기
	*/
	public function ajax_set_state(){

		/*
		** Validation 라이브러리를 가져옵니다
		*/

		// mis_thumb_type 용 form_validation 데이터 저장
		$this->{$this->modelname}->post_form_data = array(
			'value'		=> $this->input->post('value')
		);

		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'jud_id', 
				'label' => 'JUD_ID', 
				'rules' => array('trim','is_natural','required','min_length[1]','max_length[11]')
			),
			array(
				'field' => 'value', 
				'label' => 'VALUE', 
				'rules' => array('trim','required','in_list[confirm,deny,warn]')
			),
			array(
				'field' => 'state', 
				'label' => 'STATE', 
				'rules' => array('trim','is_natural','required','in_list[0,3]')
			),
			array(
				'field' => 'deny', 
				'label' => '반려사유', 
				'rules' => array('trim', array('check_deny',array($this->{$this->modelname},'check_deny_data')))
			),
			array(
				'field' => 'warn', 
				'label' => '경고사유', 
				'rules' => array('trim', array('check_warn',array($this->{$this->modelname},'check_warn_data')))
			)
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
		/*
		** jud_id 값을 전송하지 않은 경우
		*/
		if($form_validation === false){
			$this->form_validation->set_error_delimiters('', '');
			$return = array(
				'type' => 'error',
				'data' => $this->form_validation->error_string()
			);
			echo json_encode($return,JSON_UNESCAPED_UNICODE);
			exit;

		} else {
			$jud_id = $this->input->post('jud_id');
			$getdata = $this->{$this->modelname}->get_one_judge($jud_id);
			/*
			** mis_id 값에 해당하는 미션이 없는 경우
			*/
			if(empty($getdata)){
				$return = array(
					'type' => 'error',
					'data' => 'no_data_found'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}

			/*
			** 이미 처리된 경우
			*/
			if(element('jud_state',$getdata) == $this->input->post('state')){
				$return = array(
					'type' => 'error',
					'data' => 'already_done'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}

			$update = array(
				'jud_state' => $this->input->post('state')
			);
			if($this->{$this->modelname}->update($mid, $update)){
				$warn_count = 0;
				$getuserdata = $this->Member_model->get_by_memid(element('jud_mem_id',$getdata), 'mem_id, mem_userid, mem_denied');
				if($this->input->post('value') == 'deny' || $this->input->post('value') == 'warn'){
					$extradata = $this->Member_extra_vars_model->get_all_meta(element('jud_mem_id',$getdata));
					// $is_warn_1 = element('mem_warn_1',$extradata);
					$is_warn_1 = $this->Member_extra_vars_model->item(element('jud_mem_id',$getdata),'mem_warn_1');
					if($is_warn_1) $warn_count ++;
					// $is_warn_2 = element('mem_warn_2',$extradata);
					$is_warn_2 = $this->Member_extra_vars_model->item(element('jud_mem_id',$getdata),'mem_warn_2');
					if($is_warn_2) $warn_count ++;
					/*
					** 반려 / 경고 사유 기록
					*/
						$insert = array(
							'judn_jud_id' => element('jud_id',$getdata),
							'judn_reason' => $this->input->post('deny')
						);
						$this->RS_judge_denied_model->insert($insert);

						if($this->input->post('value') == 'warn'){
							if(!$is_warn_1){
								$insert = array(
									'mem_warn_1' => $this->input->post('warn')
								);
								$this->Member_extra_vars_model->save(element('jud_mem_id',$getdata), $insert);
								$warn_count ++;
							} else if(!$is_warn_2){
								/*
								** 경고 2회시 차단적용
								*/
								$insert = array(
									'mem_warn_2' => $this->input->post('warn')
								);
								$this->Member_extra_vars_model->save(element('jud_mem_id',$getdata), $insert);

								$update = array(
									'mem_denied' => 1
								);
								$this->Member_model->update(element('jud_mem_id',$getdata),$update);
								$warn_count ++;
							} else {
								/*
								** 이미 2회 차단되있을 시 그냥 반려처리
								*/
								if(!element('mem_denied',$getuserdata)){
									$update = array(
										'mem_denied' => 1
									);
									$this->Member_model->update(element('jud_mem_id',$getdata),$update);
								}
							}
						}
				}

				/*
				** 로그 쌓기
				*/
				$insert = array(
					'jul_jug_id' 		=> element('jud_jug_id',$getdata),
					'jul_jud_id' 		=> element('jud_id',$getdata),
					'jul_state'  		=> $this->input->post('state'),
					'jul_mem_id'  	=> element('jud_mem_id',$getdata),
					'jul_user_id' 	=> element('mem_userid',$getuserdata),
					'jul_datetime'  => cdate('Y-m-d H:i:s'),
					'jul_ip'  	  	=> $this->input->ip_address(),
					'jul_useragent' => $this->agent->agent_string(),
				);
				$this->RS_judge_log_model->insert($insert);
				/*
				** 정상 마감처리 된 경우
				*/
				$return = array(
					'type' => 'success',
					'data' => 'updated',
					'warn_count' => $warn_count
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;

			} else {

				/*
				** 마감 update 중 오류가 발생한 경우
				*/
				$return = array(
					'type' => 'error',
					'data' => 'error_occur'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;

			}
		}
	}
}