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
	protected $models = array();

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
    }

    public function index()
    {
        //페이지별 언어팩 로드
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
}

?>
