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
class Mission extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = '/Mission';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_missionlist','RS_missionlist_log','RS_missionpoint', 'RS_media', 'RS_judge');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_missionlist_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array','dhtml_editor','url');

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
	public function index(){
		//페이지별 언어팩 로드
		if($this->cbconfig->get_device_view_type() == 'mobile'){
			$this->lang->load('cic_cic_pershouting_mobile_mission_list', $this->session->userdata('lang'));
		}else{
			$this->lang->load('cic_cic_pershouting_mission_list', $this->session->userdata('lang'));
		}
		
		//기존 검색
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
        $per_page = 10;
		$offset = ($page - 1) * $per_page;
		$where = array('mis_allowed' => 1, 'mis_deletion' => 'N');
		$result = $this->{$this->modelname}->get_missionlist_list($per_page, $offset, $where , '', $findex, $forder, $sfield, $skeyword);
		//기존 검색

		//조건이 존재하는 경우 검색 한번 더 추가
		$state = element('state',$this->input->get());
		$search = element('search',$this->input->get());
		if($state || $search){
			$result =$this->{$this->modelname}->get_clientMissionlist($per_page, $offset, $state, $search);
		}
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
						$result['list'][$key]['state'] = $this->lang->line('c_2');
					break;
					case 'process':
						$result['list'][$key]['state'] = $this->lang->line('c_3');
					break;
					case 'end':
						$result['list'][$key]['state'] = $this->lang->line('c_1');
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
		$config['base_url'] = $this->pagedir . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;
		$view['header']['menu'] = 'pershouting';

		// 이벤트가 존재하면 실행합니다
		// $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		
		$layoutconfig = array(
			'path' => 'cic_pershouting',
			'layout' => 'layout',
			'skin' => 'mission_list',
			'layout_dir' => '/rsteam_cic_main',
			'mobile_layout_dir' => '/rsteam_cic_mobile',
			'use_sidebar' => $this->cbconfig->item('sidebar_main'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
			'skin_dir' => 'rsteam_cic',
			'mobile_skin_dir' => 'rsteam_cic_mobile',
			// 'page_title' => $page_title,
			// 'meta_description' => $meta_description,
			// 'meta_keywords' => $meta_keywords,
			// 'meta_author' => $meta_author,
			// 'page_name' => $page_name,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	function myMission(){
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		if(!$this->member->is_member()){
			$this->session->set_flashdata('message',$this->lang->line('require_login'));
			redirect('/login');
		}

		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_mymission', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_mymission', $this->session->userdata('lang'));
		}
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		$per_page = !$this->agent->is_mobile() ? 10 : 5;
		$offset = ($page - 1) * $per_page;
		$mem_id = $this->session->userdata('mem_id');
		$join = array(
			array(
				'table' => 'rs_missionlist',
				'on' 	=> 'rs_missionlist.mis_id = rs_judge.jud_mis_id'
			),
			array(
				'table' => 'rs_judge_denied',
				'on'	=> 'rs_judge.jud_id = rs_judge_denied.judn_jud_id'
			)
		);

		$result = $this->RS_judge_model->_get_list_common( 
			'', $join, $per_page, $offset, array('jud_mem_id' => $mem_id, 'jud_deletion' => 'N', 'jud_jug_id' => 1), '',$findex, $forder, $sfield, $skeyword
		);

		foreach ($result['list'] as $key => $val) {
			switch($result['list'][$key]['jud_state']){
				case 0 :
					$jud_kr_state = $this->lang->line('c_1');
				break;
				case 1 :
					$jud_kr_state = $this->lang->line('c_2');
				break;
				case 3 :
					$jud_kr_state = $this->lang->line('c_3');
				break;
				case 5 :
					$jud_kr_state = $this->lang->line('c_4');
				break;
			}
			$result['list'][$key]['jud_ko_state'] =  $jud_kr_state;
		
			$result['list'][$key]['jud_expected_value'] = $result['list'][$key]['jud_point'];

			$mission_data	= $this->RS_missionlist_model->get_one($result['list'][$key]['jud_mis_id']);
			$mis_per_token  = $mission_data['mis_per_token'];
			$mis_max_point	= $mission_data['mis_max_point'];
			$media_super_point = $result['list'][$key]['jud_superpoint'];
			$result['list'][$key]['jud_expected_value'] = rs_cal_expected_point2($mis_per_token, $mis_max_point, $media_super_point, $result['list'][$key]);
		}
		
		$view['view']['judList'] = $result['list'];

		/*
		** primary key 정보를 저장합니다
		*/
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/*
		** 페이지네이션을 생성합니다
		*/
		$config['base_url'] = $this->pagedir . '/myMission?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$view['header']['menu'] = 'mypage';
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		// 이벤트가 존재하면 실행합니다
		// $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
		
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_main');
		$meta_description = $this->cbconfig->item('site_meta_description_main');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
		$meta_author = $this->cbconfig->item('site_meta_author_main');
		$page_name = $this->cbconfig->item('site_page_name_main');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'mymission',
			'layout_dir' => '/rsteam_cic_mypage',
			'mobile_layout_dir' => '/rsteam_cic_mobile',
			'use_sidebar' => $this->cbconfig->item('sidebar_main'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
			'skin_dir' => 'rsteam_cic',
			'mobile_skin_dir' => 'rsteam_cic_mobile',
			'page_title' => $page_title,
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => $page_name,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['total_super'] = $this->RS_media_model->get_total_super($mem_id);
		$view['header']['menu'] = 'mypage';
		$view['member_data'] = $this->member->get_member();
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	//미션 상세 페이지
    public function detailMission($misid){
		// 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_cic_pershouting_mobile_mission_detail', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_cic_pershouting_mission_detail', $this->session->userdata('lang'));
		}

		// 해당 미션 정보를 가져옴
		$view['mission_data'] = $this->RS_missionlist_model->get_one_mission($misid);
		if($view['mission_data']['state'] == 'planned'){
			$this->session->set_flashdata('message', $this->lang->line('c_1')); //공개예정 미션은 보지 못하도록 튕겨낸다.
			redirect('/Mission');
			exit;
		}else if($view['mission_data']['state'] == 'end'){
			$this->session->set_flashdata('message', $this->lang->line('c_2')); //마감 미션은 보지 못하도록 튕겨낸다.
			redirect('/Mission');
			exit;
		}else if(!$view['mission_data']){
			redirect('/Mission');
			exit;
		}

		$layoutconfig = array(
			'path' => 'cic_pershouting',
			'layout' => 'layout',
			'skin' => 'mission_detail',
			'layout_dir' => '/rsteam_cic_main',
			'mobile_layout_dir' => '/rsteam_cic_mobile',
			'use_sidebar' => $this->cbconfig->item('sidebar_main'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
			'skin_dir' => 'rsteam_cic',
			'mobile_skin_dir' => 'rsteam_cic_mobile',
			// 'page_title' => $page_title,
			// 'meta_description' => $meta_description,
			// 'meta_keywords' => $meta_keywords,
			// 'meta_author' => $meta_author,
			// 'page_name' => $page_name,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['header']['menu'] = 'pershouting';
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

    public function applyMission($misid){

		if($this->agent->is_mobile()){
			$this->lang->load('cic_cic_pershouting_mobile_mission_apply', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_cic_pershouting_mission_apply', $this->session->userdata('lang'));
		}
		if(!$this->member->is_member()){
			$this->session->set_flashdata('message',$this->lang->line('require_login'));
			redirect('/login');
		}
		$mission_data = $this->RS_missionlist_model->get_one_mission($misid);
		if(!$mission_data){
			redirect('/Mission');
		}
		// print_r($mission_data['state']); exit;
		if($mission_data['state'] != 'process'){
			$this->session->set_flashdata('message', $this->lang->line('c_1'));
			redirect('/Mission');
			exit;
		}
		$mem_id = $this->session->userdata('mem_id');
        $where = array(
            'mem_id' => $mem_id,
            'med_state' => 3
		);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('med_id[]',$this->lang->line('c_3'), 'required|numeric');
		if($this->form_validation->run() == FALSE){	
			if($this->input->post('dummy')){
				echo "<script>alert('".$this->lang->line('c_10')."')</script>";
			}
			$med_list = $this->RS_media_model->getMissionMedia($misid,$mem_id, $mission_data['mis_apply_wht_id']);
			if($med_list){ 
				$page_title = $this->cbconfig->item('site_meta_title_main');
				$meta_description = $this->cbconfig->item('site_meta_description_main');
				$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
				$meta_author = $this->cbconfig->item('site_meta_author_main');
				$page_name = $this->cbconfig->item('site_page_name_main');
		
				$layoutconfig = array(
					'path' => 'cic_pershouting',
					'layout' => 'layout',
					'skin' => 'mission_apply',
					'layout_dir' => '/rsteam_cic_mypage',
					'mobile_layout_dir' => '/rsteam_cic_mobile',
					'use_sidebar' => $this->cbconfig->item('sidebar_main'),
					'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
					'skin_dir' => 'rsteam_cic',
					'mobile_skin_dir' => 'rsteam_cic_mobile',
					'page_title' => $page_title,
					'meta_description' => $meta_description,
					'meta_keywords' => $meta_keywords,
					'meta_author' => $meta_author,
					'page_name' => $page_name,
				);
				$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
				$view['medList'] = $med_list;
				$view['member_data'] = $this->Member_model->get_by_memid($mem_id);
				$view['total_super'] = $this->RS_media_model->get_total_super($mem_id);
				$view['mis_total_super'] = $this->RS_missionpoint_model->get_one('','',array('mip_mis_id' => $misid))['mip_tpoint'];
				// echo $this->db->last_query(); exit;
				$view['missionData'] = $mission_data;
				$view['header']['menu'] = 'pershouting';
				$this->data = $view;
				$this->layout = element('layout_skin_file', element('layout', $view));
				$this->view = element('view_skin_file', element('layout', $view));
			 }else{
				$this->session->set_flashdata('message',$this->lang->line('c_4'));
				redirect('/Media/editMedia');
				exit;
			 }
		}else{
			$this->load->library('upload');
			$upload_path = config_item('uploads_dir') . '/judge/';
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
			$uploadconfig['allowed_types'] = 'jpg|jpeg|png';
			$uploadconfig['max_size'] = '20000';
			$uploadconfig['encrypt_name'] = true;

			$upload_result = $this->multy_upload($_FILES, $uploadconfig,'jud_attach');
			$med_id = $this->input->post('med_id');
			$all_med_id = $this->input->post('all_med_id');
			$jud_post_link = $this->input->post('post_link');
			$jud_insert_arr = array();
			for($i = 0; $i < count($all_med_id); $i++){
				if(in_array($all_med_id[$i],$med_id)){
					$jud_insert_arr[] = array(
						'jud_jug_id' => 1,
						'jud_mis_id' => $misid,
						'jud_med_id' => $all_med_id[$i],
						'jud_attach' => element('file_name', $upload_result['list'][$i]) ? (cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $upload_result['list'][$i])) : '',
						'jud_post_link' => htmlspecialchars($jud_post_link[$i], ENT_QUOTES, 'UTF-8')
					);
				}
			}

			$result = $this->RS_judge_model->replace_apply_mission_judge($jud_insert_arr);
	
			// print_r($result);
			// exit;

			$message = $this->lang->line('c_2');
			
			if($upload_result['err_count'] == $upload_result['all_count']){
				$message = $this->lang->line('c_10');
			}
			if(strcmp($result,'not found member data') == 0){
				$message = $this->lang->line('c_5');
			}
			if(strcmp ($result,'mission over max point') == 0 || strcmp ($result, 'mission already over') == 0){
				$message = $this->lang->line('c_7');
				
			}
			if(strcmp ($result,'jud_attach update error occur') == 0){
				$message = $this->lang->line('c_9');
			}
			if(
				strcmp ($result ,'error occur for check other judge') == 0 ||
				strcmp ($result ,'미디어심사 진행중입니다.')  == 0 ||
				strcmp ($result , '출금심사 진행중입니다.') == 0 ||
				strcmp ($result ,'미디어 재심사 진행중입니다.') == 0 ||
				strcmp ($result , 'Media review is in progress.') == 0||
				strcmp ($result , 'The withdrawal examination is in progress.') == 0||
				strcmp ($result , 'Media review is in progress.') == 0
			){
				$message = $this->lang->line('c_6');
			}

			$this->session->set_flashdata('message',$message);
			redirect('/Mission/detailMission/'.$misid);
		}
	}
	
	private function multy_upload($files, $upload_config, $input_name){
		$this->load->library('upload');
		$num_files = count($files[$input_name]['name']);
		$err_count = 0;
		$all_count = $num_files;
		$file_data = array();
		for($i = 0; $i < $num_files; $i++){
			$_FILES['userfile']['name'] = $_FILES[$input_name]['name'][$i];
			$_FILES['userfile']['type'] = $_FILES[$input_name]['type'][$i];
			$_FILES['userfile']['tmp_name'] = $_FILES[$input_name]['tmp_name'][$i];
			$_FILES['userfile']['error'] = $_FILES[$input_name]['error'][$i];
			$_FILES['userfile']['size'] = $_FILES[$input_name]['size'][$i];

			$this->upload->initialize($upload_config);
			if(! $this->upload->do_upload()){
				$file_data['list'][] = array('file_name'=>'');
				$err_count++;
			}else{
				$file_data['list'][] = $this->upload->data();
			}
		}
		$file_data['err_count'] = $err_count;
		$file_data['all_count'] = $all_count;
		return $file_data;
	}
}
