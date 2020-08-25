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
	protected $models = array('RS_missionlist','RS_missionlist_log','RS_missionpoint', 'RS_media');

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
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		// $view['view']['sort'] = array(
		// 	'mis_id' => $param->sort('mis_id', 'asc'),
		// 	'mis_thumb_type' => $param->sort('mis_thumb_type', 'asc'),
		// 	'mis_max_point' => $param->sort('mis_max_point', 'asc'),
		// 	'percentage' => $param->sort('percentage', 'asc'),
		// 	'mis_wdate' => $param->sort('mis_wdate', 'asc'),
		// );
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
        $per_page = 10;
		$offset = ($page - 1) * $per_page;

		$result = $this->{$this->modelname}
			->get_missionlist_list($per_page, $offset, array('mis_allowed' => 1, 'mis_deletion' => 'N'), '', $findex, $forder, $sfield, $skeyword);
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
		$config['base_url'] = $this->pagedir . '?' . $param->replace('page');
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
		$view['view']['listall_url'] = $this->pagedir;
		$view['view']['write_url'] = $this->pagedir . '/write';
		$view['view']['list_update_url'] = $this->pagedir . '/listupdate/?' . $param->output();
		$view['view']['list_delete_url'] = $this->pagedir . '/listdelete/?' . $param->output();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/*
		** 어드민 레이아웃을 정의합니다
		*/
        $this->data = $view;
        echo "<pre>";
        print_r($this->data['view']['data']['list']);
        echo "</pre>";
        exit;
    }
    
    public function detailMission($misid){
        echo "<pre>";
        print_r($this->RS_missionlist_model->get_one_mission($misid));
        echo "</pre>";
    }

    public function applyMission($misid){
        $where = array(
            'mem_id' => $this->session->userdata('mem_id'),
            'med_state' => 3
		);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('med_id[]','미디어', 'required|numeric');
		if($this->form_validation->run() == FALSE){	
			$med_list = $this->RS_media_model->getMissionMedia($misid,$this->session->userdata('mem_id'));
			if($med_list){
				$page_title = $this->cbconfig->item('site_meta_title_main');
				$meta_description = $this->cbconfig->item('site_meta_description_main');
				$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
				$meta_author = $this->cbconfig->item('site_meta_author_main');
				$page_name = $this->cbconfig->item('site_page_name_main');
		
				$layoutconfig = array(
					'path' => 'mission',
					'layout' => 'layout',
					'skin' => 'applyMission',
					'layout_dir' => '/test',
					'mobile_layout_dir' => '/test',
					'use_sidebar' => $this->cbconfig->item('sidebar_main'),
					'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
					'skin_dir' => 'basic',
					'mobile_skin_dir' => 'mobile',
					'page_title' => $page_title,
					'meta_description' => $meta_description,
					'meta_keywords' => $meta_keywords,
					'meta_author' => $meta_author,
					'page_name' => $page_name,
				);
				$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
				$view['medList'] = $med_list;
				$view['missionData'] = $this->RS_missionlist_model->get_one_mission($misid);
				$view['total_super'] = $this->RS_missionlist_model->get_mission_apply_total_superpoint($misid);
				$this->data = $view;
				$this->layout = element('layout_skin_file', element('layout', $view));
				$this->view = element('view_skin_file', element('layout', $view));
			}else{
				echo "<script>alert('등록된 미디어가 없습니다. 미디어 신청페이지로 이동합니다.'); location.href='/Media/editMedia'</script>";
			}
		}else{
			$this->load->library('upload');
			$upload_path = config_item('uploads_dir') . '/applyMission/';
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
			for($i = 0; $i < count($med_id); $i++){
				$jud_insert_arr = array(
					'jud_jug_id' => 1,
					'jud_mis_id' => $misid,
					'jud_med_id' => $med_id[$i],
				);
				$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $upload_result[$i]);
			}
			echo "<pre>";
			print_r($upload_result);
			echo "</pre>";
			exit;
		}
	}
	
	private function multy_upload($files, $upload_config, $input_name){
		$this->load->library('upload');
		$num_files = count($files[$input_name]['name']);
		for($i = 0; $i < $num_files; $i++){
			$_FILES['userfile']['name'] = $_FILES[$input_name]['name'][$i];
			$_FILES['userfile']['type'] = $_FILES[$input_name]['type'][$i];
			$_FILES['userfile']['tmp_name'] = $_FILES[$input_name]['tmp_name'][$i];
			$_FILES['userfile']['error'] = $_FILES[$input_name]['error'][$i];
			$_FILES['userfile']['size'] = $_FILES[$input_name]['size'][$i];

			$this->upload->initialize($upload_config);
			if(! $this->upload->do_upload()){
				$file_data[] = array('file_name'=>'');
			}else{
				$file_data[] = $this->upload->data();
			}
		}

		return $file_data;
	}
}
