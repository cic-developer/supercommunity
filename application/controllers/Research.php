<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Board_write class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 게시물 작성, 수정, 답변에 관한 controller 입니다.
 */
class Research extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Research');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring', 'accesslevel', 'email', 'notelib', 'point', 'imagelib', 'session'));
        if(!$this->member->is_member()){ $this->session->set_flashdata('message', '로그인 후 사용가능합니다.'); redirect('/login');}
    }

    public function index()
    {
        // 페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_research_mobile', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_research', $this->session->userdata('lang'));
		}
        
        $page_title = $this->cbconfig->item('site_meta_title_main');
        $meta_description = $this->cbconfig->item('site_meta_description_main');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
        $meta_author = $this->cbconfig->item('site_meta_author_main');
        $page_name = $this->cbconfig->item('site_page_name_main');

        $layoutconfig = array(
            'path' => 'research',
            'layout' => 'layout',
            'skin' => 'index',
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
        $view['header']['menu'] = 'inquiry';
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    function adInquiry()
    {
        // 페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_research_adinquiry_mobile', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_research_adinquiry', $this->session->userdata('lang'));
		}
        
        $page_title = $this->cbconfig->item('site_meta_title_main');
        $meta_description = $this->cbconfig->item('site_meta_description_main');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
        $meta_author = $this->cbconfig->item('site_meta_author_main');
        $page_name = $this->cbconfig->item('site_page_name_main');
        
        /**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$this->load->library('form_validation');

        $config = array(
			array(
				'field' => 'is_submit',
				'label' => '제출',
				'rules' => 'required',
            ),
            array(
                'field' => 'res_name',
				'label' => '제품 또는 프로젝트 제목',
				'rules' => 'required|min_length[2]|max_length[50]',
            ),
            array(
                'field' => 'res_category',
				'label' => '분야',
				'rules' => 'required',
            ),
            array(
                'field' => 'res_contents',
				'label' => '광고 내용',
				'rules' => 'required|min_length[2]|max_length[1000]',
            ),
            array(
                'field' => 'res_when',
				'label' => '광고 시점',
				'rules' => 'required',
            ),
            array(
                'field' => 'res_platform[]',
				'label' => '광고 플랫폼',
				'rules' => 'required',
            ),
            array(
                'field' => 'res_email',
				'label' => '이메일',
				'rules' => 'required|valid_email',
            ),
            array(
                'field' => 'res_tel',
				'label' => '연락처',
				'rules' => 'required',
            ),
		);

        $this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
        
        if($form_validation){
            //업로드 파일 있는 경우
            $uploadFile = '';
            if (isset($_FILES) && isset($_FILES['res_contents_file'])){
                $this->load->library('upload');

                $upload_path = config_item('uploads_dir') . '/research/';
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
                $uploadconfig['allowed_types'] = 'jpg|jpeg|png|pdf|txt|xlsx';
                $uploadconfig['max_size'] = '20000';
                $uploadconfig['encrypt_name'] = true;

                $this->upload->initialize($uploadconfig);
                if ($this->upload->do_upload('res_contents_file')) {
                    $img = $this->upload->data();
                    $uploadFile = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
                } else {
                    $file_error = $this->upload->display_errors();
                    $uploadFile = '';
                }
            }
            $postData = $this->input->post();
            $ip = $this->input->ip_address();
            $wdate = date('Y-m-d H:i:s');

            $insertArr = array(
                'res_type'  => '광고문의',
                'res_input' => json_encode($postData),
                'res_ip'    => $ip,
                'res_wdate' => $wdate,
                'res_file'  => $uploadFile,
                'mem_id'    => $this->member->is_member()
            );

            $result = $this->Research_model->insert($insertArr);
            $view['message'] = $result ? $this->lang->line('controller_message_success'): $this->lang->line('controller_message_error');
        }

        $layoutconfig = array(
            'path' => 'research',
            'layout' => 'layout',
            'skin' => 'adInquiry',
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
        $view['header']['menu'] = 'inquiry';
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }
}

?>
