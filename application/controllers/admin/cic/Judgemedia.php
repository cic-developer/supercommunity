<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Judgemedia class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>미디어심사 controller 입니다.
 */
class Judgemedia extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/judgemedia';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_judge','RS_whitelist','RS_media','RS_media_log','RS_media_duplication','RS_mediatype','RS_mediatype_map','RS_judge_log','RS_judge_denied','RS_judge_denyreason','Member_extra_vars');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_judge_model';
	protected $jug_id 	 = array(2,4); 
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
		$eventname = 'event_admin_cic_judgemedia_index';
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
			->get_judge_list($this->jug_id, $per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('jud_mem_nickname', $val).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['med_duplicate'] = $this->RS_media_duplication_model->get_is_duplication(element('jud_med_id', $val));
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
			'jud_mem_nickname' 	=> '닉네임',
			'jud_med_admin'			=> '관리자명',
			'jud_med_url' 			=> '링크',
			'jud_wdate' 				=> '신청일',
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['whitelist_url'] = admin_url($this->pagedir . '/whitelist');
		$view['view']['mediatype_url'] = admin_url($this->pagedir . '/mediatype');
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
	 * 미디어심사 세부 페이지를 가져오는 메소드입니다
	 */
	public function detail($jid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_detail';
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
		}
		if (empty($jid) OR $jid < 1) {
			$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
			$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
			redirect($redirecturl);
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($jid) {
			$getdata = $this->{$this->modelname}->get_one_judge($this->jug_id,$jid);
			if(empty($getdata) || (element('jud_jug_id',$getdata) != 2 && element('jud_jug_id',$getdata) != 4)) {
				$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
				$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
				redirect($redirecturl);
			}
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */

		
		
		// log_message('error',$thumb_type_data);
		// med_name: { required: true, minlength:2, maxlength :255 },
		// med_wht_id: { required: true, digits:true, min:1, maxlength :11 },
		// med_url: { required: true, url:true, minlength:5, maxlength :255 },
		// met_id: { required: true},
		// med_admin: { required: true, minlength:1, maxlength :255 }
		$this->{$this->modelname}->set_wht_id = $this->input->post('jud_med_wht_id');
		$this->{$this->modelname}->set_met_id = $this->input->post('met_id');
		$config = array(
			array(
				'field' => 'jud_med_name',
				'label' => '사용자지정 미디어 이름',
				'rules' => 'trim|required|min_length[2]|max_length[255]',
			),
			array(
				'field' => 'jud_med_wht_id',
				'label' => '미디어플랫폼',
				'rules' => array('trim', 'is_natural_no_zero', 'greater_than_equal_to[1]', 'max_length[10]', 'required', array('check_wht_id_is',array($this->{$this->modelname},'check_wht_id_is'))),
			),
			array(
				'field' => 'jud_med_url',
				'label' => '링크',
				'rules' => array('trim', 'required', 'min_length[2]', 'max_length[255]', array('check_wht_id_url',array($this->{$this->modelname},'check_wht_id_url'))),
			),
			array(
				'field' => 'met_id',
				'label' => '미디어 성격',
				'rules' => array('trim','is_natural', array('check_met_id_is',array($this->{$this->modelname},'check_met_id_is'))),
			),
			array(
				'field' => 'jud_med_admin',
				'label' => '관리자명',
				'rules' => 'trim|required|min_length[2]|max_length[255]',
			),
			array(
				'field' => 'med_superpoint',
				'label' => 'SUPERPOINT',
				'rules' => 'trim|required|is_natural_no_zero|min_length[1]|max_length[11]',
			),
			array(
				'field' => 'med_member',
				'label' => 'PERFRIEND',
				'rules' => 'trim|required|is_natural_no_zero|min_length[1]|max_length[11]',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
		$file_error = '';
		$updatephoto = '';

		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($form_validation === false OR $file_error !== '') {
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			$view['view']['message'] = $file_error;

			$view['view']['data'] = $getdata;
			$view['view']['med_duplicate'] = $this->RS_media_duplication_model->get_is_duplication(element('jud_med_id', $getdata));;
			$view['view']['med_data'] = $this->RS_media_model->get_one(element('jud_med_id',$getdata));
			$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();
			$this->RS_mediatype_model->allow_order_field = array('met_order'); // 정렬이 가능한 필드
			$view['view']['all_mediatype'] = $this->RS_mediatype_model->get_list('','','','','met_order','asc');
			$map_data = $this->RS_mediatype_map_model->get('','met_id',array('med_id'=>element('jud_med_id',$getdata)));
			$mapArr = array();
			foreach($map_data as $l){
				$mapArr[] = element('met_id',$l);
			}
			$view['view']['all_mediatype_map'] = $mapArr;

			$view['view']['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $getdata), 'mem_id, mem_userid, mem_nickname, mem_icon');
			$view['view']['display_name'] = display_username(
				element('mem_userid', $dbmember),
				element('jud_mem_nickname', $getdata).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
				element('mem_icon', $dbmember)
			);
			$view['view']['all_denyreason'] = $this->RS_judge_denyreason_model->get_list('','',array('(judr_jug_id = 2 or judr_jug_id = 4)' => null));
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

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);



			/**
			 * 해당미디어를 승인하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$datetime = cdate('Y-m-d H:i:s');
				$med_id = element('jud_med_id',$getdata);
				if(!$med_id){
					$this->session->set_flashdata('message','jud_med_id 값 누락<br/>유지보수팀에 문의하세요.');
					log_message('error','/admin/cic/judgemedia/detail.php :: jud_id:'.$jid.'; jud_med_id value missing');
					$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
					redirect($redirecturl);
				}
				$updatedata = array(
					'jud_med_name' => $this->input->post('jud_med_name', null, ''),
					'jud_med_wht_id' => $this->input->post('jud_med_wht_id', null, ''),
					'jud_med_url' => $this->input->post('jud_med_url', null, ''),
					'jud_med_admin' => $this->input->post('jud_med_admin', null, ''),
					'jud_state' => 3,
					'jud_mdate' => $datetime,
					'jud_modifier_mem_id' => $this->session->userdata('mem_id'),
					'jud_modifier_ip' => $this->input->ip_address(),
				);
				$jud_id = $this->input->post($primary_key);
				$this->{$this->modelname}->update($jud_id, $updatedata);

				$updatedata = array(
					'med_name' => $this->input->post('jud_med_name', null, ''),
					'med_wht_id' => $this->input->post('jud_med_wht_id', null, ''),
					'med_url' => $this->input->post('jud_med_url', null, ''),
					'med_admin' => $this->input->post('jud_med_admin', null, ''),
					'med_state' => 3,
					'med_superpoint' => $this->input->post('med_superpoint', null, '0'),
					'med_member' => $this->input->post('med_member', null, '0'),
				);
				$this->RS_media_model->update($med_id, $updatedata);
				
				$deletewhere = array(
					'med_id' => $med_id
				);
				$this->RS_mediatype_map_model->delete_where($deletewhere);
				$insertarray = array();
				foreach($this->input->post('met_id') as $l){
					$insertarray[] = array(
						'med_id' => $med_id,
						'met_id' => $l
					);
				}
				$this->RS_mediatype_map_model->insert_batch($insertarray);

				// 수정 로그 기록
				$logdata = array(
					'mel_med_id' => $med_id,
					'mel_state' => 'update',
					'mel_mem_id' => $this->session->userdata('mem_id'),
					'mel_user_id' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
					'mel_datetime' => $datetime,
					'mel_ip' => $this->input->ip_address(),
					'mel_data' => json_encode($this->input->post(),JSON_UNESCAPED_UNICODE),
					'mel_useragent' => $this->agent->agent_string(),
				);
				$this->RS_media_log_model->insert($logdata);

				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				$this->session->set_flashdata(
					'message',
					'비정상적인 접근입니다.'
				);
			}

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			/**
			 * 게시물의 신규입력 또는 수정작업이 끝난 후 목록 페이지로 이동합니다
			 */
			$param =& $this->querystring;
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);
		}
	}

	
	/**
	 * 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemedia_excel';
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
		->get_judge_list($this->jug_id,'', '', $where, '', $findex, $forder, $sfield, $skeyword);

		$_whitelist = $this->RS_whitelist_model->get();
		$whitelistArr = array();
		foreach($_whitelist as $l){
			$whitelistArr[element('wht_id',$l)] = element('wht_title',$l);
		}

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['register_member'] = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['modifier_member'] = $this->Member_model->get_by_memid(element('jud_modifier_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['judn_reason'] 		 = element('judn_reason',$this->RS_judge_denied_model->get_one('','judn_reason', array('judn_jud_id' => element('jud_id',$val))));
				$result['list'][$key]['wht_title']   		 = element(element('jud_med_wht_id',$val),$whitelistArr);
				$result['list'][$key]['med_duplicate'] = $this->RS_media_duplication_model->get_is_duplication(element('jud_med_id', $val));
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
		header('Content-Disposition: attachment; filename=미디어심사목록_' . cdate('Y_m_d') . '.xls');
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
			$getdata = $this->{$this->modelname}->get_one_judge($this->jug_id, $jud_id);
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
			// if(element('jud_state',$getdata) == $this->input->post('state')){
			if(element('jud_state',$getdata) != 1){
				$return = array(
					'type' => 'error',
					'data' => 'already_done'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}
			$datetime = cdate('Y-m-d H:i:s');
			$update = array(
				'jud_state' => $this->input->post('state'),
				'jud_mdate' => $datetime,
				'jud_modifier_mem_id' => $this->session->userdata('mem_id'),
				'jud_modifier_ip' => $this->input->ip_address(),
			);
			if($this->{$this->modelname}->update(element('jud_id',$getdata), $update)){
				if(element('jud_jug_id',$getdata) == 2 || element('jud_jug_id',$getdata) == 4){
					$update = array(
						'med_state' => $this->input->post('state')
					);
					if($this->input->post('value') == 'deny'|| $this->input->post('value') == 'warn'){
						$update['med_textarea'] = $this->input->post('deny');
					}
					$this->RS_media_model->update(element('jud_med_id',$getdata),$update);
				}

				$warn_count = 0;
				$getuserdata = $this->Member_model->get_by_memid(element('jud_mem_id',$getdata), 'mem_id, mem_userid, mem_denied');
				if($this->input->post('value') == 'deny' || $this->input->post('value') == 'warn'){
					/*
					** 신규신청 반려일 경우 중복이 있다면 제거
					*/
					if(element('jud_jug_id',$getdata) == 2){
						$this->RS_media_duplication_model->delete_where(array('(`med_id = '.element('jud_med_id',$getdata).' or `dup_id` = '.element('jud_med_id',$getdata).')' => null));
					}
					/*
					** 경고 정보 불러오기
					*/
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
