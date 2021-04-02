<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Judgemission class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * 관리자>CIC 관리>미션심사 controller 입니다.
 */
class Judgemission extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'cic/judgemission';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('Member_group_member', 'Member_group', 'RS_judge', 'RS_missionlist', 'RS_whitelist', 'RS_judge_log', 'RS_judge_denied', 'RS_judge_denyreason', 'Member_extra_vars');

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = 'RS_judge_model';
	protected $jug_id 	 = 1; 

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
		$this->load->helper('rs_common');
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
			'jud_med_wht_id' => $param->sort('jud_med_wht_id', 'asc'),
			'jud_state' => $param->sort('jud_state', 'asc'),
			'jud_wdate' => $param->sort('jud_wdate', 'asc'),
			'jud_mem_nickname' => $param->sort('jud_mem_nickname', 'asc')
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
		$this->{$this->modelname}->allow_search_field = array('mis_title','jud_med_admin', 'jud_med_url', 'jud_mem_nickname', 'jud_wdate', 'jud_mem_nickname'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mis_title','jud_id','jud_med_wht_id','jud_state','jud_wdate', 'jud_mem_nickname'); // 정렬이 가능한 필드

		
		$where = array();
		if (($jud_state = (int) $this->input->get('jud_state')) || $this->input->get('jud_state') === '0') {
			if ($jud_state >= 0) {
				$where['jud_state'] = $jud_state;
			}
		}
		if ($wht_id = (int) $this->input->get('wht_id')) {
			if ($wht_id > 0) {
				$where['jud_med_wht_id'] = $wht_id;
			}
		}
		$join = array(
			array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner'),
			array('table' => 'rs_missionpoint', 'on' => 'rs_judge.jud_mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner'),
			array('table' => 'rs_media', 'on' => 'rs_judge.jud_med_id = rs_media.med_id', 'type' => 'inner'),
		);
		$result = $this->{$this->modelname}
			->get_judge_list($this->jug_id,$per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword,'','', $join);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				
				$where = array(
					'mem_id' => element('mem_id', $val),
				);
				$result['list'][$key]['member_group_member'] = $this->Member_group_member_model->get('', '', $where, '', 0, 'mgm_id', 'ASC');
				$mgroup = array();
				if ($result['list'][$key]['member_group_member']) {
					foreach ($result['list'][$key]['member_group_member'] as $mk => $mv) {
						if (element('mgr_id', $mv)) {
							$mgroup[] = element('mgr_title',$this->Member_group_model->item(element('mgr_id', $mv)));
						}
					}
				}

				$result['list'][$key]['is_superfriend'] = in_array('SF',$mgroup);

				$result['list'][$key]['state'] = element('state', $this->RS_missionlist_model->get_one_mission(element('mis_id', $val)));
				$result['list'][$key]['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['display_name'] = display_username(
					element('mem_userid', $dbmember),
					element('jud_mem_nickname', $val).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
					element('mem_icon', $dbmember)
				);
				$result['list'][$key]['num'] = $list_num--;

				//잔여 포인트보다 출금 포인트 량이 많을 경우, 즉 DB에서 소유하고 있는 포인트가
				// $result['list'][$key]['poi_warn']
			}
		}
		$view['view']['data'] = $result;
		$view['view']['all_whitelist'] = $this->RS_whitelist_model->get_whitelist_list();

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
			'mis_title' 				=> '미션제목',
			'jud_mem_nickname' 	=> '닉네임',
			'jud_med_admin'			=> '관리자명',
			'jud_med_url' 			=> '링크',
			'jud_wdate' 				=> '신청일',
		);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['denyreason_url'] = admin_url($this->pagedir . '/denyreason');
		$view['view']['detail_url'] = admin_url($this->pagedir . '/detail');

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
	 * 세부내용 페이지를 가져오는 메소드입니다
	 */
	public function detail($jid = 0)
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_detail';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 프라이머리키에 숫자형이 입력되지 않으면 에러처리합니다
		 */
		if ($jid) {
			$jid = (int) $jid;
			if (empty($jid) OR $jid < 1) {
				show_404();
			}
		}
		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * 수정 페이지일 경우 기존 데이터를 가져옵니다
		 */
		$getdata = array();
		if ($jid) {
			$join = array(
				array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner'),
				array('table' => 'rs_media', 'on' => 'rs_judge.jud_med_id = rs_media.med_id', 'type' => 'inner'),
				array('table' => 'rs_missionpoint', 'on' => 'rs_judge.jud_mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner')
			);
			$getdata = $this->{$this->modelname}->get_one_judge($this->jug_id, $jid,'','',$join);
			if(empty($getdata) || element('jud_jug_id',$getdata) != $this->jug_id) {
				$this->session->set_flashdata('message','비정상적인접근입니다.(404)');
				$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
				redirect($redirecturl);
			}
		}

			$view['view']['data'] = $getdata;
			$view['view']['data']['state'] = element('state', $this->RS_missionlist_model->get_one_mission(element('mis_id', $getdata)));
			$view['view']['data']['member'] = $dbmember = $this->Member_model->get_by_memid(element('jud_mem_id', $getdata), 'mem_id, mem_userid, mem_nickname, mem_icon');
			$view['view']['data']['display_name'] = display_username(
				element('mem_userid', $dbmember),
				element('jud_mem_nickname', $getdata).'('.(element('mem_userid', $dbmember) ? element('mem_userid', $dbmember) : '탈퇴회원').')',
				element('mem_icon', $dbmember)
			);
			$view['view']['all_denyreason'] = $this->RS_judge_denyreason_model->get_list('','',array('judr_jug_id' => $this->jug_id));
			$view['view']['this_denied_reason'] = $this->RS_judge_denied_model->get_one('','',array('judn_jud_id'=>$jid));

			$where = array(
				'mem_id' => element('jud_mem_id', $getdata),
			);
			$result['list']['member_group_member'] = $this->Member_group_member_model->get('', '', $where, '', 0, 'mgm_id', 'ASC');
			$mgroup = array();
			if ($result['list']['member_group_member']) {
				foreach ($result['list']['member_group_member'] as $mk => $mv) {
					if (element('mgr_id', $mv)) {
						$mgroup[] = element('mgr_title',$this->Member_group_model->item(element('mgr_id', $mv)));
					}
				}
			}

			$view['view']['data']['is_superfriend'] = in_array('SF',$mgroup);

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
		$eventname = 'event_admin_cic_judgemission_excel';
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
		$this->{$this->modelname}->allow_search_field = array('mis_title','jud_med_admin', 'jud_med_url', 'jud_mem_nickname', 'jud_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('mis_title','jud_id','jud_med_wht_id','jud_state','jud_wdate'); // 정렬이 가능한 필드

		$where = array();
		if (($jud_state = (int) $this->input->get('jud_state')) || $this->input->get('jud_state') === '0') {
			if ($jud_state >= 0) {
				$where['jud_state'] = $jud_state;
			}
		}
		if ($wht_id = (int) $this->input->get('wht_id')) {
			if ($wht_id > 0) {
				$where['jud_med_wht_id'] = $wht_id;
			}
		}
		$join = array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner');
		$result = $this->{$this->modelname}
		->get_judge_list($this->jug_id,'', '', $where, '', $findex, $forder, $sfield, $skeyword,'','', $join);

		$_whitelist = $this->RS_whitelist_model->get();
		$whitelistArr = array();
		foreach($_whitelist as $l){
			$whitelistArr[element('wht_id',$l)] = element('wht_title',$l);
		}

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['register_member'] = $this->Member_model->get_by_memid(element('jud_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['modifier_member'] = $this->Member_model->get_by_memid(element('jud_modifier_mem_id', $val), 'mem_id, mem_userid, mem_nickname, mem_icon');
				$result['list'][$key]['judn_reason'] 		 = element('judn_reason',$this->RS_judge_denied_model->get_one('','judn_reason', array('judn_jud_id' => element('jud_id',$val))));
				$result['list'][$key]['wht_title']   		 = element(element('jud_med_wht_id',$val),$whitelistArr);
				// $domainArr = $this->{$this->modelname}->get_explode_domain_list(element('wht_domains', $val));
				// if(count($domainArr)>1){
				// 	$result['list'][$key]['domain'] = '';
				// 	foreach($domainArr as $l){
				// 		$result['list'][$key]['domain'] .= $l.'\n';
				// 	}
				// } else {
				// 	$result['list'][$key]['domain'] = $domainArr[0];
				// }
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
		header('Content-Disposition: attachment; filename=미션심사목록_' . cdate('Y_m_d') . '.xls');
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
				'rules' => array('trim','required','in_list[confirm,deny,warn,cancel]')
			),
			array(
				'field' => 'state', 
				'label' => 'STATE', 
				'rules' => array('trim','is_natural','required','in_list[0,1,3]')
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
			if(element('jud_state',$getdata) != 1 && ($this->input->post('value') != 'cancel' && element('jud_state',$getdata) != 3)){
				$return = array(
					'type' => 'error',
					'data' => 'already_done'
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
				if($this->input->post('state') == 3 && element('jud_jug_id',$getdata) == 1 && $this->input->post('value') != 'cancel'){ //미션심사 승인인 경우 포인트 지급
					$this->point->insert_point();
				}
				$warn_count = 0;
				$getuserdata = $this->Member_model->get_by_memid(element('jud_mem_id',$getdata), 'mem_id, mem_userid, mem_denied');
				if($this->input->post('value') == 'deny' || $this->input->post('value') == 'warn'){
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

	/*
	** 수정페이지에서 ajax로 마감하기
	*/
	public function ajax_givepoint(){
		
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cic_judgemission_ajax_givepoint';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$primary_key = $this->{$this->modelname}->primary_key;

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'gp_jud_id',
				'label' => 'jud_id',
				'rules' => 'trim|required|is_natural_no_zero',
			),
			array(
				'field' => 'gp_giveperc',
				'label' => 'percentage',
				'rules' => 'trim|required|is_natural',
			),
		);
		$this->form_validation->set_rules($config);


		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {
			$this->form_validation->set_error_delimiters('', '');
			$return = array(
				'type' => 'error',
				'data' => $this->form_validation->error_string()
			);
			echo json_encode($return,JSON_UNESCAPED_UNICODE);
			exit;
		} else {

			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$jid = $this->input->post('gp_jud_id');
			$join = array(
				array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner'),
				array('table' => 'rs_media', 'on' => 'rs_judge.jud_med_id = rs_media.med_id', 'type' => 'inner'),
				array('table' => 'rs_missionpoint', 'on' => 'rs_judge.jud_mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner'),
			);
			$getdata = $this->{$this->modelname}->get_one_judge($this->jug_id, $jid,'','',$join);
			if(empty($getdata) || element('jud_jug_id',$getdata) != $this->jug_id) {
				$return = array(
					'type' => 'error',
					'data' => 'no judge data found'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}
			$state =  element('state', $this->RS_missionlist_model->get_one_mission(element('jud_mis_id', $getdata)));
			if($state !== 'end') {
				$return = array(
					'type' => 'error',
					'data' => 'mission didn\'t end yet'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}
			if((int)element('jud_state',$getdata) !== 3) {
				$return = array(
					'type' => 'error',
					'data' => 'already gave or not deserved'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}
			$expect_point = rs_cal_expected_point2(element('mis_per_token', $getdata), element('mis_max_point', $getdata), element('med_superpoint', $getdata), $getdata);
			$percentage = $this->input->post('gp_giveperc');
			$give_point = $expect_point * $percentage / 100;
			$give_point = floor($give_point*10)/10; //소숫점 버림을 위해
			$left_point = element('mis_per_token',$getdata) - $give_point;
			if($left_point<0){
				$return = array(
					'type' => 'error',
					'data' => 'exceed maximum point'
				);
				echo json_encode($return,JSON_UNESCAPED_UNICODE);
				exit;
			}
			$mem_id = element('jud_mem_id',$getdata);
			$content = '"' . element('mis_title', $getdata) . '" 미션 "' . element('wht_title',$getdata) . '( '.element('jud_med_name',$getdata) . ' | ' . element('jud_med_id',$getdata) . ' )' . '" 미디어에 해당하는 PERPOINT 지급';
			$this->point->insert_point(
				$mem_id,
				$give_point,
				$content,
				'@byadmin',
				$mem_id,
				$this->member->item('mem_id') . '-' . uniqid('')
			);

			$update_jud = array(
				'jud_point' => $give_point,
				'jud_state' => 5
			);
			$this->RS_judge_model->update($jid, $update_jud);

			$update_leftpoint = array(
				'mis_left_token' => $left_point
			);
			$this->RS_missionlist_model->update(element('jud_mis_id', $getdata), $update_leftpoint);
			
			$return = array(
				'type' => 'success',
				'data' => 'updated'
			);
			echo json_encode($return,JSON_UNESCAPED_UNICODE);
			exit;
			Events::trigger('after', $eventname);
		}

	}


	//리스트 선택 승인
	public function set_state_list(){
		$postdata = $this->input->post();
		$jud_list = element('chk',$postdata);

		$list = [];

		$join = array(
			array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner'),
			array('table' => 'rs_media', 'on' => 'rs_judge.jud_med_id = rs_media.med_id', 'type' => 'inner'),
			array('table' => 'rs_missionpoint', 'on' => 'rs_judge.jud_mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner'),
		);
		
		foreach($jud_list as $_jud_id){
			$getdata = $this->{$this->modelname}->get_one_judge(1, $_jud_id,'','',$join);
			if($getdata){
				if(element('jud_state', $getdata) == 1){
					$list[] = $getdata;
				}
			}
		}

		$datetime = cdate('Y-m-d H:i:s');
		$update = array(
			'jud_state' => 3,
			'jud_mdate' => $datetime,
			'jud_modifier_mem_id' => $this->session->userdata('mem_id'),
			'jud_modifier_ip' => $this->input->ip_address(),
		);

		foreach($list as $l){
			$this->{$this->modelname}->update(element('jud_id',$l), $update);
			$getuserdata = $this->Member_model->get_by_memid(element('jud_mem_id',$l), 'mem_id, mem_userid, mem_denied');
			/*
			** 로그 쌓기
			*/
			$insert = array(
				'jul_jug_id' 		=> element('jud_jug_id',$l),
				'jul_jud_id' 		=> element('jud_id',$l),
				'jul_state'  		=> $this->input->post('state'),
				'jul_mem_id'  	=> element('jud_mem_id',$l),
				'jul_user_id' 	=> element('mem_userid',$getuserdata),
				'jul_datetime'  => $datetime,
				'jul_ip'  	  	=> $this->input->ip_address(), 
				'jul_useragent' => $this->agent->agent_string(),
			);
			$this->RS_judge_log_model->insert($insert);
		}

		$this->session->set_flashdata('message','승인이 완료되었습니다.');
		$redirecturl = admin_url($this->pagedir . '?' . $this->querystring->output());
		redirect($redirecturl);
	}
}
