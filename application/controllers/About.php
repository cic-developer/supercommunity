<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CB_Controller
{
	protected $models = array();
	protected $helpers = array('form', 'array','url', 'download');
    protected $librarys = array('session');
	protected $_filePath = 'uploads/whitePaper/';

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('querystring'));
	}

	function provision(){
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_cic_aboutper_mobile_provision', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_cic_aboutper_provision', $this->session->userdata('lang'));
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
			'path' => 'cic_aboutper',
			'layout' => 'layout',
			'skin' => 'provision',
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
		$view['header']['menu'] = 'about';
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	// function status(){
	// 	//페이지별 언어팩 로드
	// 	if($this->agent->is_mobile()){
	// 		$this->lang->load('cic_cic_aboutper_mobile_status', $this->session->userdata('lang'));
	// 	} else {
	// 		$this->lang->load('cic_cic_aboutper_status', $this->session->userdata('lang'));
	// 	}
	// 	/**
	// 	 * 레이아웃을 정의합니다
	// 	 */
	// 	$page_title = $this->cbconfig->item('site_meta_title_main');
	// 	$meta_description = $this->cbconfig->item('site_meta_description_main');
	// 	$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
	// 	$meta_author = $this->cbconfig->item('site_meta_author_main');
	// 	$page_name = $this->cbconfig->item('site_page_name_main');

	// 	$layoutconfig = array(
	// 		'path' => 'cic_aboutper',
	// 		'layout' => 'layout',
	// 		'skin' => 'status',
	// 		'layout_dir' => '/rsteam_cic_main',
	// 		'mobile_layout_dir' => '/rsteam_cic_mobile',
	// 		'use_sidebar' => $this->cbconfig->item('sidebar_main'),
	// 		'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
	// 		'skin_dir' => 'rsteam_cic',
	// 		'mobile_skin_dir' => 'rsteam_cic_mobile',
	// 		'page_title' => $page_title,
	// 		'meta_description' => $meta_description,
	// 		'meta_keywords' => $meta_keywords,
	// 		'meta_author' => $meta_author,
	// 		'page_name' => $page_name,
	// 	);
	// 	$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
	// 	$view['header']['menu'] = 'about';
	// 	$view['superpoint'] = $this->db->get('rs_superpoints_sum')->row_array()['superpoint'];
	// 	// print_r($view['superpoint']);
	// 	// exit;
	// 	$this->data = $view;
	// 	$this->layout = element('layout_skin_file', element('layout', $view));
	// 	$this->view = element('view_skin_file', element('layout', $view));
	// }

	function whitepaper(){
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_cic_whitepaper_mobile_whitepaper', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_cic_whitepaper_whitepaper', $this->session->userdata('lang'));
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
			'path' => 'cic_whitepaper',
			'layout' => 'layout',
			'skin' => 'whitepaper',
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
		$view['header']['menu'] = 'about';
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	function Down_whitepaper($type = 'ko'){
		switch($type){
			case 'ko' :
				$file_name = 'PER 백서.pdf';
			break;

			case 'en' :
				$file_name = 'PER White Paper.pdf';
			break;
			default :
				$this->session->set_flashdata('message', '잘못된 다운로드 경로입니다.');
				return;
		}

		$full_path = file_get_contents(base_url($this->_filePath).$file_name);
		force_download($file_name, $full_path, TRUE);
	}
}