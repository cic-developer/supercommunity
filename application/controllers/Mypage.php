<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mypage class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 마이페이지와 관련된 controller 입니다.
 */
class Mypage extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_media','RS_auth_mail', 'RS_judge', 'RS_judge_log', 'RS_advertise', 'Member', 'Member_meta', 'Member_extra_vars', 'Point','Member_nickname');

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
		$this->load->library(array('pagination', 'querystring'));

	}


	/**
	 * 마이페이지입니다
	 */
	public function index()
	{

		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_main', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_main', $this->session->userdata('lang'));
		}
		$this->load->library('form_validation');
		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'nick_name',
				'label' => $this->lang->line('controller_0'),
				'rules' => 'trim|required|max_length[15]|min_length[1]',
			)
		);
		$this->form_validation->set_rules($config);
			
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_index';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		$mem_id = $this->member->is_member();
		if(!$mem_id){ $this->session->set_flashdata('message', $this->lang->line('controller_1')); redirect('/login');}
		$view = array();
		$view['view'] = array();


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		$alert_message = '';
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before'] = Events::trigger('before', $eventname);

			$registerform = $this->cbconfig->item('registerform');
			$view['view']['memberform'] = json_decode($registerform, true);

			$view['view']['member_group_name'] = '';
			$member_group = $this->member->group();
			if ($member_group && is_array($member_group)) {

				$this->load->model('Member_group_model');

				foreach ($member_group as $gkey => $gval) {
					$item = $this->Member_group_model->item(element('mgr_id', $gval));
					if ($view['view']['member_group_name']) {
						$view['view']['member_group_name'] .= ', ';
					}
					$view['view']['member_group_name'] .= element('mgr_title', $item);
				}
			}
			$view['media_data'] = $this->RS_media_model->get('', '', "med_deletion = 'N' AND med_state = 3 AND med_state != 0 AND mem_id = ".$mem_id, '', 0, 'med_wdate','DESC', $join = array('table' => 'rs_whitelist', 'on' => 'med_wht_id = wht_id', 'type' => 'LEFT'));
			$view['member_data'] = $this->Member_model->get_by_memid($mem_id);
			$view['total_super'] = $this->RS_media_model->get_total_super($mem_id);
			
			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
			$view['header']['menu'] = 'mypage';
			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_mypage');
			$meta_description = $this->cbconfig->item('site_meta_description_mypage');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
			$meta_author = $this->cbconfig->item('site_meta_author_mypage');
			$page_name = $this->cbconfig->item('site_page_name_mypage');
			
			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'main',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			// print_r($view['layout']);
			// exit;
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}else{
			$nick_name = $this->input->post('nick_name');
			$wallet_addr = $this->input->post('wallet_addr');
			$atm_id = $this->input->post('auth_id');
			$atm_hash = $this->input->post('auth_hash');
			$where = array('atm_hash' => $atm_hash);
			$result = $this->RS_auth_mail_model->get_one($atm_id, '', $where);

			if($result){
				if($result['atm_type'] == 1){	//지갑 주소 인증인 경우 지갑 주소 업데이트
					$this->Member_extra_vars_model->save($mem_id, array('meta_wallet_address' => trim(html_escape($wallet_addr))));
					$this->Member_extra_vars_model->save($mem_id, array('meta_wallet_auth_datetime' => date('Y-m-d H:i:s')));
				}
				//지갑 주소 인증인 경우에도 해당 이메일로 인증한것으로 간주, 이메일을 업데이트 한다
				$this->Member_model->update($mem_id, array('mem_email' => $this->input->post('email')));
			}
			$member_data = $this->Member_model->get_by_memid($mem_id,'mem_nickname');
			if($nick_name != element('mem_nickname',$member_data)){
				$this->Member_model->update($mem_id, array('mem_nickname' => $nick_name));

				$upnick = array(
					'mni_end_datetime' => cdate('Y-m-d H:i:s'),
				);
				$nickwhere = array(
					'mem_id' => $mem_id,
					'mni_nickname' => element('mem_nickname',$member_data),
				);
				$this->Member_nickname_model->update('', $upnick, $nickwhere);
	
				$nickinsert = array(
					'mem_id' => $mem_id,
					'mni_nickname' => $nick_name,
					'mni_start_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->Member_nickname_model->insert($nickinsert);
			}
			
			$this->db->set('log_datas', json_encode($this->input->post()));
			$this->db->set('log_mem_id', $mem_id);
			$this->db->set('log_wdate', date('Y-m-d H:i:s'));
			$this->db->insert('log');
			$this->session->set_flashdata('message',$this->lang->line('controller_2'));
			redirect('/Mypage');
		}
	}

	//mypage 슈퍼포인트 조회 페이지
	function superpoint(){
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_superpoint', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_superpoint', $this->session->userdata('lang'));
		}
		$mem_id = $this->member->is_member();

		/**
		* 레이아웃을 정의합니다
		*/
		$page_title = $this->cbconfig->item('site_meta_title_mypage');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage');
		$page_name = $this->cbconfig->item('site_page_name_mypage');
		
		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'superpoint',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
			'page_title' => $page_title,
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => $page_name,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['member_data'] = $this->Member_model->get_by_memid($mem_id);
		$view['total_super'] = $this->RS_media_model->get_total_super($mem_id);
		$view['header']['menu'] = 'mypage';
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	
	//출금 요청 페이지
	function withdraw(){
		/**
		 * 로그인이 필요한 페이지입니다
		 */

		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_withdraw', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_withdraw', $this->session->userdata('lang'));
		}

		if(!$this->member->is_member()){
			$this->session->set_flashdata('message', $this->lang->line('require_login'));
			redirect('/');
		}
		$mem_id = $this->member->is_member();
		$all_meta = $this->Member_extra_vars_model->get_all_meta($mem_id);
		$wallet_addr = element('meta_wallet_address',$all_meta);
		if(!$wallet_addr || strlen($wallet_addr) < 10){
			$this->session->set_flashdata('message',$this->lang->line('controller_0'));
			redirect('/Mypage');
			exit;
		}
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->RS_judge_model->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		$per_page = $this->agent->is_mobile() ? 5 : 10;
		$offset = ($page - 1) * $per_page;

		$list_where = array(
			'jud_jug_id' => 3,
			'jud_mem_id' => $mem_id,
			'jud_deletion' => 'N'
		); 

		$join = array(
			'table' => 'rs_judge_denied',
			'on' 	=> 'jud_id = judn_jud_id',
			'type'	=> 'left'
		);

		$result = $this->RS_judge_model->_get_list_common(
			'', $join, $per_page, $offset, $list_where, '', $findex, $forder, $sfield, $skeyword
		);

		$config['base_url'] = '/Mypage/withdraw?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['paging'] = $this->pagination->create_links();
		$view['page'] = $page;
		$view['withdraw_list'] = $result['list'];
		$view['advertise'] = $this->RS_advertise_model->get_random();
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_index';
		$this->load->event($eventname);
		/**
		* 레이아웃을 정의합니다
		*/
		$page_title = $this->cbconfig->item('site_meta_title_mypage');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage');
		$page_name = $this->cbconfig->item('site_page_name_mypage');
		
		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'withdraw',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
			'page_title' => $page_title,
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => $page_name,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$view['total_super'] = $this->RS_media_model->get_total_super($mem_id);
		foreach($view['withdraw_list'] AS $key => $value){
			switch($view['withdraw_list'][$key]['jud_state']){
				case '0' :
					$view['withdraw_list'][$key]['state'] = $this->lang->line('controller_1');
				break;
				case '1' :
					$view['withdraw_list'][$key]['state'] = $this->lang->line('controller_2');
				break;
				case '3' :
					$view['withdraw_list'][$key]['state'] = $this->lang->line('controller_3');
				break;
				case '5' :
					$view['withdraw_list'][$key]['state'] = $this->lang->line('controller_4');
				break;
				default :
					$view['withdraw_list'][$key]['state'] = $view['withdraw_list'][$key]['jud_state'];
			}
		}
		$view['header']['menu'] = 'mypage';
		$view['member_data'] = $this->Member_model->get_by_memid($mem_id);
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
	

	//회원탈퇴 페이지
	function signout(){
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$this->load->library(array('form_validation'));

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'member_id',
				'label' => 'fake_id',
				'rules' => 'trim|required',
			),
		);
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_signout', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_signout', $this->session->userdata('lang'));
		}
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === false) {
			/**
			* 레이아웃을 정의합니다
			*/
			$page_title = $this->cbconfig->item('site_meta_title_mypage');
			$meta_description = $this->cbconfig->item('site_meta_description_mypage');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
			$meta_author = $this->cbconfig->item('site_meta_author_mypage');
			$page_name = $this->cbconfig->item('site_page_name_mypage');
			$total_super = $this->RS_media_model->get_total_super($this->member->is_member());
			$view['total_super'] = $total_super;
			
			$layoutconfig = array(
				'path' => 'mypage',
				'layout' => 'layout',
				'skin' => 'signout',
				'layout_dir' => $this->cbconfig->item('layout_mypage'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
				'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
				'skin_dir' => $this->cbconfig->item('skin_mypage'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$view['header']['menu'] = 'mypage';
			$view['member_data'] = $this->member->get_member();
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		}else{
			$mem_id = element('mem_userid', $this->member->get_member('mem_id'));
			$input_mem_id = $this->input->post('member_id');

			if($mem_id == $input_mem_id){
				$this->member->delete_member($this->member->is_member());
				$this->session->sess_destroy();
				$this->session->set_flashdata('message', $this->lang->line('c_1'));
				$this->cache->clean();
			}else{
				$this->session->set_flashdata('message', $this->lang->line('c_2'));
			}
			redirect('/Mypage/signout');
		}
	}

	/**
	 * 마이페이지>나의작성글 입니다
	 */
	public function post()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_post';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
				if(!$this->member->is_member()){
			$this->session->set_flashdata('message',$this->lang->line('require_login'));
			redirect('/login');
		}

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model(array('Post_model', 'Post_file_model'));

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Post_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'post.mem_id' => $mem_id,
			'post_del' => 0,
		);
		$result = $this->Post_model
			->get_post_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $val));
				$result['list'][$key]['post_url'] = post_url($brd_key, element('post_id', $val));
				$result['list'][$key]['num'] = $list_num--;
				if (element('post_image', $val)) {
					$filewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$file = $this->Post_file_model
						->get_one('', '', $filewhere, '', '', 'pfi_id', 'ASC');
					$result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $file), 50, 40);
				} else {
					$result['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 50, 40);
				}
			}
		}

		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/post') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_post');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_post');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_post');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_post');
		$page_name = $this->cbconfig->item('site_page_name_mypage_post');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'post',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>나의작성글(댓글) 입니다
	 */
	public function comment()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_comment';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$this->load->model(array('Post_model', 'Comment_model'));

		$findex = $this->Comment_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'comment.mem_id' => $mem_id,
		);
		$result = $this->Comment_model
			->get_comment_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$post = $this->Post_model
					->get_one(element('post_id', $val), 'brd_id');
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
				$result['list'][$key]['comment_url'] = post_url($brd_key, element('post_id', $val)) . '#comment_' . element('cmt_id', $val);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/comment') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_comment');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_comment');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_comment');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_comment');
		$page_name = $this->cbconfig->item('site_page_name_mypage_comment');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'comment',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>포인트 입니다
	 */
	public function point()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_point';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		if ( ! $this->cbconfig->item('use_point')) {
			alert('이 웹사이트는 포인트 기능을 제공하지 않습니다');
		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Point_model');
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Point_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'point.mem_id' => $mem_id,
		);
		$result = $this->Point_model
			->get_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		$result['plus'] = 0;
		$result['minus'] = 0;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
				if (element('poi_point', $val) > 0) {
					$result['plus'] += element('poi_point', $val);
				} else {
					$result['minus'] += element('poi_point', $val);
				}
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/point') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_point');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_point');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_point');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_point');
		$page_name = $this->cbconfig->item('site_page_name_mypage_point');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'point',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>팔로우 입니다
	 */
	public function followinglist()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_followinglist';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Follow_model');

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Follow_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'follow.mem_id' => $mem_id,
		);
		$result = $this->Follow_model
			->get_following_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		$view['view']['following_total_rows'] = $result['total_rows'];
		$countwhere = array(
			'target_mem_id' => $mem_id,
		);
		$view['view']['followed_total_rows'] = $this->Follow_model->count_by($countwhere);

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/followinglist') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_followinglist');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_followinglist');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_followinglist');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_followinglist');
		$page_name = $this->cbconfig->item('site_page_name_mypage_followinglist');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'followinglist',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>팔로우(Followed) 입니다
	 */
	public function followedlist()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_followedlist';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Follow_model');
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Follow_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'follow.target_mem_id' => $mem_id,
		);
		$result = $this->Follow_model
			->get_followed_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $val),
					element('mem_nickname', $val),
					element('mem_icon', $val)
				);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		$view['view']['followed_total_rows'] = $result['total_rows'];
		$countwhere = array(
			'mem_id' => $mem_id,
		);
		$view['view']['following_total_rows'] = $this->Follow_model->count_by($countwhere);

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/followedlist') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_followedlist');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_followedlist');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_followedlist');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_followedlist');
		$page_name = $this->cbconfig->item('site_page_name_mypage_followedlist');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'followedlist',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>추천 입니다
	 */
	public function like_post()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_like_post';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model(array('Like_model', 'Post_file_model'));
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Like_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'like.mem_id' => $mem_id,
			'lik_type' => 1,
			'target_type' => 1,
			'post.post_del' => 0,
		);
		$result = $this->Like_model
			->get_post_like_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $val));
				$result['list'][$key]['post_url'] = post_url($brd_key, element('post_id', $val));
				$result['list'][$key]['num'] = $list_num--;
				$images = '';
				if (element('post_image', $val)) {
					$filewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$images = $this->Post_file_model
						->get_one('', '', $filewhere, '', '', 'pfi_id', 'ASC');
				}
				$result['list'][$key]['images'] = $images;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/like_post') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_like_post');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_like_post');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_like_post');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_like_post');
		$page_name = $this->cbconfig->item('site_page_name_mypage_like_post');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'like_post',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>추천(댓글) 입니다
	 */
	public function like_comment()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_like_comment';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model(array('Like_model', 'Post_model'));
		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Like_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'like.mem_id' => $mem_id,
			'lik_type' => 1,
			'target_type' => 2,
		);
		$result = $this->Like_model
			->get_comment_like_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$post = $this->Post_model->get_one(element('post_id', $val), 'brd_id');
				$brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
				$result['list'][$key]['comment_url'] = post_url($brd_key, element('post_id', $val)) . '#comment_' . element('cmt_id', $val);
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/like_comment') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_like_comment');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_like_comment');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_like_comment');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_like_comment');
		$page_name = $this->cbconfig->item('site_page_name_mypage_like_comment');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'like_comment',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>스크랩 입니다
	 */
	public function scrap()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_scrap';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->model('Scrap_model');
		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');
		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'scr_id',
				'label' => 'SCRAP ID',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'scr_title',
				'label' => '제목',
				'rules' => 'trim',
			),
		);
		$this->form_validation->set_rules($config);


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		$alert_message = '';
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$scr_title = $this->input->post('scr_title', null, '');
			$updatedata = array(
				'scr_title' => $scr_title,
			);
			$this->Scrap_model->update($this->input->post('scr_id'), $updatedata);
			$alert_message = '제목이 저장되었습니다';
		}

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->Scrap_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'scrap.mem_id' => $mem_id,
			'post.post_del' => 0,
		);
		$result = $this->Scrap_model
			->get_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));

				$result['list'][$key]['post_url'] = post_url(element('brd_key', $board), element('post_id', $val));
				$result['list'][$key]['board_url'] = board_url(element('brd_key', $board));
				$result['list'][$key]['delete_url'] = site_url('mypage/scrap_delete/' . element('scr_id', $val) . '?' . $param->output());
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;
		$view['view']['alert_message'] = $alert_message;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/scrap') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_scrap');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_scrap');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_scrap');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_scrap');
		$page_name = $this->cbconfig->item('site_page_name_mypage_scrap');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'scrap',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


	/**
	 * 마이페이지>스크랩삭제 입니다
	 */
	public function scrap_delete($scr_id = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_scrap_delete';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		$scr_id = (int) $scr_id;
		if (empty($scr_id) OR $scr_id < 1) {
			show_404();
		}

		$this->load->model('Scrap_model');
		$scrap = $this->Scrap_model->get_one($scr_id);

		if ( ! element('scr_id', $scrap)) {
			show_404();
		}
		if ((int) element('mem_id', $scrap) !== $mem_id) {
			show_404();
		}

		$this->Scrap_model->delete($scr_id);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 삭제되었습니다'
		);
		$param =& $this->querystring;

		redirect('mypage/scrap?' . $param->output());
	}


	/**
	 * 마이페이지>로그인기록 입니다
	 */
	public function loginlog()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_mypage_loginlog';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();

		$mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

		$this->load->model('Member_login_log_model');

		$findex = $this->Member_login_log_model->primary_key;
		$forder = 'desc';

		$per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$where = array(
			'mem_id' => $mem_id,
		);
		$result = $this->Member_login_log_model
			->get_list($per_page, $offset, $where, '', $findex, $forder);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				if (element('mll_useragent', $val)) {
					$userAgent = get_useragent_info(element('mll_useragent', $val));
					$result['list'][$key]['browsername'] = $userAgent['browsername'];
					$result['list'][$key]['browserversion'] = $userAgent['browserversion'];
					$result['list'][$key]['os'] = $userAgent['os'];
					$result['list'][$key]['engine'] = $userAgent['engine'];
				}
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_mypage_loginlog');
		$meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
		$meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
		$page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

		$layoutconfig = array(
			'path' => 'mypage',
			'layout' => 'layout',
			'skin' => 'loginlog',
			'layout_dir' => $this->cbconfig->item('layout_mypage'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
			'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
			'skin_dir' => $this->cbconfig->item('skin_mypage'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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

	function ajax_emailSend(){
		//페이지별 언어팩 로드
		$this->lang->load('cic_mypage_authemail', $this->session->userdata('lang'));
		$mem_id = $this->member->item('mem_id');
		if(!$mem_id){echo json_encode('not found member'); exit;}
		$email_type = $this->input->get('type');
		if($email_type == 1 || $email_type == 2){ //이메일 형식이 지갑 주소 인증 또는 이메일 인증이 아닌경우 잘못된 접근, fail 리턴하고 끝낸다.
			$where = array('atm_rev_mem_id' => $mem_id, 'atm_state' => 0, 'atm_wdate >=' => date('Y-m-d H:i:s', strtotime("-6 hours")), 'atm_type' => $email_type);
			$search = $this->RS_auth_mail_model->get_one('','', $where);
			if($search){
				echo json_encode(array('state' => 'overlap', 'id' => $search['atm_id']));
				exit;
			}
			$getdata['webmaster_email'] = $this->cbconfig->item('webmaster_email');
			$getdata['webmaster_name'] 	= $this->cbconfig->item('webmaster_name');
			$getdata['site_title'] 		= $this->cbconfig->item('site_title');

			$email_data['auth_code'] 	= $this->generateRandomString();
			$email_data['site_title'] 	= $this->cbconfig->item('site_title');
			$email_data['mem_nickname']	= $this->member->item('mem_nickname');

			$data['email_data'] = $email_data;

			$message = $this->load->view('/mypage/auth_email_form', $data, true);
			$this->load->library('email');
			$this->email->from(element('webmaster_email', $getdata), element('webmaster_name', $getdata));
			$this->email->to($this->input->get('email'));
			$this->email->subject($email_type == 1 ? $this->lang->line('ajax_0') : $this->lang->line('ajax_1'));
			$this->email->message($message);
			$send_result = $this->email->send();
			if($send_result){
				$insert_array = array(
					'atm_subject' 	=> $email_type == 1 ? $this->lang->line('ajax_0') : $this->lang->line('ajax_1'),
					'atm_message' 	=> $message,
					'atm_email'		=> element('webmaster_email', $getdata),
					'atm_type' 		=> $email_type,
					'atm_name'		=> element('webmaster_name', $getdata),
					'atm_rev_mem_id'=> $mem_id,
					'atm_wdate'		=> date('Y-m-d H:i:s'),
					'atm_auth_code' => $email_data['auth_code']
				);
				$this->RS_auth_mail_model->insert($insert_array);
				echo json_encode(array('state' => 'success', 'id' => $this->db->insert_id()));
			}else{
				echo json_encode(array('state' => 'fail', 'id' => 0));
			} 
		}else{
			echo json_encode(array('state' => 'fail', 'id' => 0)); exit;
		}
	}

	function ajax_emailAuth(){
		$_code = $this->input->post('code');
		$_id = $this->input->post('id');
		$_email = $this->input->post('email');
		$mem_id = $this->member->is_member();

		$where = array(
			'atm_rev_mem_id' => $mem_id,
			'atm_state' 	=> 0,
			'atm_wdate >=' 	=> date('Y-m-d H:i:s', strtotime("-6 hours")),
			'atm_auth_code'	=> $_code
		);
		$result = $this->RS_auth_mail_model->get_one($_id, '', $where);
		
		if($result){
			$_hash = md5("emailAuth".rand());
			$this->Member_extra_vars_model->save($mem_id, array('meta_auth_eamil_datetime' => date('Y-m-d H:i:s')));
			$this->Member_extra_vars_model->save($mem_id, array('meta_auth_email_address' => $_email));
			$this->RS_auth_mail_model->update($_id, array('atm_state' => 1, 'atm_hash' => $_hash));

			// echo json_encode($_hash);			
			echo json_encode(array('result' => 'success', 'data' => $_hash, 'type' => $result['atm_type']));
		}else{
			echo json_encode(array('result' => 'fail', 'data' => '', 'type' => ''));
		}
	}

	function ajax_withdraw(){
		//페이지별 언어팩 로드
		if($this->agent->is_mobile()){
			$this->lang->load('cic_mypage_mobile_withdraw', $this->session->userdata('lang'));
		} else {
			$this->lang->load('cic_mypage_withdraw', $this->session->userdata('lang'));
		}
		$mem_id = $this->member->is_member();
		if(!$mem_id){ echo json_encode('fail'); exit;}
		$now = date('Y-m-d H:i:s');
		$_ip = $this->input->ip_address();
		$meta_data = $this->Member_extra_vars_model->get_all_meta($this->member->is_member());
		$withdraw_point = $this->input->post('withdraw_point');
		$member_point = $this->Point_model->get_point_sum($mem_id);

		//2021/2/15일 $withdraw_point > $member_point && !is_numeric($withdraw_point) 조건을 || 로 수정함 문제시 롤백
		if($withdraw_point > $member_point || !is_numeric($withdraw_point)){
			$this->session->set_flashdata('message',$this->lang->line('ajax_1'));
			echo json_decode('fail');
			exit;
		}
		$this->db->trans_start();

		$judgeArr = array(
			'jud_jug_id'	=> 3,
			'jud_state'		=> 1,
			'jud_point'		=> floor($withdraw_point*10)/10,
			'jud_wallet'	=> element('meta_wallet_address',$meta_data),
			'jud_wdate'		=> $now,
			'jud_mem_id'	=> $mem_id,
			'jud_mem_nickname'	=> $this->member->item('mem_nickname'),
			'jud_register_ip'	=> $_ip,
			'jud_deletion'	=> 'N'
		);
		
		$jud_id = $this->RS_judge_model->insert($judgeArr);

		$judgeLogArr = array(
			'jul_jug_id'	=> 3,
			'jul_jud_id'	=> $jud_id,
			'jul_state'		=> 1,
			'jul_mem_id'	=> $mem_id,
			'jul_user_id'	=> $this->member->item('mem_userid'),
			'jul_datetime'	=> $now,
			'jul_ip'		=> $_ip,
			'jul_useragent'	=> $this->agent->agent_string(),
			'jul_data'		=> json_encode($judgeArr)
		);

		$jud_log_id = $this->RS_judge_log_model->insert($judgeLogArr);

		if($jud_id && $jud_log_id){
			$this->point->insert_point(
				$mem_id,
				-1*floor($withdraw_point*10)/10,
				'출금 요청',
				'applywithdraw',
				$jud_id,
				'출금심사 요청'
			);
			$this->db->trans_complete();
			$this->session->set_flashdata('message',$this->lang->line('ajax_0'));
			echo json_encode('success');
		}else{
			$this->session->set_flashdata('message',$this->lang->line('ajax_1'));
			echo json_decode('fail');
		}
	}

	private function generateRandomString($length = 6) {
		$characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	
}
