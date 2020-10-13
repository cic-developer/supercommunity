<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Advertisementlist class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>광고등록 controller 입니다.
 */
class Advertisementlist extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/advertisementlist';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_advertise');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_advertise_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'rs_common');

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
		$eventname = 'event_admin_cic_advertisementlist_index';
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
		$view['view']['sort'] = array(
			'ad_id' => $param->sort('ad_id', 'asc'),
			'ad_wdate' => $param->sort('ad_wdate', 'asc'),
			'ad_state' => $param->sort('ad_state', 'asc')
		);

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('ad_memo', 'ad_type'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('ad_type'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('ad_id'); // 정렬이 가능한 필드
		$result = $this->{$this->modelname}
			->get_admin_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('ad_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
				);
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
		$search_option = array('ad_memo' => '메모사항');
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
	 * 미션추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function write($pid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_advertisementlist_write';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($pid) {
			$getdata = $this->{$this->modelname}->get_one($pid);
		}
		$getdata['config_max_level'] = $this->cbconfig->item('max_level');
		$registerform = $this->cbconfig->item('registerform');
		$form = json_decode($registerform, true);

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'ad_type',
				'label' => '광고 분류',
				'rules' => 'trim|required|is_natural_no_zero',
			),
			array(
				'field' => 'ad_state',
				'label' => '광고 노출 여부',
				'rules' => 'trim|required',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
		$file_error = '';
		$updatephoto = '';
		$updateicon = '';
		if ($form_validation && element('name',element('ad_url_img',$_FILES))) {
			$this->load->library('upload');
			if (isset($_FILES) && isset($_FILES['ad_url_img'])) {
				$upload_path = config_item('uploads_dir') . '/advertise/';
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
				$uploadconfig['max_width'] = '1000';
				$uploadconfig['max_height'] = '1000';
				$uploadconfig['encrypt_name'] = true;

				$this->upload->initialize($uploadconfig);

				if ($this->upload->do_upload('ad_url_img')) {
					$img = $this->upload->data();
					$updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
					// print_r($updatephoto); exit;
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

			$view['view']['message'] = $file_error . $file_error2;

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
			$ad_url_link = rs_get_YT_id($this->input->post('ad_url_link', null, ''));
			$ad_type= $this->input->post('ad_type', null, '');
			$updatedata = array(
				'ad_type' => $this->input->post('ad_type', null, ''),
				'ad_state' => $this->input->post('ad_state', null, ''),
				'ad_ip' => $this->input->ip_address(),
				'ad_mem_id' => $this->member->is_member(),
				'ad_memo'	=> $this->input->post('ad_memo', null, '')
			);

			/**
			 * 게시물을 수정하는 경우입니다
			 */
			if ($this->input->post($primary_key)) {
				$updatedata['ad_mdate'] = date('Y-m-d H:i:s');
				if($ad_type == 1){
					if($updatephoto){$updatedata['ad_url'] = $updatephoto;}
				}else if($ad_type == 2){
					if($ad_url_link){$updatedata['ad_url'] = $ad_url_link;}
				}
				$this->{$this->modelname}->update($this->input->post($primary_key), $updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			} else {
				/**
				 * 게시물을 새로 입력하는 경우입니다
				 */
				$updatedata['ad_wdate'] = date('Y-m-d H:i:s');
				$message = '정상적으로 입력되었습니다';
				if($ad_type == 1){
					if($updatephoto){
						$updatedata['ad_url'] = $updatephoto;
						$this->{$this->modelname}->insert($updatedata);
					}else{
						$message = '이미지 업로드를 선택해주세요.';
					}
					$this->session->set_flashdata('message',$message);
				}else if($ad_type == 2){
					if($ad_url_link){
						$updatedata['ad_url'] = $ad_url_link;
						$this->{$this->modelname}->insert($updatedata);
					}else{
						$message = '유튜브 동영상 주소를 정확히 입력해주세요.';
					}
					$this->session->set_flashdata('message',$message);
				}
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
}
