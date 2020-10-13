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
class Inquiry extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/Inquiry';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_inquiry');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_inquiry_model';

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

    public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_inquiry_index';
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
			'inq_wdate' => $param->sort('inq_wdate', 'asc')
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
		$this->{$this->modelname}->allow_search_field = array('inq_group', 'inq_email', 'inq_tel'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('inq_wdate'); // 정렬이 가능한 필드

		$where = array();

		if(($inq_type = (int)$this->input->get('inq_type')) || $this->input->get('inq_type')==='0'){
			if ($jud_state >= 0) {
				$where['inq_type'] = $inq_type;
			}
		}

		// if ($wht_id = (int) $this->input->get('wht_id')) {
		// 	if ($wht_id > 0) {
		// 		$where['med_wht_id'] = $wht_id;
		// 	}
		// }

		$where['inq_deletion'] = 'N';
		// print_r($this->{$this->modelname});
		// exit;
		$result = $this->{$this->modelname}->get_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
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
		$search_option = array(
			'inq_group' => '그룹명',
			'inq_email' => '이메일',
			'inq_contents' => '내용'
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
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
	public function detail($inq_id = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_inquiry_detail';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($inq_id) {
			$inq_id = (int) $inq_id;
		}
		if (empty($inq_id) OR $inq_id < 1) {
			$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
			$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
			redirect($redirecturl);
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($inq_id) {
			$getdata = $this->{$this->modelname}->get_one($inq_id);
			if(empty($getdata)) {
				$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
				$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
				redirect($redirecturl);
			}
		}

		$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		$view['view']['message'] = $file_error;

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
	
	/**
	 * 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_inquiry_excel';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$findex = $this->input->get('findex', null, $this->{$this->modelname}->primary_key);
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('inq_group', 'inq_email', 'inq_tel'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('inq_wdate'); // 정렬이 가능한 필드

		if(($inq_type = (int)$this->input->get('inq_type')) || $this->input->get('inq_type')==='0'){
			if ($jud_state >= 0) {
				$where['inq_type'] = $inq_type;
			}
		}

		// if ($wht_id = (int) $this->input->get('wht_id')) {
		// 	if ($wht_id > 0) {
		// 		$where['med_wht_id'] = $wht_id;
		// 	}
		// }

		$where['inq_deletion'] = 'N';
		// print_r($this->{$this->modelname});
		// exit;
		$result = $this->{$this->modelname}->get_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=문의사항_목록_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir  . '/excel', $view, true);
	}


}
?>