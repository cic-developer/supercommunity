<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Postact class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 게시물 열람 페이지에서 like, scrap,신고 등 각종 이벤트를 발생할 때 필요한 controller 입니다.
 */
class Popup extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Popup', 'RS_missionlist');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();
	} 


    function notiPopup($popup_id){
        $this->session->set_userdata('popup_on',false);
        /**
        * 레이아웃을 정의합니다
        */
        $page_title = $this->cbconfig->item('site_meta_title_main');
        $meta_description = $this->cbconfig->item('site_meta_description_main');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
        $meta_author = $this->cbconfig->item('site_meta_author_main');
        $page_name = $this->cbconfig->item('site_page_name_main');
        
        $layoutconfig = array(
            'path' => 'popup',
            'layout' => 'layout',
            'skin' => 'popup',
            'layout_dir' => '/test',
            'mobile_layout_dir' => '/test',
            'use_sidebar' => $this->cbconfig->item('sidebar_main'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
            'skin_dir' => 'popup',
            'mobile_skin_dir' => 'popup',
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );
        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['member_data'] = $this->member->get_member();
        $view['popup'] = $this->Popup_model->get_one($popup_id);

        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    function paymentPolicy($mis_id){
        $mis_data = $this->RS_missionlist_model->get_one($mis_id);
        $mis_payment_policy = '';

        switch($this->session->userdata('lang')){
            case 'korean' :
                $mis_payment_policy = element('mis_payment_policy_ko', $mis_data);
            break; 
            
            case 'english' :
                $mis_payment_policy = element('mis_payment_policy_en', $mis_data);
            break;

            default :
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
            'path' => 'popup',
            'layout' => 'layout',
            'skin' => 'paymentPolicy',
            'layout_dir' => '/test',
            'mobile_layout_dir' => '/test',
            'use_sidebar' => $this->cbconfig->item('sidebar_main'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
            'skin_dir' => 'popup',
            'mobile_skin_dir' => 'popup',
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );
        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $view['member_data'] = $this->member->get_member();
        $view['mis_payment_policy'] = $mis_payment_policy;

        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
        
    }
}