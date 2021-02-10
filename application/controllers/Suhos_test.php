<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Note class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 쪽지 목록, 쪽지 읽기, 쪽지 발송과 관련된 controller 입니다.
 */
class Suhos_test extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Notification');

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
		$this->load->library(array('pagination', 'querystring', 'notelib'));

		if ($this->member->item('mem_id') && $this->member->item('meta_note_received_datetime')) {
			$this->load->model('Member_meta_model');
			$metadata = array(
				'meta_note_received_datetime' => '',
				'meta_note_received_from_id' => '',
				'meta_note_received_from_nickname' => '',
			);
			$this->Member_meta_model->save($this->member->item('mem_id'), $metadata);
		}
	}

    	/**
	 * 쪽지 목록 페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_note_lists';
		$this->load->event($eventname);

		// $view = array();
		// $view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_main');
		$meta_description = $this->cbconfig->item('site_meta_description_main');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
		$meta_author = $this->cbconfig->item('site_meta_author_main');
		$page_name = $this->cbconfig->item('site_page_name_main');

        $layoutconfig = array(
			'path' => 'suho',
			'layout' => 'layout',
			'skin' => 'view',
			'layout_dir' => '/suho',
			'mobile_layout_dir' => '/suho',
			'use_sidebar' => $this->cbconfig->item('sidebar_main'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
			'skin_dir' => 'test',
			'mobile_skin_dir' => 'test',
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