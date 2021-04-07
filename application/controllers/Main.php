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
 * 메인 페이지를 담당하는 controller 입니다.
 */
class Main extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Board', 'RS_media', 'RS_main_config');

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
		$this->load->library(array('querystring'));
	}


	/**
	 * 전체 메인 페이지입니다
	 */
	public function index()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_main_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$where = array(
			'brd_search' => 1,
		);
		$board_id = $this->Board_model->get_board_list($where);
		$board_list = array();
		if ($board_id && is_array($board_id)) {
			foreach ($board_id as $key => $val) {
				$board_list[] = $this->board->item_all(element('brd_id', $val));
			}
		}
		$view['view']['board_list'] = $board_list;
		$view['view']['canonical'] = site_url();

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
			'path' => 'main',
			'layout' => 'layout',
			'skin' => 'main',
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
		// exit;
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['per_friends'] = $this->db->get('rs_perfriends')->row_array()['PERFRIENDS'];

		$main_config = $this->RS_main_config_model->get_one();
		if(element('mcf_main',$main_config) == 'Y'){
			if(!element('mcf_messages',$main_config)) $main_config['mcf_messages'] = '"CIC 설정 > 메인 페이지" 에 문구를 입력해 주세요.';
			if(!element('mcf_messages_en',$main_config)) $main_config['mcf_messages_en'] = '"CIC 설정 > 영문 메인 페이지" 에 문구를 입력해 주세요.';
			$view['main_config'] = $main_config;
		}
		// echo "<pre>";
		// print_r($view['main_config']);
		// echo "</pre>";
		// exit;
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	function getPerFriendsCount(){
		echo json_encode($this->db->get('rs_perfriends')->row_array()['PERFRIENDS']);
	}
}
