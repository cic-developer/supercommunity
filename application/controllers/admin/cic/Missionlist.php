<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Missionlist class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>미션목록 controller 입니다.
 */
class Missionlist extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/missionlist';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_missionlist','RS_missionlist_log','RS_missionpoint');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_missionlist_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array','dhtml_editor');

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
		$eventname = 'event_admin_cic_missionlist_index';
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
			'mis_id' => $param->sort('mis_id', 'asc'),
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
		$this->{$this->modelname}->allow_search_field = array('mis_title', 'mis_content','mis_per_token','mis_max_point','mis_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('mis_per_token','mis_max_point'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mis_id','mis_thumb_type','mis_per_token','mis_max_point','mis_wdate','percentage'); // 정렬이 가능한 필드


		$where = array();

		//진행중인 미션 목록
		if ($this->input->get('on_process')) {
			$where['
			CASE WHEN rs_missionlist.mis_endtype = 1 THEN
				(rs_missionlist.mis_max_point > rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
			ELSE
				CASE WHEN rs_missionlist.mis_endtype = 2 THEN
					(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
				ELSE
					CASE WHEN rs_missionlist.mis_endtype = 3 THEN
						(rs_missionlist.mis_max_point > rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
					ELSE
						(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
					END
				END
			END
			'] = NULL;
		}

		//예정중인 미션 목록
		if ($this->input->get('planned')) {
			$where['
			CASE WHEN rs_missionlist.mis_endtype = 1 THEN
				(rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
			ELSE
				CASE WHEN rs_missionlist.mis_endtype = 2 THEN
					(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
				ELSE
					CASE WHEN rs_missionlist.mis_endtype = 3 THEN
						(rs_missionlist.mis_max_point > rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
					ELSE
						(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
					END
				END
			END
			'] = NULL;
		}

		//마감된 미션 목록
		if ($this->input->get('end')) {
			$where['
			CASE WHEN rs_missionlist.mis_endtype = 1 THEN
				(rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'"))
			ELSE
				CASE WHEN rs_missionlist.mis_endtype = 2 THEN
					(rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'"))
				ELSE
					CASE WHEN rs_missionlist.mis_endtype = 3 THEN
						(rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1)
					ELSE
						(rs_missionlist.mis_end = 1)
					END
				END
			END
			'] = NULL;
		}
		$result = $this->{$this->modelname}
			->get_missionlist_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {

				/*
				** 유저 아이디 닉네임 불러오기
				*/
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('mis_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);

				/*
				** 진행률 계산
				*/
				if(element('percentage', $val)>=100)
					$result['list'][$key]['percentage'] = 100;
				else if(element('percentage', $val) == 0)
					$result['list'][$key]['percentage'] = 0;
				else
					$result['list'][$key]['percentage'] = number_format(element('percentage', $val),1);

				$result['list'][$key]['num'] = $list_num--;

				/*
				** 진행상태 한글화
				*/
				switch(element('state', $val)){
					case 'planned':
						$result['list'][$key]['state'] = '오픈예정('.date('Y-m-d',strtotime(element('mis_opendate', $val))).')';
					break;
					case 'process':
						$result['list'][$key]['state'] = '진행중';
					break;
					case 'end':
						$result['list'][$key]['state'] = '마감';
					break;
					default:
				}
			}
		}
		$view['view']['data'] = $result;

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
			'mis_title' => '제목',
			'mis_content' => '본문',
			'mis_per_token' => '지급 PER TOKEN',
			'mis_max_point' => '최대 슈퍼포인트',
			'mis_wdate' => '날짜'
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
	public function write($mid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_missionlist_write';
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
			if (empty($mid) OR $mid < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($mid) {
			$getdata = $this->{$this->modelname}->get_one_mission($mid);
		}

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */

		// 유튜브 form_validation rule
		$rule_mis_thumb_youtube = array('trim','valid_url', array('is_youtubeurl_right', array($this->{$this->modelname},'check_is_youtubeurl_right')));
		if($this->input->post('mis_thumb_type') == 2) $rule_mis_thumb_youtube[] = 'required';
		
		
		// mis_thumb_type 용 form_validation 데이터 저장
		$this->{$this->modelname}->post_thumb_data = array(
			'mid'									=> $mid,
			'get_mis_thumb_image' => element('mis_thumb_image',$getdata),
			'thumb_image' 				=> $_FILES["mis_thumb_image"],
			'thumb_youtube' 			=> $this->input->post('mis_thumb_youtube'),
			'mis_thumb_image_del' => $this->input->post('mis_thumb_image_del'),
			'mis_endtype' 				=> $this->input->post('mis_endtype'),
			'mis_opendate' 				=> $this->input->post('mis_opendate'),
			'mis_enddate' 				=> $this->input->post('mis_enddate'),
		);
		// log_message('error',$thumb_type_data);
		$config = array(
			array(
				'field' => 'mis_title',
				'label' => '제목',
				'rules' => 'trim|min_length[2]|max_length[20]|required',
			),
			array(
				'field' => 'mis_title_en',
				'label' => '영문제목',
				'rules' => 'trim|min_length[2]|max_length[20]|required',
			),
			array(
				'field' => 'mis_thumb_type',
				'label' => '썸네일 유형',
				'rules' => array('trim', 'is_natural_no_zero', 'greater_than_equal_to[1]', 'less_than_equal_to[2]', 'required', array('check_image_type',array($this->{$this->modelname},'check_thumb_data'))),
			),
			array(
				'field' => 'mis_thumb_youtube',
				'label' => '썸네일 유튜브 주소',
				'rules' => $rule_mis_thumb_youtube,
			),
			array(
				'field' => 'mis_per_token',
				'label' => '지급 PER TOKEN',
				'rules' => 'trim|is_natural|required|min_length[1]|max_length[11]',
			),
			array(
				'field' => 'mis_endtype',
				'label' => '마감유형',
				'rules' => 'trim|required|is_natural|exact_length[1]',
			),
			array(
				'field' => 'mis_max_point',
				'label' => '최대 슈퍼포인트',
				'rules' => array('trim','is_natural','required','min_length[1]','max_length[11]', array('check_endtype_sp',array($this->{$this->modelname},'check_endtype_sp'))),
			),
			array(
				'field' => 'mis_allowed',
				'label' => '노출/미노출',
				'rules' => 'trim|is_natural|greater_than_equal_to[0]|less_than_equal_to[1]|required',
			),
			array(
				'field' => 'mis_opendate',
				'label' => '오픈날짜',
				'rules' => array('trim','min_length[9]','max_length[20]', array('check_datetime',array($this->{$this->modelname},'check_datetime'))),
			),
			array(
				'field' => 'mis_enddate',
				'label' => '마감날짜',
				'rules' => array('trim','min_length[9]','max_length[20]', array('check_datetime',array($this->{$this->modelname},'check_datetime')), array('check_endtype_enddate',array($this->{$this->modelname},'check_endtype_enddate'))),
			),
			array(
				'field' => 'mis_content',
				'label' => '본문',
				'rules' => 'required',
			),
			array(
				'field' => 'mis_content_en',
				'label' => '영문본문',
				'rules' => 'required',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
		$file_error = '';
		$updatephoto = '';

		if ($form_validation) {
			$this->load->library('upload');
			if (isset($_FILES) && isset($_FILES['mis_thumb_image']) && isset($_FILES['mis_thumb_image']['name']) && $_FILES['mis_thumb_image']['name']) {
				$upload_path = config_item('uploads_dir') . '/mission_thumb_img/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				$upload_path .= cdate('Y') . '/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}
				$upload_path .= cdate('m') . '/';
				if (is_dir($upload_path) === false) {
					mkdir($upload_path, 0707);
					$file = $upload_path . 'index.php';
					$f = @fopen($file, 'w');
					@fwrite($f, '');
					@fclose($f);
					@chmod($file, 0644);
				}

				$uploadconfig = array();
				$uploadconfig['upload_path'] = $upload_path;
				$uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
				$uploadconfig['max_size'] = '20000';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);

				if ($this->upload->do_upload('mis_thumb_image')) {
					$img = $this->upload->data();
					$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
				} else {
					$file_error = $this->upload->display_errors();

				}
			}
		}
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($form_validation === false OR $file_error !== '') {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			$view['view']['message'] = $file_error;

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
			$layoutconfig = array('layout' => 'layout', 'skin' => 'write');
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
				'mis_title' => $this->input->post('mis_title', null, ''),
				'mis_title_en' => $this->input->post('mis_title_en', null, ''),
				'mis_thumb_type' => $this->input->post('mis_thumb_type', null, 1),
				'mis_thumb_youtube' => $this->input->post('mis_thumb_youtube', null, ''),
				'mis_endtype' => $this->input->post('mis_endtype', null, ''),
				'mis_per_token' => $this->input->post('mis_per_token', null, ''),
				'mis_left_token' => $this->input->post('mis_per_token', null, ''),
				'mis_max_point' => $this->input->post('mis_max_point', null, ''),
				'mis_allowed' => $this->input->post('mis_allowed', null, 1),
				'mis_opendate' => $this->input->post('mis_opendate', null, ''),
				'mis_enddate' => $this->input->post('mis_enddate', null, ''),
				'mis_content' => $this->input->post('mis_content', null, ''),
				'mis_content_en' => $this->input->post('mis_content_en', null, ''),
			);
			// print_r($this->input->post('mis_content_en', null, ''));
			// exit;
			if ($this->input->post('mis_thumb_image_del')) {
				$updatedata['mis_thumb_image'] = '';
			} elseif ($updatephoto) {
				$updatedata['mis_thumb_image'] = $updatephoto;
			}
			if (element('mis_thumb_image', $getdata) && ($this->input->post('mis_thumb_image_del') OR $updatephoto)) {
				// 기존 파일 삭제
				@unlink(config_item('uploads_dir') . '/mission_thumb_img/' . element('mis_thumb_image', $getdata));
			}
			$datetime = cdate('Y-m-d H:i:s');

			// 작성/수정 로그 기록
			$logdata = array(
				'mil_mem_id' => $this->session->userdata('mem_id'),
				'mil_userid' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
				'mil_datetime' => $datetime,
				'mil_ip' => $this->input->ip_address(),
				'mil_data' => json_encode($updatedata,JSON_UNESCAPED_UNICODE),
				'mil_useragent' => $this->agent->agent_string(),
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$updatedata['mis_mdate'] = $datetime;
				$updatedata['mis_modifier_mem_id'] = $this->session->userdata('mem_id');
				$updatedata['mis_modifier_ip'] = $this->input->ip_address();
				$wht_id = $this->input->post($primary_key);
				$this->{$this->modelname}->update($wht_id, $updatedata);
				
				// 수정 로그 기록
				$logdata['mil_state'] = 'update';
				$logdata['mil_mis_id'] = $wht_id;
				$this->RS_missionlist_log_model->insert($logdata);

				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				$updatedata['mis_end'] = 0;
				$updatedata['mis_wdate'] = $datetime;
				$updatedata['mis_mem_id'] = $this->session->userdata('mem_id');
				$updatedata['mis_deletion'] = 'N';
				$updatedata['mis_register_ip'] = $this->input->ip_address();

				$mis_id = $this->{$this->modelname}->insert($updatedata);
				
				// 작성 로그 기록
				$logdata['mil_state'] = 'new';
				$logdata['mil_mis_id'] = $mis_id;
				$this->RS_missionlist_log_model->insert($logdata);

				//rs_missionpoint 등록
				$mipdata = array(
					'mip_mis_id' => $mis_id,
					'mip_tpoint' => 0,
				);
				$this->RS_missionpoint_model->insert($mipdata);

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
			$redirecturl = admin_url($this->pagedir . '?' . $param->output());

			redirect($redirecturl);
		}
	}

	/**
	 * 화이트리스트 목록 페이지에서 선택삭제를 하는 경우 실행되는 메소드입니다
	 */
	public function listdelete()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_missionlist_listdelete';
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
					
					// $deletewhere = array(
					// 	'mis_id' => $val,
					// );
					// $this->{$this->modelname}->delete_where($deletewhere);
					$update = array(
						'mis_deletion' => 'Y'
					);
					$this->{$this->modelname}->update($val,$update);
					
					$deletewhere = array(
						'mip_mis_id' => $val,
					);
					$this->RS_missionpoint_model->delete_where($deletewhere);

					// 삭제 로그 기록
					$logdata = array(
						'mil_mis_id' => $val,
						'mil_state' => 'delete',
						'mil_mem_id' => $this->session->userdata('mem_id'),
						'mil_userid' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
						'mil_datetime' => $datetime,
						'mil_ip' => $this->input->ip_address(),
						'mil_useragent' => $this->agent->agent_string(),
					);
					$this->RS_missionlist_log_model->insert($logdata);
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
		$eventname = 'event_admin_cic_missionlist_excel';
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

		//진행중인 미션 목록
		if ($this->input->get('on_process')) {
			$where['
			CASE WHEN rs_missionlist.mis_endtype = 1 THEN
				(rs_missionlist.mis_max_point > rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
			ELSE
				CASE WHEN rs_missionlist.mis_endtype = 2 THEN
					(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
				ELSE
					CASE WHEN rs_missionlist.mis_endtype = 3 THEN
						(rs_missionlist.mis_max_point > rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
					ELSE
						(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate < "'.cdate('Y-m-d H:i:s').'")
					END
				END
			END
			'] = NULL;
		}

		//예정중인 미션 목록
		if ($this->input->get('planned')) {
			$where['
			CASE WHEN rs_missionlist.mis_endtype = 1 THEN
				(rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
			ELSE
				CASE WHEN rs_missionlist.mis_endtype = 2 THEN
					(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_enddate > "'.date('Y-m-d H:i:s').'" AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
				ELSE
					CASE WHEN rs_missionlist.mis_endtype = 3 THEN
						(rs_missionlist.mis_max_point > rs_missionpoint.mip_tpoint AND rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
					ELSE
						(rs_missionlist.mis_end = 0 AND rs_missionlist.mis_opendate >= "'.cdate('Y-m-d H:i:s').'")
					END
				END
			END
			'] = NULL;
		}

		//마감된 미션 목록
		if ($this->input->get('end')) {
			$where['
			CASE WHEN rs_missionlist.mis_endtype = 1 THEN
				(rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'"))
			ELSE
				CASE WHEN rs_missionlist.mis_endtype = 2 THEN
					(rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'"))
				ELSE
					CASE WHEN rs_missionlist.mis_endtype = 3 THEN
						(rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1)
					ELSE
						(rs_missionlist.mis_end = 1)
					END
				END
			END
			'] = NULL;
		}
		$result = $this->{$this->modelname}
			->get_missionlist_list('', '', $where, '', $findex, $forder, $sfield, $skeyword);

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
	public function ajax_finish_mission(){

		/*
		** Validation 라이브러리를 가져옵니다
		*/
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mid', 'MID', 'trim|is_natural|required|min_length[1]|max_length[11]');
		$this->form_validation->set_rules('finish', 'FINISH', 'trim|is_natural|required|in_list[0,1]');
		$form_validation = $this->form_validation->run();
		/*
		** mis_id 값을 전송하지 않은 경우
		*/
		if($form_validation === false){
			$this->form_validation->set_error_delimiters('', '');
			$return = array(
				'type' => 'error',
				// 'data' => 'mid_missing'
				'data' => $this->form_validation->error_string('','')
			);
			echo json_encode($return,JSON_UNESCAPED_UNICODE);
			exit;

		} else {
			$mid = $this->input->post('mid');
			$getdata = $this->{$this->modelname}->get_one_mission($mid);
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
			** 이미 미션이 마감된 경우
			*/
			if(element('mis_end',$getdata) == $this->input->post('finish')){
				$return = array(
					'type' => 'error',
					'data' => 'already_done'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}

			$update = array(
				'mis_end' => $this->input->post('finish')
			);
			if($this->{$this->modelname}->update($mid, $update)){
				/*
				** 정상 마감처리 된 경우
				*/
				$return = array(
					'type' => 'success',
					'data' => 'updated'
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
