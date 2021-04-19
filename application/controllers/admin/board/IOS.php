<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Like class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>게시판설정>추천/비추 controller 입니다.
 */
class IOS extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'board/IOS';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Like_model';

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array','dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
	}

    public function index(){
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_board_IOS_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();
        $this->load->library('form_validation');
        $config = array(
			array(
				'field' => 'ios_wallet_noti',
				'label' => '월렛 가이드',
				'rules' => 'required',
			),
			array(
				'field' => 'ios_stacking_noti',
				'label' => '스테이킹 가이드',
				'rules' => 'required',
			),
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
        if(!$form_validation){
            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before'] = Events::trigger('before', $eventname);
            
            $view['view']['data'] = element(0, $this->db->get('IOS')->result_array());
            /**
             * primary key 정보를 저장합니다
             */
            $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

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
        }else{
            $ios_wallet_noti = $this->input->post('ios_wallet_noti');
            $ios_stacking_noti = $this->input->post('ios_stacking_noti');

            $this->db->set(
                array(
                    'ios_wallet_noti' => $ios_wallet_noti,
                    'ios_stacking_noti' => $ios_stacking_noti
                )
            );
            $this->db->update('IOS');

            redirect(admin_url($this->pagedir));
        }

    }
}
?>