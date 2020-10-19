<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CB_Controller
{
	protected $models = array('Board','RS_media','RS_whitelist', 'RS_judge', 'RS_judge_log', 'RS_mediatype', 'RS_mediatype_map');
	protected $helpers = array('form', 'array','url');
    protected $librarys = array('session');

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('querystring'));
		if(!$this->session->userdata('mem_id')){
			redirect('/');
		}
	}

	function myMedia(){
		$mem_id = $this->session->userdata('mem_id');
		if(!$mem_id){
			redirect('/');
			exit;
		}
		$member_data = $this->Member_model->get_by_memid($this->session->userdata('mem_id'));
		$mediadata = $this->RS_media_model->get('', '', array('mem_id' => $mem_id, 'med_deletion' => 'N'), '', 0 ,'med_wdate','DESC');
		$total_super = $this->RS_media_model->get_total_super($mem_id);
		
		if($mediadata){
			// skin => mymedia
			$_skin = 'mymedia';
			//페이지별 언어팩 로드
			if($this->agent->is_mobile()){
				$this->lang->load('cic_mypage_mobile_mymedia', $this->session->userdata('lang'));
			} else {
				$this->lang->load('cic_mypage_mymedia', $this->session->userdata('lang'));
			}
		} else {
			// skin => mymidea_no
			$_skin = 'mymedia_no';
			//페이지별 언어팩 로드
			if($this->agent->is_mobile()){
				$this->lang->load('cic_mypage_mobile_mymedia_no', $this->session->userdata('lang'));
			} else {
				$this->lang->load('cic_mypage_mymedia_no', $this->session->userdata('lang'));
			}
		}
		
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
			'skin' => $_skin,
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
		$view['media_data'] = $mediadata;
		$view['member_data'] = $member_data;
		$view['total_super'] = $total_super;
		$view['header']['menu'] = 'mypage';

		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	//퍼블리싱 테스트용 미디어가 없는경우
	function myMedia_no(){
		$mem_id = $this->session->userdata('mem_id');
		// if(!$mem_id){
		// 	redirect('/');
		// 	exit;
		// }
		$member_data = $this->Member_model->get_by_memid($mem_id);
		$mediadata = $this->RS_media_model->get('', '', array('mem_id' => $mem_id), '', 0, '', '');
		
		if($message){ echo "<script>alert('".$message."')</script>";}
		
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
			'skin' => 'mymedia_no',
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
		$total_super = $this->RS_media_model->get_total_super($mem_id);
		$member_data = $this->Member_model->get_by_memid($this->session->userdata('mem_id'));
		$view['member_data'] = $member_data;
		$view['total_super'] = $total_super;
		$view['header']['menu'] = 'mypage';
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	function editMedia($med_id = 0){	// 미디어 등록, 수정
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_mymedia_add', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_mymedia_add', $this->session->userdata('lang'));
		}
		$mem_id = $this->session->userdata('mem_id');
		if(!$mem_id){
			redirect('/');
			exit;
		}
		$_skin = 'mymedia';
		$this->load->library('form_validation');
		$this->RS_media_model->set_wht_id = $this->input->post('wht_list');
		$this->form_validation->set_rules('wht_list',$this->lang->line('controller_0'), 'required');
		// $this->form_validation->set_rules('med_url',$this->lang->line('controller_1'), 'required|min_length[10]|max_length[255]|prep_url');
		$this->form_validation->set_rules('med_url','URL', array('required','min_length[10]','max_length[255]','prep_url', array('callback_url_check',array($this->RS_media_model,'callback_url_check'))));
		$this->form_validation->set_rules('med_admin',$this->lang->line('controller_2'), 'required|min_length[2]|max_length[30]');
		$this->form_validation->set_rules('med_name',$this->lang->line('controller_3'), 'required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('met_type[]',$this->lang->line('controller_4'), 'required|numeric');

		if($this->form_validation->run() == FALSE){	// 만일 form_validation을 만족하지 못하는 경우 다시 입력폼 창으로
			if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
			}
			if($med_id){
				$mem_id = $this->session->userdata('mem_id');
				$datas = $this->RS_media_model->get('', '', array('med_id' => $med_id, 'mem_id' => $mem_id));
				$view['mem_data'] = $this->Member_model->get_by_memid($mem_id);
				$view['med_list'] = $datas['med_list'];
			}else{
				$view['mem_data'] = array();
				$view['med_list'] = array();
			}
			$view['white_list'] = $this->RS_whitelist_model->get_whitelist_list()['list'];
			$view['media_type_list'] = $this->RS_mediatype_model->get('', 'met_id, met_title, met_title_en', array('met_deletion' => 'N'));
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
				'skin' => 'mymedia_add',
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
			$total_super = $this->RS_media_model->get_total_super($mem_id);
			$member_data = $this->Member_model->get_by_memid($this->session->userdata('mem_id'));
			$view['member_data'] = $member_data;
			$view['total_super'] = $total_super;
			$view['header']['menu'] = 'mypage';
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}else{	// form_validation을 만족하는 경우 미디어 등록
			//파일 업로드 시작
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
		
			$this->upload->initialize($uploadconfig);
			if ($this->upload->do_upload('jud_attach')) {
				$img = $this->upload->data();
				$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
			} else {
				$file_error = $this->upload->display_errors();
				$updatephoto = '';
			}

			$postData = $this->input->post();
			$postData['jud_attach'] = $updatephoto;
			$this->registMedia($med_id, $postData);
			redirect('/Media/myMedia');
		}
	}

	function deleteMedia($med_id){
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_mymedia', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_mymedia', $this->session->userdata('lang'));
		}
		$mem_id = $this->session->userdata('mem_id');
		$result = $this->RS_media_model->update($med_id,"med_state = 0, med_deletion = 'Y'", 'mem_id = '.$mem_id);
		if($result){
			$message = $this->lang->line('controller_0');
		}else{
			$message = $this->lang->line('controller_1');
		}
		$this->session->set_flashdata('message', $message);
		redirect('/Media/mymedia');
	}
	/* 	
	**  미디어 등록 로직 함수, 너무 길어질거같아서 따로 빼놈
	**	media id가 있는경우 update, 0이면 insert하여 
	**	update or insert 된 media의 id 값 가져옴 
	*/
	private function registMedia($med_id = 0, $postData = array()){	
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_mymedia_add', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_mymedia_add', $this->session->userdata('lang'));
		}

		$mem_id = $this->session->userdata('mem_id');
		if(!$mem_id){
			redirect('/');
			exit;
		}
		$now = date('Y-m-d H:i:s');
		$_ip = $this->input->ip_address();
		$mem_data =  $this->Member_model->get_by_memid($this->session->userdata('mem_id'));

		$insertArr = array();
		if($med_id){
			$insertArr['med_id']		= $med_id;
		}
		if(element('med_state',$postData)){	//상태값 지정이 되면 상태값 추가
			$insertArr['med_state'] = element('med_state',$postData);
		}
		if(element('med_textarea',$postData)){	//메모 사항이 있으면 추가
			$insertArr['med_textarea'] = element('med_textarea',$postData);
		}
		//---------- 여긴 무조건 있어야 하는 값들 ----------------
		$insertArr['med_wht_id'] 	= element('wht_list',$postData);
		$insertArr['med_name'] 		= element('med_name',$postData);
		$insertArr['med_admin']		= element('med_admin',$postData);
		$insertArr['med_url'] 		= element('med_url',$postData);
		$insertArr['mem_id']		= $this->session->userdata('mem_id');
		$insertArr['med_ip']		= $_ip;
		$insertArr['mem_nickname']  = $mem_data['mem_nickname'];
		//---------------------------------------------------------
		$this->db->trans_start();
		$result = $this->RS_media_model->registMedia($insertArr);

		if(
			strcmp ($result , '미션심사 진행중입니다.') == 0||
			strcmp ($result , '미디어심사 진행중입니다.') == 0 ||
			strcmp ($result , '출금심사 진행중입니다.') == 0 ||
			strcmp ($result , '미디어 재심사 진행중입니다.') == 0 ||
			strcmp ($result , 'Mission review in progress.') == 0||
			strcmp ($result , 'Media review is in progress.') == 0||
			strcmp ($result , 'The withdrawal examination is in progress.') == 0||
			strcmp ($result , 'Mission re-evaluation is in progress.') == 0
 		){
			$this->session->set_flashdata('message', $this->lang->line('already_judge'));
			return;
		}

	
		// print_r($result);
		// print_r($this->db->last_query());
		// exit;
		$message = $this->lang->line('controller_5');

		if($result != 'not_matched_white_list' && $result){	// 미디어 등록 또는 수정에 성공한 경우
			$met_list = element('met_type',$postData);
			$met_data = array();
			if($met_list){	//미디어 type에 관한 리스트가 있는 경우에만 등록 없으면 그냥 진행(관리자에서 미디어 타입 등록을 하나도 안해놨을 경우에 대비)
				foreach($met_list AS $met){
					$met_data[] = array(
						'med_id' => $result,
						'met_id' => $met
					);
				}
				$met_result = $this->RS_mediatype_map_model->insert_batch($met_data);
			}else{
				$met_result = true;
			}

			//미디어 심사에 추가 로직 시작
			$jug_id = $med_id ? 4 : 2;
			$judgeArr = array(
				'jud_jug_id' 		=> $jug_id,
				'jud_med_id'		=> $result,
				'jud_state'			=> 1,
				'jud_deletion'		=> 'N',
				'jud_med_wht_id'	=> $insertArr['med_wht_id'],
				'jud_med_name'		=> $insertArr['med_name'],
				'jud_med_admin' 	=> $insertArr['med_admin'],
				'jud_med_url'		=> $insertArr['med_url'],
				'jud_wdate'			=> $now,
				'jud_mem_id'		=> $insertArr['mem_id'],
				'jud_mem_nickname'	=> $mem_data['mem_nickname'],
				'jud_register_ip'	=> $_ip,
				'jud_textarea'		=> element('med_textarea', $postData),
				'jud_attach'		=> element('jud_attach', $postData)
			);
			$judge_id = $this->RS_judge_model->insert($judgeArr);

			$judgeLogArr = array(
				'jul_jug_id'	=> $jug_id,
				'jul_med_id'	=> $result,
				'jul_jud_id'	=> $judge_id,
				'jul_state'		=> 1,
				'jul_mem_id'	=> $insertArr['mem_id'],
				'jul_user_id'	=> $mem_data['mem_userid'],
				'jul_datetime'	=> $now,
				'jul_ip'		=> $_ip,
				'jul_useragent'	=> $this->agent->agent_string(),
				'jul_data'		=> json_encode($judgeArr)
			);
			$judge_log_id =  $this->RS_judge_log_model->insert($judgeLogArr);
			if($judge_id && $judge_log_id && $met_result){
				$this->db->trans_complete();
				$message = $med_id ? $this->lang->line('controller_6') : $this->lang->line('controller_7');
			}
			//미디어 심사에 추고 로직 끝
		}else{
			if($result == 'not_matched_white_list'){
				$message = $this->lang->line('controller_8');
			}
		}
		$this->session->set_flashdata('message', $message);
		// return $result;
	}

	function increaseMedia($med_id = 0){	// 미디어 증액 요청
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_mymedia_increase', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_mymedia_increase', $this->session->userdata('lang'));
		}

		$check_judge = $this->RS_media_model->check_other_judge($med_id);
		if($check_judge){
			$this->session->set_flashdata('message',$check_judge);
			redirect('/Media/mymedia');
			exit;
		}

		$mem_id = $this->session->userdata('mem_id');
		if(!$mem_id || !$med_id){
			redirect('/');
			exit;
		}
		//라이브러리 로드
		$this->load->library('form_validation');
		$this->load->library('upload');

		$this->form_validation->set_rules('wht_list',$this->lang->line('controller_0'), 'required');
		$this->form_validation->set_rules('med_url',$this->lang->line('controller_1'), 'required|min_length[10]|max_length[255]|prep_url');
		$this->form_validation->set_rules('med_admin',$this->lang->line('controller_2'), 'required|min_length[2]|max_length[10]');
		$this->form_validation->set_rules('med_name',$this->lang->line('controller_3'), 'required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('med_textarea',$this->lang->line('controller_4'), 'required|min_length[3]|max_length[1000]'); 

		if($this->form_validation->run() == FALSE){	// 만일 form_validation을 만족하지 못하는 경우 다시 입력폼 창으로
			if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
			}

			$datas = $this->RS_media_model->get('', '', array('med_id' => $med_id, 'mem_id' => $mem_id));
			
			$view['mem_data'] = $this->Member_model->get_by_memid($mem_id);
			$view['white_list'] = $this->RS_whitelist_model->get_whitelist_list()['list'];
			$view['media_type_list'] = $this->RS_mediatype_model->get('', 'met_id, met_title, met_title_en ', array('met_deletion' => 'N'));
			$join = array('table' => 'rs_whitelist','on' => 'rs_media.med_wht_id = rs_whitelist.wht_id','type' => 'inner');
			$view['media_data'] = $this->RS_media_model->get_one('','',array('med_id' => $med_id, 'mem_id' => $mem_id), $join);
			if(!$view['media_data']){	//자기 자신에 대한 미디어가 아닌 경우
				$this->session->set_flashdata('message', $this->lang->line('controller_5'));
			 	redirect('/Media/myMedia');
			}

			//만일 미디어가 승인 상태가 아닌경우 redirect로 튕김
			// 지금 이 코드를 풀면 승인상태인 미디어가 없어서 코딩이 불가능! 나중에 꼭 풀기!
			if($view['media_data']['med_state'] != 3){
				$this->session->set_flashdata('message', $this->lang->line('controller_5'));
				redirect('/Media/myMedia');
			}

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
				'skin' => 'mymedia_increase',
				'layout_dir' => '/rsteam_cic_main',
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
			$view['member_data'] = $this->Member_model->get_by_memid($this->session->userdata('mem_id'));
			$view['total_super'] = $this->RS_media_model->get_total_super($mem_id);
			$view['header']['menu'] = 'mypage';
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}else{	// form_validation을 만족하는 경우 미디어 등록
			//미디어가 어떤종류든간의  심사가 진행중일 경우 체크
			$other_judge = $this->RS_media_model->check_other_judge($med_id);
			if($other_judge){
				if($other_judge === true){
					$this->session->set_flashdata('message', $this->lang->line('controller_6'));
				}else{
					$this->session->set_flashdata('message', $other_judge);
				}
				redirect('/Media/myMedia');
				exit;
			}

			//파일 업로드 시작
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

			$this->upload->initialize($uploadconfig);
			if ($this->upload->do_upload('jud_attach')) {
				$img = $this->upload->data();
				$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
			} else {
				$file_error = $this->upload->display_errors();
				$updatephoto = '';
			}
			//파일 업로드 끝

			$postData = $this->input->post();
			$mediaArr = array(
				'med_name'	=> $postData['med_name'],
				'med_admin' => $postData['med_admin'],
				'med_url'	=> $postData['med_url'],
				'med_textarea' => $postData['med_textarea'],
				'wht_list'	=> $postData['wht_list'],
				'med_state'		=> 1,
				'jud_attach' => $updatephoto
			);
			$this->registMedia($med_id, $mediaArr);
			redirect('/Media/myMedia');
		}
	}
}