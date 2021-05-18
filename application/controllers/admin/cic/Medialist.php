<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>미디어목록 controller 입니다.
 */
class Medialist extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/medialist';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_media','RS_media_log','RS_media_duplication','RS_whitelist', 'RS_mediatype', 'RS_mediatype_map');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_media_model';

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
		$eventname = 'event_admin_cic_medialist_index';
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
			'med_id' => $param->sort('med_id', 'asc'),
			'mis_thumb_type' => $param->sort('mis_thumb_type', 'asc'),
			'mis_max_point' => $param->sort('mis_max_point', 'asc'),
			'percentage' => $param->sort('percentage', 'asc'),
			'mis_wdate' => $param->sort('mis_wdate', 'asc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/*
		** 게시판 목록에 필요한 정보를 가져옵니다.
		*/
		$this->{$this->modelname}->allow_search_field = array('med_url', 'met_id','mem_nickname','med_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('med_id'); // 정렬이 가능한 필드


		$where = array();

		if(($jud_state = (int)$this->input->get('med_state')) || $this->input->get('med_state')==='0'){
			if ($jud_state >= 0) {
				$where['med_state'] = $jud_state;
			}
		}

		if ($wht_id = (int) $this->input->get('wht_id')) {
			if ($wht_id > 0) {
				$where['med_wht_id'] = $wht_id;
			}
		}

		$where['med_deletion'] = 'N';
		$result = $this->{$this->modelname}
			->get_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				/*
				** 유저 아이디 닉네임 불러오기
				*/
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $val).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['state'] = rs_get_state(element('med_state',$val));

				$result['list'][$key]['wht_title'] = element('wht_title',$this->RS_whitelist_model->get_one(element('med_wht_id',$val), 'wht_title', array('wht_deletion' => 'N')));

				$result['list'][$key]['med_duplicate'] = $this->RS_media_duplication_model->get_is_duplication(element('med_id', $val));

				$result['list'][$key]['num'] = $list_num--;

			}
		}
		$view['view']['data'] = $result;
		$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();

		/*
		** primary key 정보를 저장합니다
		*/
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/*
		** 페이지네이션을 생성합니다
		*/
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/*
		** 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		*/
		$search_option = array(
			'med_url' => '링크',
			// 'met_id' => '미디어 성격',
			'mem_nickname' => '신청자',
			// 'med_wdate' => '날짜'
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/*
		** 어드민 레이아웃을 정의합니다
		*/
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	

	/**
	 * 미션추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function detail($mid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_medialist_detail';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($mid) {
			$mid = (int) $mid;
		}
		if (empty($mid) OR $mid < 1) {
			$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
			$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
			redirect($redirecturl);
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($mid) {
			$getdata = $this->{$this->modelname}->get_one($mid);
			if(empty($getdata)) {
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
		$this->{$this->modelname}->set_wht_id = $this->input->post('med_wht_id');
		$this->{$this->modelname}->set_met_id = $this->input->post('met_id');
		$config = array(
			array(
				'field' => 'med_name',
				'label' => '사용자지정 미디어 이름',
				'rules' => 'trim|required|min_length[2]|max_length[255]',
			),
			array(
				'field' => 'med_wht_id',
				'label' => '미디어플랫폼',
				'rules' => array('trim', 'is_natural_no_zero', 'greater_than_equal_to[1]', 'max_length[10]', 'required', array('check_wht_id_is',array($this->{$this->modelname},'check_wht_id_is'))),
			),
			array(
				'field' => 'med_url',
				'label' => '링크',
				'rules' => array('trim', 'required', 'min_length[2]', 'max_length[255]', array('check_wht_id_url',array($this->{$this->modelname},'check_wht_id_url'))),
			),
			array(
				'field' => 'met_id',
				'label' => '미디어 성격',
				'rules' => array('trim','is_natural', array('check_met_id_is',array($this->{$this->modelname},'check_met_id_is'))),
			),
			array(
				'field' => 'med_admin',
				'label' => '관리자명',
				'rules' => 'trim|required|min_length[2]|max_length[255]',
			),
		);

		//만일 미디어 데이터가 있고 상태가 심사중이 아니라면
		if(element('med_state',$getdata) == 3){
			$config[] = array(
				'field' => 'med_superpoint',
				'label' => '슈퍼포인트',
				'rules' => 'trim|required|is_natural',
			);

			$config[] = array(
				'field' => 'med_member',
				'label' => 'PERFRIEND',
				'rules' => 'trim|required|is_natural'
			);
		}
		
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
			$view['view']['med_duplicate'] = $this->RS_media_duplication_model->get_is_duplication(element('med_id', $getdata));
			$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();
			$this->RS_mediatype_model->allow_order_field = array('met_order'); // 정렬이 가능한 필드
			$view['view']['all_mediatype'] = $this->RS_mediatype_model->get_list('','','','','met_order','asc');
			$map_data = $this->RS_mediatype_map_model->get('','met_id',array('med_id'=>$mid));
			$mapArr = array();
			foreach($map_data as $l){
				$mapArr[] = element('met_id',$l);
			}
			$view['view']['all_mediatype_map'] = $mapArr;

			$view['view']['member'] = $dbmember = $this->Member_model->get_by_memid(element('mem_id', $getdata), 'mem_id, mem_userid, mem_nickname, mem_icon');
			$view['view']['display_name'] = display_username(
				element('mem_userid', $dbmember),
				element('mem_nickname', $getdata).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
				element('mem_icon', $dbmember)
			);
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
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$datetime = cdate('Y-m-d H:i:s');
				$updatedata = array(
					'med_name' => $this->input->post('med_name', null, ''),
					'med_wht_id' => $this->input->post('med_wht_id', null, ''),
					'med_url' => $this->input->post('med_url', null, ''),
					'med_admin' => $this->input->post('med_admin', null, ''),
					'med_superpoint' => $this->input->post('med_superpoint', null, ''),
					'med_member'	=> $this->input->post('med_member',null,'')
				);
				$med_id = $this->input->post($primary_key);
				$this->{$this->modelname}->update($med_id, $updatedata);
				
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
	 * 미디어목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_medialist_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			$datetime = cdate('Y-m-d H:i:s');
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					
					$deletewhere = array(
						'med_id' => $val,
						'med_state !=' => 1,
					);
					$deleteupdate = array(
						'med_deletion' => 'Y',
					);
					$this->{$this->modelname}->update('',$deleteupdate,$deletewhere);
					
					$this->RS_media_duplication_model->delete_where(array('(`med_id = '.$val.' or `dup_id` = '.$val.')' => null));

					// 삭제 로그 기록
					$logdata = array(
						'mel_med_id' => $val,
						'mel_state' => 'delete',
						'mel_mem_id' => $this->session->userdata('mem_id'),
						'mel_user_id' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
						'mel_datetime' => $datetime,
						'mel_ip' => $this->input->ip_address(),
						'mel_useragent' => $this->agent->agent_string(),
					);
					$this->RS_media_log_model->insert($logdata);
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
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}

	
	/**
	 * 화이트리스트 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_medialist_excel';
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

		$where = array();

		if(($jud_state = (int)$this->input->get('med_state')) || $this->input->get('med_state')==='0'){
			if ($jud_state >= 0) {
				$where['med_state'] = $jud_state;
			}
		}

		if ($wht_id = (int) $this->input->get('wht_id')) {
			if ($wht_id > 0) {
				$where['med_wht_id'] = $wht_id;
			}
		}
		$result = $this->{$this->modelname}
			->get_list('', '', $where, '', $findex, $forder, $sfield, $skeyword);
		
		

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['register_member'] = $dbmember = $this->Member_model->get_by_memid(element('mis_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['modifier_member'] = $dbmember = $this->Member_model->get_by_memid(element('mis_modifier_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['wht_title'] = element('wht_title',$this->RS_whitelist_model->get_one(element('med_wht_id',$val), 'wht_title', array('wht_deletion' => 'N')));
				$result['list'][$key]['med_duplicate'] = $this->RS_media_duplication_model->get_is_duplication(element('med_id', $val));
				$mediatype_join = array('table' => 'rs_mediatype', 'on' => 'rs_mediatype.met_id = rs_mediatype_map.met_id', 'type' => 'inner');
				$mediatype = element('list',$this->RS_mediatype_map_model->_get_list_common('met_title',$mediatype_join,'','', array('med_id' => element('med_id', $val))));
				$mediatype_list = '';
				foreach($mediatype as $l){
					if($mediatype_list) $mediatype_list .= ', ';
					$mediatype_list .= element('met_title',$l);
				}
				$result['list'][$key]['mediatype'] = $mediatype_list;
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
		header('Content-Disposition: attachment; filename=미디어목록_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir  . '/excel', $view, true);
	}

}
