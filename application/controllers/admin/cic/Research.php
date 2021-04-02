<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>문의목록 controller 입니다.
 */
class Research extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/Research';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Research');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'Research_model';

	protected $_filePath = 'uploads/research/';
	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array','download');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring'));
    }

    public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_research_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$view['view']['sort'] = array(
			'res_wdate' => $param->sort('res_wdate', 'asc')
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/*
		** 게시판 목록에 필요한 정보를 가져옵니다.
		*/
		$this->{$this->modelname}->allow_search_field = array(); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('res_wdate'); // 정렬이 가능한 필드

		$where = array();

		$result = $this->{$this->modelname}->getList($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		$view['view']['data'] = $result;

		/*
		** primary key 정보를 저장합니다
		*/
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/*
		** 페이지네이션을 생성합니다
		*/
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/*
		** 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		*/
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['write_url'] = admin_url($this->pagedir . '/write');
		$view['view']['list_update_url'] = admin_url($this->pagedir . '/listupdate/?' . $param->output());
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/*
		** 어드민 레이아웃을 정의합니다
		*/
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
		// print_r($this->layout); exit;
	}

	/**
	 * 미션추가 또는 수정 페이지를 가져오는 메소드입니다
	 */
	public function detail($res_id = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_research_detail';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($res_id) {
			$res_id = (int) $res_id;
		}
		if (empty($res_id) OR $res_id < 1) {
			$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
			$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
			redirect($redirecturl);
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($res_id) {
			$getdata = $this->{$this->modelname}->get_one($res_id);
			if(empty($getdata)) {
				$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
				$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
				redirect($redirecturl);
			}
		}

		$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		$view['view']['data'] = $getdata;

		$view['view']['member'] = $dbmember = $this->Member_model->get_by_memid(element('mem_id', $getdata), 'mem_id, mem_userid, mem_nickname, mem_icon');
		$view['view']['display_name'] = display_username(
			element('mem_userid', $dbmember),
			element('mem_nickname', $getdata).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
			element('mem_icon', $dbmember)
		);
		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $primary_key;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'detail');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	function download($res_id){
		$result = $this->{$this->modelname}->get_one($res_id);
		$file_name = $result['res_file'];
		$full_path = file_get_contents(base_url($this->_filePath).$file_name);
		force_download($file_name, $full_path, TRUE);
	}

	function listdelete(){
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_research_listdelete';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->{$this->modelname}->delete($val);
				}
			}
		}

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
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}
}
?>