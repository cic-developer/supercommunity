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
class Auth extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/auth';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_auth_mail','Member_extra_vars');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_auth_mail';

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

    public function index(){
        // 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_auth_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
        $param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : 'mev_value';
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');
        $view['view']['sort'] = array(
			'mev_value' => $param->sort('mev_value', 'asc'),
        );
        
        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
        $where = array(
            'member_extra_vars.mev_key' => 'meta_wallet_address',
            'ext2.mev_key'  => 'meta_wallet_auth_datetime'
		);
		if($start_date){
			$where['ext2.mev_value >= '] = $start_date." 00:00:00";
		}
		if($end_date){
			$where['ext2.mev_value <= '] = $end_date." 23:59:59";
		}

		$result = $this->Member_extra_vars_model->_get_list_common('member_extra_vars.mem_id, ext2.mev_value AS wallet_date, member_extra_vars.mev_value AS wallet_address', array('table' => 'member_extra_vars AS ext2', 'on' => "ext2.mev_key = 'meta_wallet_auth_datetime' AND ext2.mem_id = member_extra_vars.mem_id") ,$per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('mem_nickname', $dbmember),
					element('mem_icon', $dbmember)
                );
                $result['list'][$key]['num'] = $list_num--;
			}
        }
        $view['view']['data'] = $result;

		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;
        
        /**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('ad_memo' => '메모사항');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['listall_url'] = admin_url($this->pagedir);

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
    }

    /**
	 * 출금심사 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_auth_excel';
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

		$where = array(
            'member_extra_vars.mev_key' => 'meta_wallet_address',
            'ext2.mev_key'  => 'meta_wallet_auth_datetime'
		);
		if($start_date){
			$where['ext2.mev_value >= '] = $start_date." 00:00:00";
		}
		if($end_date){
			$where['ext2.mev_value <= '] = $end_date." 23:59:59";
		}

		$result = $this->Member_extra_vars_model
        ->_get_list_common('member_extra_vars.mem_id, ext2.mev_value AS wallet_date, member_extra_vars.mev_value AS wallet_address', array('table' => 'member_extra_vars AS ext2', 'on' => "ext2.mev_key = 'meta_wallet_auth_datetime' AND ext2.mem_id = member_extra_vars.mem_id") ,$per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		// print_r($result);
		// exit;
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = element('mem_userid', $dbmember).'('.element('mem_nickname', $dbmember).')';
                $result['list'][$key]['num'] = $list_num--;
			}
        }

		$view['view']['data'] = $result;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=지갑인증 목록' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir  . '/excel', $view, true);
	}

}
?>