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
class Inquiry extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Post', 'Post_link', 'Post_file', 'Post_extra_vars', 'Post_meta', 'RS_inquiry');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'dhtml_editor');

	protected $gcaptcha_secritKey = '6Le3GsYZAAAAAINMdzvQ5nVEog8D5kgUEKXXXrfA';

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring', 'accesslevel', 'email', 'notelib', 'point', 'imagelib', 'session'));
    }

    function ad_inquiry(){
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_cic_advertise_mobile_ask', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_cic_advertise_ask', $this->session->userdata('lang'));
		}
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inq_name',$this->lang->line(14), 'required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('inq_group',$this->lang->line(15), 'required|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('inq_email',$this->lang->line(16), 'required|min_length[10]|max_length[255]|valid_email');
		$this->form_validation->set_rules('inq_tel',$this->lang->line(17), 'required|min_length[3]|max_length[25]|valid_phone');
        $this->form_validation->set_rules('inq_contents',$this->lang->line(18), 'required|min_length[10]|max_length[3000]');
        $this->form_validation->set_rules('inq_agree',$this->lang->line(19), 'required');
        
        if($this->form_validation->run() == FALSE){	// 만일 form_validation을 만족하지 못하는 경우 다시 입력폼 창으로
            
		    if($message){ echo "<script>alert('".$message."')</script>";}
            if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
            }
            
            $page_title = $this->cbconfig->item('site_meta_title_main');
			$meta_description = $this->cbconfig->item('site_meta_description_main');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
			$meta_author = $this->cbconfig->item('site_meta_author_main');
			$page_name = $this->cbconfig->item('site_page_name_main');
	
			$layoutconfig = array(
				'path' => 'cic_advertise',
				'layout' => 'layout',
				'skin' => 'ask',
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
        }else{
			$recaptcha_flag = false;
			$post_data = $this->input->post();
			$captcha_data = $post_data['g-recaptcha-response'];	//captcha에서 받은 데이터값
			$gcaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->gcaptcha_secritKey."&response=".$captcha_data."&remoteip=".$this->input->ip_address(); //인증 진행
			$response = file_get_contents($gcaptcha_url);
			$responseKeys = json_decode($response,true);
			if(intval($responseKeys["success"]) !== 1){
				$recaptcha_flag = true;
			}

			if($recaptcha_flag){
				$message = $this->lang->line(20);
				$this->session->set_flashdata('message', $message);
				redirect('/Inquiry/ad_inquiry');
				exit;
			}else{
				unset($post_data['g-recaptcha-response']);
			}
						$post_data['inq_contents'] = nl2br($post_data['inq_contents']);
            $post_data['inq_wdate'] = date('Y-m-d H:i:s');
            $post_data['inq_ip'] = $this->input->ip_address();
            $post_data['inq_type'] = 1;
            $result = $this->RS_inquiry_model->insert($post_data);
            if($result){
                $message = $this->lang->line(21);
            }else{
                $message = $this->lang->line(22);
            }
            $this->session->set_flashdata('message', $message);
            redirect('/Inquiry/ad_inquiry');
        }
	}
	
    function ad_inquiry_mobile(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inq_name','이름', 'required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('inq_group','직장,단체명', 'required|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('inq_email','이메일', 'required|min_length[10]|max_length[255]|valid_email');
		$this->form_validation->set_rules('inq_tel','전화번호', 'required|min_length[3]|max_length[25]|valid_phone');
        $this->form_validation->set_rules('inq_contents','문의 내용', 'required|min_length[10]|max_length[3000]');
        $this->form_validation->set_rules('inq_agree','개인정보 처리방침', 'required');
        
        if($this->form_validation->run() == FALSE){	// 만일 form_validation을 만족하지 못하는 경우 다시 입력폼 창으로
            
		    if($message){ echo "<script>alert('".$message."')</script>";}
            if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
            }
            
            $page_title = $this->cbconfig->item('site_meta_title_main');
			$meta_description = $this->cbconfig->item('site_meta_description_main');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
			$meta_author = $this->cbconfig->item('site_meta_author_main');
			$page_name = $this->cbconfig->item('site_page_name_main');
	
			$layoutconfig = array(
				'path' => 'cic_advertise',
				'layout' => 'layout',
				'skin' => 'ask',
				'layout_dir' => '/rsteam_cic_mobile',
				'mobile_layout_dir' => '/rsteam_cic_mobile',
				'use_sidebar' => $this->cbconfig->item('sidebar_main'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
				'skin_dir' => 'rsteam_cic_mobile',
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
        }else{
			$recaptcha_flag = false;
			$post_data = $this->input->post();
			$captcha_data = $post_data['g-recaptcha-response'];	//captcha에서 받은 데이터값
			$gcaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->gcaptcha_secritKey."&response=".$captcha_data."&remoteip=".$this->input->ip_address(); //인증 진행
			$response = file_get_contents($gcaptcha_url);
			$responseKeys = json_decode($response,true);
			if(intval($responseKeys["success"]) !== 1){
				$recaptcha_flag = true;
			}

			if($recaptcha_flag){
				$message = "문의 등록중 인증 에러가 발생하였습니다.";
				$this->session->set_flashdata('message', $message);
				redirect('/Inquiry/ad_inquiry');
				exit;
			}else{
				unset($post_data['g-recaptcha-response']);
			}
            $post_data['inq_wdate'] = date('Y-m-d H:i:s');
            $post_data['inq_ip'] = $this->input->ip_address();
            $post_data['inq_type'] = 1;
            $result = $this->RS_inquiry_model->insert($post_data);
            if($result){
                $message = "문의가 성공적으로 등록되었습니다.";
            }else{
                $message = "문의 등록중 에러가 발생하였습니다.";
            }
            $this->session->set_flashdata('message', $message);
            redirect('/Inquiry/ad_inquiry');
        }
	}
	
    function ad_consulting_inquiry(){
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_cic_advertise_mobile_consult', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_cic_advertise_consult', $this->session->userdata('lang'));
		}
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inq_name',$this->lang->line(12), 'required|min_length[1]|max_length[10]');
		$this->form_validation->set_rules('inq_group',$this->lang->line(13), 'required|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('inq_email',$this->lang->line(14), 'required|min_length[10]|max_length[255]|valid_email');
		$this->form_validation->set_rules('inq_tel',$this->lang->line(15), 'required|min_length[3]|max_length[15]|valid_phone');
        $this->form_validation->set_rules('inq_contents',$this->lang->line(16), 'required|min_length[10]|max_length[1000]');
        $this->form_validation->set_rules('inq_agree',$this->lang->line(17), 'required');
        
        if($this->form_validation->run() == FALSE){	// 만일 form_validation을 만족하지 못하는 경우 다시 입력폼 창으로
            
		    if($message){ echo "<script>alert('".$message."')</script>";}
            if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
            }
            
            $page_title = $this->cbconfig->item('site_meta_title_main');
			$meta_description = $this->cbconfig->item('site_meta_description_main');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
			$meta_author = $this->cbconfig->item('site_meta_author_main');
			$page_name = $this->cbconfig->item('site_page_name_main');
	
			$layoutconfig = array(
				'path' => 'cic_advertise',
				'layout' => 'layout',
				'skin' => 'consult',
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
        }else{
			$recaptcha_flag = false;
			$post_data = $this->input->post();
			$captcha_data = $post_data['g-recaptcha-response'];	//captcha에서 받은 데이터값
			$gcaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->gcaptcha_secritKey."&response=".$captcha_data."&remoteip=".$this->input->ip_address(); //인증 진행
			$response = file_get_contents($gcaptcha_url);
			$responseKeys = json_decode($response,true);
			if(intval($responseKeys["success"]) !== 1){
				$recaptcha_flag = true;
			}

			if($recaptcha_flag){
				$message = $this->lang->line(18);
				$this->session->set_flashdata('message', $message);
				redirect('/Inquiry/ad_consulting_inquiry');
				exit;
			}else{
				unset($post_data['g-recaptcha-response']);
			}
            $post_data['inq_contents'] = nl2br($post_data['inq_contents']);
            $post_data['inq_wdate'] = date('Y-m-d H:i:s');
            $post_data['inq_ip'] = $this->input->ip_address();
            $post_data['inq_type'] = 2;
            $result = $this->RS_inquiry_model->insert($post_data);
            if($result){
                $message = $this->lang->line(19);
            }else{
                $message = $this->lang->line(20);
            }
            $this->session->set_flashdata('message', $message);
            redirect('/Inquiry/ad_consulting_inquiry');
        }
	}
	
	function ad_consulting_inquiry_mobile(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inq_name','이름', 'required|min_length[1]|max_length[10]');
		$this->form_validation->set_rules('inq_group','직장,단체명', 'required|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('inq_email','이메일', 'required|min_length[10]|max_length[255]|valid_email');
		$this->form_validation->set_rules('inq_tel','전화번호', 'required|min_length[3]|max_length[15]|valid_phone');
        $this->form_validation->set_rules('inq_contents','문의 내용', 'required|min_length[10]|max_length[1000]');
        $this->form_validation->set_rules('inq_agree','개인정보 처리방침', 'required');
        
        if($this->form_validation->run() == FALSE){	// 만일 form_validation을 만족하지 못하는 경우 다시 입력폼 창으로
            
		    if($message){ echo "<script>alert('".$message."')</script>";}
            if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
            }
            
            $page_title = $this->cbconfig->item('site_meta_title_main');
			$meta_description = $this->cbconfig->item('site_meta_description_main');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
			$meta_author = $this->cbconfig->item('site_meta_author_main');
			$page_name = $this->cbconfig->item('site_page_name_main');
	
			$layoutconfig = array(
				'path' => 'cic_advertise',
				'layout' => 'layout',
				'skin' => 'consult',
				'layout_dir' => '/rsteam_cic_mobile',
				'mobile_layout_dir' => '/rsteam_cic_mobile',
				'use_sidebar' => $this->cbconfig->item('sidebar_main'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
				'skin_dir' => 'rsteam_cic_mobile',
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
        }else{
			$recaptcha_flag = false;
			$post_data = $this->input->post();
			$captcha_data = $post_data['g-recaptcha-response'];	//captcha에서 받은 데이터값
			$gcaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->gcaptcha_secritKey."&response=".$captcha_data."&remoteip=".$this->input->ip_address(); //인증 진행
			$response = file_get_contents($gcaptcha_url);
			$responseKeys = json_decode($response,true);
			if(intval($responseKeys["success"]) !== 1){
				$recaptcha_flag = true;
			}

			if($recaptcha_flag){
				$message = "문의 등록중 인증 에러가 발생하였습니다.";
				$this->session->set_flashdata('message', $message);
				redirect('/Inquiry/ad_consulting_inquiry');
				exit;
			}else{
				unset($post_data['g-recaptcha-response']);
			}
            $post_data['inq_wdate'] = date('Y-m-d H:i:s');
            $post_data['inq_ip'] = $this->input->ip_address();
            $post_data['inq_type'] = 2;
            $result = $this->RS_inquiry_model->insert($post_data);
            if($result){
                $message = "문의가 성공적으로 등록되었습니다.";
            }else{
                $message = "문의 등록중 에러가 발생하였습니다.";
            }
            $this->session->set_flashdata('message', $message);
            redirect('/Inquiry/ad_consulting_inquiry');
        }
    }
}
    
?>