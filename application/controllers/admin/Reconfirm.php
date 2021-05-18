<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자 메인 controller 입니다.
 */
class Reconfirm extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = '';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Post', 'Comment', 'Point', 'Admin_secondary_password');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = '';

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
		$this->load->library(array('querystring','form_validation'));
	}

	/**
	 * 관리자 메인 페이지입니다
	 */
	public function index()
	{
		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'main');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
		$this->load->library("form_validation");
		$this->form_validation->set_rules('cic_name','성함','required');
		$this->form_validation->set_rules('cic_password','비밀번호','required');
		
		if ($this->form_validation->run() === false) {
		}else{
			$reconfirm_id = $this->input->post('cic_name');
			$reconfirm_password = $this->input->post('cic_password');
			$reconfirm_admin = $this->Admin_secondary_password_model->checkPassword($reconfirm_id,$reconfirm_password);
			if($reconfirm_admin > 0){
				$this->session->set_userdata('reconfirm_access', $reconfirm_admin);
				redirect($this->input->get('returnURL'));
			}else{
				echo alert('인증에 실패했습니다');
				redirect();
			}
		}
	}
}