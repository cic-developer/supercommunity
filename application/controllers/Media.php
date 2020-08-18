<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CB_Controller
{
	protected $models = array('Board','RS_media','RS_whitelist');
	protected $helpers = array('form', 'array','url');
    protected $librarys = array('session');

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('querystring'));
	}

    function myMedia(){
		$mem_id = $this->session->userdata('mem_id');
		if(!$mem_id){
			redirect('/');
			exit;
		}
		$data = $this->RS_media_model->get_media($mem_id, array());
		echo "<pre>";
		print_r($data);
		echo "</pre>";       
	}
	
	function editMedia($med_id = 0){
		// $view = array();
		$mem_id = $this->session->userdata('mem_id');
		if(!$mem_id){
			redirect('/');
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('wht_list','WhiteList', 'required');
		$this->form_validation->set_rules('med_url','URL', 'required|min_length[10]|max_length[255]');
		$this->form_validation->set_rules('med_admin','관리자 이름', 'required|min_length[2]|max_length[10]');
		$this->form_validation->set_rules('med_name','미디어 이름', 'required|min_length[3]|max_length[255]');
		if($this->form_validation->run() == FALSE){
			if($this->form_validation->error_string()){
				$this->form_validation->set_error_delimiters('','');
				$view['validation_err'] = json_encode($this->form_validation->error_string());
			}
			if($med_id){
				$mem_id = $this->session->userdata('mem_id');
				$datas = $this->RS_media_model->get_media($mem_id, array('med_id' => $med_id));
				$view['mem_data'] = $datas['mem_data'];
				$view['med_list'] = $datas['med_list'];
			}else{
				$view['mem_data'] = array();
				$view['med_list'] = array();
			}
			$view['white_list'] = $this->RS_whitelist_model->get_whitelist_list()['list'];
			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_main');
			$meta_description = $this->cbconfig->item('site_meta_description_main');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_main');
			$meta_author = $this->cbconfig->item('site_meta_author_main');
			$page_name = $this->cbconfig->item('site_page_name_main');
	
			$layoutconfig = array(
				'path' => 'media',
				'layout' => 'layout',
				'skin' => 'media',
				'layout_dir' => '/test',
				'mobile_layout_dir' => '/test',
				'use_sidebar' => $this->cbconfig->item('sidebar_main'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_main'),
				'skin_dir' => 'basic',
				'mobile_skin_dir' => 'mobile',
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
		}else{
			if($this->registMedia($med_id, $this->input->post())){
				echo "<script>alert('".'등록 및 업데이트에 성공하였습니다.'."')</script>";
			}else{
				echo "<script>alert('".'등록 및 업데이트에 실패하였습니다.'."')</script>";
			}
			redirect('/Media/myMedia');
		}
	}
	/* 	
	**	media id가 있는경우 update, 0이면 insert하여 
	**	update or insert 된 media의 id 값 가져옴 
	*/
	private function registMedia($med_id = 0, $postData = array()){
		$insertArr = array();
		$insertArr['med_id']		= $med_id;
		$insertArr['med_wht_id'] 	= element('wht_list',$postData);
		$insertArr['med_name'] 		= element('med_name',$postData);
		$insertArr['med_admin']		= element('med_admin',$postData);
		$insertArr['med_url'] 		= element('med_url',$postData);
		$insertArr['mem_id']		= $this->session->userdata('mem_id');

		$result = $this->RS_media_model->registMedia($insertArr);

		return $result;
	}
}