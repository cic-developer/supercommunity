<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends CB_Controller
{
	protected $models = array('Board','RS_media','RS_whitelist', 'RS_judge', 'RS_judge_log', 'RS_mediatype', 'RS_mediatype_map');
	protected $helpers = array('form', 'array','url');
    protected $librarys = array('session');

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('querystring'));
    }

    function provision(){
		//페이지별 언어팩 로드
		$this->lang->load('cic_cic_etc_provision', $this->session->userdata('lang'));
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_main');
		$meta_description = $this->cbconfig->item('site_meta_description_main');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
		$meta_author = $this->cbconfig->item('site_meta_author_main');
		$page_name = $this->cbconfig->item('site_page_name_main');

		$layoutconfig = array(
			'path' => 'cic_etc',
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
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
    function privacy(){
        //페이지별 언어팩 로드
		$this->lang->load('cic_cic_etc_privacy', $this->session->userdata('lang'));
		
		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_main');
		$meta_description = $this->cbconfig->item('site_meta_description_main');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
		$meta_author = $this->cbconfig->item('site_meta_author_main');
		$page_name = $this->cbconfig->item('site_page_name_main');

		$layoutconfig = array(
			'path' => 'cic_etc',
			'layout' => 'layout',
			'skin' => 'privacy',
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
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
}
?>