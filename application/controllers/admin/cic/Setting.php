<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Setting class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>메인페이지수정 controller 입니다.
 */
class Setting extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/setting';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_mediatype','RS_mediatype_map','RS_whitelist','RS_whitelist_log','RS_judge_denyreason');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_mediatype_model';

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
		$eventname = 'event_admin_cic_setting_index';
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
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('mfo_id', 'mfg_id', 'mem_id', 'target_mem_id', 'mfo_datetime'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('mfo_id', 'mfg_id', 'mem_id', 'target_mem_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mfo_id'); // 정렬이 가능한 필드
		$result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['target_member'] = $target_member = $this->Member_model->get_by_memid(element('target_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['target_display_name'] = display_username(
					element('mem_userid', $target_member),
					element('mem_nickname', $target_member),
					element('mem_icon', $target_member)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

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
		$search_option = array('mfo_datetime' => '날짜');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

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
		$where = array();
		$judr_jug_id = (int)$this->input->get('judr_jug_id');
		if($judr_jug_id == 2){
			$where['`judr_jug_id` = 2 or `judr_jug_id` = 4'] = null;
		} else if($judr_jug_id == 3){
			$where['judr_jug_id'] = 3;
		} else{
			$where['judr_jug_id'] = 1;
		}

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->RS_judge_denyreason_model->allow_search_field = array('judr_title','judr_reason'); // 검색이 가능한 필드
		$this->RS_judge_denyreason_model->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->RS_judge_denyreason_model->allow_order_field = array('judr_id'); // 정렬이 가능한 필드
		$result = $this->RS_judge_denyreason_model
			->get_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
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
		$view['view']['listall_url'] = admin_url($this->pagedir . '/denyreason');
		$view['view']['write_url'] = admin_url($this->pagedir . '/denyreason_write?' . $param->output());
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
		$this->form_validation->set_rules('judr_jug_id','카테고리','trim|required|in_list[1,2,3]');
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
				'judr_jug_id' => $this->input->post('judr_jug_id', null, ''),
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
	 * 미디어성격 목록을 가져오는 메소드입니다
	 */
	public function mediatype()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_mediatype';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);


		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$findex = 'met_order';
		$forder = 'asc';


		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 's',
				'label' => '그룹명',
				'rules' => 'trim',
			),
		);
		$this->form_validation->set_rules($config);


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = $this->input->post();

			$this->RS_mediatype_model->update_mediatype($updatedata);
			$view['view']['alert_message'] = '정상적으로 저장되었습니다';
		}

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->RS_mediatype_model->allow_order_field = array('met_order'); // 정렬이 가능한 필드
		$result = $this->RS_mediatype_model
			->get_mediatype_list('', '', '', '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$countwhere = array(
					'met_id' => element('met_id', $val),
				);
				$result['list'][$key]['member_count'] = $this->RS_mediatype_map_model->count_by($countwhere);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->RS_mediatype_model->primary_key;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir . '/mediatype');
		$view['view']['whitelist_url'] = admin_url($this->pagedir . '/whitelist');
		$view['view']['mediatype_url'] = admin_url($this->pagedir . '/mediatype');
		$view['view']['write_url'] = admin_url($this->pagedir . '/mediatype_write');
		$view['view']['denyreason_url'] = admin_url($this->pagedir . '/denyreason');
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/mediatype_listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'mediatype');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 화이트리스트 목록을 가져오는 메소드입니다
	 */
	public function whitelist()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_whitelist';
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
			'wht_id' => $param->sort('wht_id', 'asc'),
			'wht_wdate' => $param->sort('wht_wdate', 'asc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->RS_whitelist_model->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->RS_whitelist_model->allow_search_field = array('wht_title','wht_domains','wht_memo'); // 검색이 가능한 필드
		$this->RS_whitelist_model->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->RS_whitelist_model->allow_order_field = array('wht_id', 'wht_wdate'); // 정렬이 가능한 필드
		$result = $this->RS_whitelist_model
			->get_whitelist_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('wht_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);
				$domainArr = $this->RS_whitelist_model->get_explode_domain_list(element('wht_domains', $val));
				if(count($domainArr)>1){
					$result['list'][$key]['domain'] = $domainArr[0].' 외 '.(count($domainArr)-1).'개';
				} else {
					$result['list'][$key]['domain'] = $domainArr[0];
				}
				if(mb_strlen(element('wht_memo', $val))>15){
					$result['list'][$key]['memo'] = mb_substr(element('wht_memo', $val),0,15).'...';
				} else {
					$result['list'][$key]['memo'] = element('wht_memo', $val);
				}
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->RS_whitelist_model->primary_key;

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
			'wht_title'   => '제목',
			'wht_domains' => '도메인',
			'wht_memo' => '메모'
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir . '/whitelist');
		$view['view']['whitelist_url'] = admin_url($this->pagedir . '/whitelist');
		$view['view']['mediatype_url'] = admin_url($this->pagedir . '/mediatype');
		$view['view']['write_url'] = admin_url($this->pagedir . '/whitelist_write');
		$view['view']['denyreason_url'] = admin_url($this->pagedir . '/denyreason');
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/whitelist_listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'whitelist');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	/**
	 * 미션추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function whitelist_write($pid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_whitelist_write';
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
		$primary_key = $this->RS_whitelist_model->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->RS_whitelist_model->get_one($pid);
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'wht_title',
				'label' => '제목',
				'rules' => 'trim|min_length[2]|max_length[20]|required',
			),
			array(
				'field' => 'wht_domains',
				'label' => '도메인',
				'rules' => array('trim','required',array('is_domain_right',array($this->RS_whitelist_model,'check_is_domainlist_right'))),
			),
		);
		$this->form_validation->set_rules($config);
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
			$layoutconfig = array('layout' => 'layout', 'skin' => 'whitelist_write');
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
				'wht_title' => $this->input->post('wht_title', null, ''),
				'wht_domains' => strtolower($this->input->post('wht_domains', null, '')),
				'wht_memo' => $this->input->post('wht_memo', null, ''),
			);
			$datetime = cdate('Y-m-d H:i:s');

			// 작성/수정 로그 기록
			$this->load->model('RS_whitelist_log_model');
			$logdata = array(
				'whl_mem_id' => $this->session->userdata('mem_id'),
				'whl_userid' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
				'whl_datetime' => $datetime,
				'whl_ip' => $this->input->ip_address(),
				'whl_data' => json_encode($updatedata,JSON_UNESCAPED_UNICODE),
				'whl_useragent' => $this->agent->agent_string(),
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$updatedata['wht_mdate'] = $datetime;
				$updatedata['wht_modifier_mem_id'] = $this->session->userdata('mem_id');
				$updatedata['wht_modifier_ip'] = $this->input->ip_address();
				$wht_id = $this->input->post($primary_key);
				$this->RS_whitelist_model->update($wht_id, $updatedata);
				
				// 수정 로그 기록
				$logdata['whl_state'] = 'update';
				$logdata['whl_wht_id'] = $wht_id;
				$this->RS_whitelist_log_model->insert($logdata);

				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				$updatedata['wht_wdate'] = $datetime;
				$updatedata['wht_mem_id'] = $this->session->userdata('mem_id');
				$updatedata['wht_deletion'] = 'N';
				$updatedata['wht_register_ip'] = $this->input->ip_address();

				$wht_id = $this->RS_whitelist_model->insert($updatedata);
				
				// 작성 로그 기록
				$logdata['whl_state'] = 'new';
				$logdata['whl_wht_id'] = $wht_id;
				$this->RS_whitelist_log_model->insert($logdata);

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
			$redirecturl = admin_url($this->pagedir. '/whitelist' . '?' . $param->output());

			redirect($redirecturl);
		}
	}

	
	/**
	 * 화이트리스트 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function whitelist_listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_whitelist_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			$datetime = cdate('Y-m-d H:i:s');
			$this->load->model('RS_whitelist_log_model');
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					
					// $deletewhere = array(
					// 	'wht_id' => $val,
					// );
					// $this->RS_whitelist_model->delete_where($deletewhere);
					$update = array(
						'wht_deletion' => 'Y'
					);
					$this->RS_whitelist_model->update($val,$update);

					// 삭제 로그 기록
					$logdata = array(
						'whl_wht_id' => $val,
						'whl_state' => 'delete',
						'whl_mem_id' => $this->session->userdata('mem_id'),
						'whl_userid' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
						'whl_datetime' => $datetime,
						'whl_ip' => $this->input->ip_address(),
						'whl_useragent' => $this->agent->agent_string(),
					);
					$this->RS_whitelist_log_model->insert($logdata);
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
		$redirecturl = admin_url($this->pagedir. '/whitelist' . '?' . $param->output());

		redirect($redirecturl);
	}

	
	/**
	 * 화이트리스트 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function whitelist_excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_whitelist_excel';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$findex = $this->input->get('findex', null, $this->RS_whitelist_model->primary_key);
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->RS_whitelist_model->allow_search_field = array('wht_title','wht_domains','wht_memo'); // 검색이 가능한 필드
		$this->RS_whitelist_model->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->RS_whitelist_model->allow_order_field = array('wht_id', 'wht_wdate'); // 정렬이 가능한 필드

		$result = $this->RS_whitelist_model
			->get_whitelist_list('', '', '', '', $findex, $forder, $sfield, $skeyword);

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('wht_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['latest_member'] = $dbmember = $this->Member_model->get_by_memid(element('wht_modifier_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['latest_display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);
				// $domainArr = $this->RS_whitelist_model->get_explode_domain_list(element('wht_domains', $val));
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
		$view['view']['primary_key'] = $this->RS_whitelist_model->primary_key;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=화이트리스트목록_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir  . '/whitelist_excel', $view, true);
	}
	
}
