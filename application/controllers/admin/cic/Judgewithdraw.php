<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Judgewithdraw class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>출금심사 controller 입니다.
 */
class Judgewithdraw extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/judgewithdraw';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('RS_judge','RS_whitelist','RS_judge_log','RS_judge_denied','RS_judge_denyreason','Member_extra_vars','Point');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_judge_model';
	protected $jug_id 	 = 3; 

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

		if($this->session->userdata('reconfirm_access') != 1){
			redirect('/admin/reconfirm?returnURL=' . rawurlencode(site_url('/admin/cic/judgewithdraw')));
		}

	}

	/**
	 * 목록을 가져오는 메소드입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_index';
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
			'mis_title' => $param->sort('mis_title', 'asc'),
			'jud_id' => $param->sort('jud_id', 'asc'),
			'jud_point' => $param->sort('jud_point', 'asc'),
			'jud_state' => $param->sort('jud_state', 'asc'),
			'jud_wdate' => $param->sort('jud_wdate', 'asc'),
		);
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;

		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('jud_id','jud_wallet','jud_mem_nickname', 'jud_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('jud_id','jud_mem_nickname','jud_point','jud_wdate'); // 정렬이 가능한 필드

		
		$where = array();
		if (($jud_state = (int) $this->input->get('jud_state')) || $this->input->get('jud_state') === '0') {
			if ($jud_state >= 0) {
				$where['jud_state'] = $jud_state;
			}
		}
		$result = $this->{$this->modelname}
			->get_judge_list($this->jug_id,$per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['denyreason'] = element('judn_reason',$this->RS_judge_denied_model->get_one('', '', array('judn_jud_id' => element('jud_id', $val))));
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('jud_mem_nickname', $val).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['num'] = $list_num--;
				$result['list'][$key]['save_point'] = $this->Point_model->get_point_sum(element('jud_mem_id', $val));
				if(element('jud_state', $val) == 1){
					$result['list'][$key]['point_wrong'] = ($this->Point_model->get_point_sum(element('jud_mem_id', $val)) < -1) ? true : false;
				}else{
					$result['list'][$key]['point_wrong'] = false;
				}

			}
		}
		$view['view']['data'] = $result;
		
		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array(
			'jud_wallet' 						=> '지갑주소',
			'jud_mem_nickname' 	=> '닉네임',
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_distribute_url'] = admin_url($this->pagedir . '/listdistribute/?' . $param->output());

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
	 * 출금심사 페이지에서 선택지급처리를 하는 경우 실행되는 메소드입니다
	 */
	public function listdistribute()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgewithdraw_listdistribute';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			$datetime = cdate('Y-m-d H:i:s');
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					
					$distributewhere = array(
						'jud_jug_id' => 3,
						'jud_state' => 3,
					);
					$distributeupdate = array(
						'jud_state' => 5,
					);
					$this->{$this->modelname}->update($val,$distributeupdate,$distributewhere);
					

					// 지급완료처리 로그 기록
					$insert = array(
						'jul_jug_id' 		=> 3,
						'jul_jud_id' 		=> $val,
						'jul_state'  		=> 5,
						'jul_mem_id'  	=> $this->session->userdata('mem_id'),
						'jul_user_id' 	=> element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
						'jul_datetime'  => $datetime,
						'jul_ip'  	  	=> $this->input->ip_address(),
						'jul_useragent' => $this->agent->agent_string(),
					);
					$this->RS_judge_log_model->insert($insert);
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
			'정상적으로 지급완료처리되었습니다'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());

		redirect($redirecturl);
	}

	
	/**
	 * 출금심사 목록을 엑셀로 데이터를 추출합니다.
	 */
	public function excel()
	{

		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgewithdraw_excel';
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
		$this->{$this->modelname}->allow_search_field = array('jud_id','jud_wallet','jud_mem_nickname', 'jud_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('jud_id','jud_mem_nickname','jud_point','jud_wdate'); // 정렬이 가능한 필드

		$where = array();

		if (($jud_state = (int) $this->input->get('jud_state')) || $this->input->get('jud_state') === '0') {
			if ($jud_state >= 0) {
				$where['jud_state'] = $jud_state;
			}
		}
		$result = $this->{$this->modelname}
			->get_judge_list($this->jug_id,'', '', $where, '', $findex, $forder, $sfield, $skeyword);

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['register_member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['modifier_member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_modifier_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['judn_reason'] 		 = element('judn_reason',$this->RS_judge_denied_model->get_one('','judn_reason', array('judn_jud_id' => element('jud_id',$val))));
			}
		}

		$view['view']['data'] = $result;

		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;


		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=출금심사목록_' . cdate('Y_m_d') . '.xls');
		echo $this->load->view('admin/' . ADMIN_SKIN . '/' . $this->pagedir  . '/excel', $view, true);
	}

	
	/*
	** 수정페이지에서 ajax로 마감하기
	*/
	public function ajax_set_state(){

		/*
		** Validation 라이브러리를 가져옵니다
		*/

		// mis_thumb_type 용 form_validation 데이터 저장
		$this->{$this->modelname}->post_form_data = array(
			'value'		=> $this->input->post('value')
		);

		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'jud_id', 
				'label' => 'JUD_ID', 
				'rules' => array('trim','is_natural','required','min_length[1]','max_length[11]')
			),
			array(
				'field' => 'value', 
				'label' => 'VALUE', 
				'rules' => array('trim','required','in_list[confirm,deny,warn,withdraw]')
			),
			array(
				'field' => 'state', 
				'label' => 'STATE', 
				'rules' => array('trim','is_natural','required','in_list[0,3,5]')
			),
			array(
				'field' => 'deny', 
				'label' => '반려사유', 
				'rules' => array('trim', array('check_deny',array($this->{$this->modelname},'check_deny_data')))
			),
			array(
				'field' => 'warn', 
				'label' => '경고사유', 
				'rules' => array('trim', array('check_warn',array($this->{$this->modelname},'check_warn_data')))
			)
		);
		$this->form_validation->set_rules($config);
		$form_validation = $this->form_validation->run();
		/*
		** jud_id 값을 전송하지 않은 경우
		*/
		if($form_validation === false){
			$this->form_validation->set_error_delimiters('', '');
			$return = array(
				'type' => 'error',
				'data' => $this->form_validation->error_string()
			);
			echo json_encode($return,JSON_UNESCAPED_UNICODE);
			exit;

		} else {
			$jud_id = $this->input->post('jud_id');
			$getdata = $this->{$this->modelname}->get_one_judge($this->jug_id, $jud_id);
			/*
			** mis_id 값에 해당하는 미션이 없는 경우
			*/
			if(empty($getdata)){
				$return = array(
					'type' => 'error',
					'data' => 'no_data_found'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}

			/*
			** 이미 처리된 경우
			*/
			// if(element('jud_state',$getdata) == $this->input->post('state')){
			if(element('jud_state',$getdata) != 1 && element('jud_state',$getdata) != 3){
				$return = array(
					'type' => 'error',
					'data' => 'already_done'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}

			if(($this->input->post('state') === '5' && element('jud_state',$getdata) != 3)
				|| ($this->input->post('state') === '3' && element('jud_state',$getdata) != 1)
				|| ($this->input->post('state') === '0' && element('jud_state',$getdata) != 1)){
				$return = array(
					'type' => 'error',
					'data' => 'data_wrong'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}

			$datetime = cdate('Y-m-d H:i:s');
			$update = array(
				'jud_state' => $this->input->post('state'),
				'jud_mdate' => $datetime,
				'jud_modifier_mem_id' => $this->session->userdata('mem_id'),
				'jud_modifier_ip' => $this->input->ip_address(),
			);
			if($this->{$this->modelname}->update(element('jud_id',$getdata), $update)){
				$warn_count = 0;
				$getuserdata = $this->Member_model->get_by_memid(element('jud_mem_id',$getdata), 'mem_id, mem_userid, mem_denied');
				if($this->input->post('state') === '0' &&($this->input->post('value') == 'deny' || $this->input->post('value') == 'warn')){

					/*
					** 출금 반려시 차감되었던 포인트 반환
					*/
					$this->point->insert_point(
						element('jud_mem_id', $getdata),
						element('jud_point', $getdata),
						'출금심사 반려로 인한 PERPOINT 반환',
						'judgewithdraw',
						element('jud_id', $getdata),
						'출금심사 반려'
					);

					$extradata = $this->Member_extra_vars_model->get_all_meta(element('jud_mem_id',$getdata));
					// $is_warn_1 = element('mem_warn_1',$extradata);
					$is_warn_1 = $this->Member_extra_vars_model->item(element('jud_mem_id',$getdata),'mem_warn_1');
					if($is_warn_1) $warn_count ++;
					// $is_warn_2 = element('mem_warn_2',$extradata);
					$is_warn_2 = $this->Member_extra_vars_model->item(element('jud_mem_id',$getdata),'mem_warn_2');
					if($is_warn_2) $warn_count ++;
					/*
					** 반려 / 경고 사유 기록
					*/
						$insert = array(
							'judn_jud_id' => element('jud_id',$getdata),
							'judn_reason' => $this->input->post('deny')
						);
						$this->RS_judge_denied_model->insert($insert);

						if($this->input->post('value') == 'warn'){
							if(!$is_warn_1){
								$insert = array(
									'mem_warn_1' => $this->input->post('warn')
								);
								$this->Member_extra_vars_model->save(element('jud_mem_id',$getdata), $insert);
								$warn_count ++;
							} else if(!$is_warn_2){
								/*
								** 경고 2회시 차단적용
								*/
								$insert = array(
									'mem_warn_2' => $this->input->post('warn')
								);
								$this->Member_extra_vars_model->save(element('jud_mem_id',$getdata), $insert);

								$update = array(
									'mem_denied' => 1
								);
								$this->Member_model->update(element('jud_mem_id',$getdata),$update);
								$warn_count ++;
							} else {
								/*
								** 이미 2회 차단되있을 시 그냥 반려처리
								*/
								if(!element('mem_denied',$getuserdata)){
									$update = array(
										'mem_denied' => 1
									);
									$this->Member_model->update(element('jud_mem_id',$getdata),$update);
								}
							}
						}
				}

				/*
				** 로그 쌓기
				*/
				$insert = array(
					'jul_jug_id' 		=> element('jud_jug_id',$getdata),
					'jul_jud_id' 		=> element('jud_id',$getdata),
					'jul_state'  		=> $this->input->post('state'),
					'jul_mem_id'  	=> element('jud_mem_id',$getdata),
					'jul_user_id' 	=> element('mem_userid',$getuserdata),
					'jul_datetime'  => cdate('Y-m-d H:i:s'),
					'jul_ip'  	  	=> $this->input->ip_address(),
					'jul_useragent' => $this->agent->agent_string(),
				);
				$this->RS_judge_log_model->insert($insert);
				/*
				** 정상 마감처리 된 경우
				*/
				$return = array(
					'type' => 'success',
					'data' => 'updated',
					'warn_count' => $warn_count
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;

			} else {

				/*
				** 마감 update 중 오류가 발생한 경우
				*/
				$return = array(
					'type' => 'error',
					'data' => 'error_occur'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;

			}
		}
	}
}
