<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Judge model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_judge_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_judge';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'jud_id'; // 사용되는 테이블의 프라이머리키

  /*
  ** 목록->detail 페이지에서 수정시 사용
  */
  public $set_wht_id = null;
	public $set_met_id = array();
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_judge_list($jug_id = 0, $limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR', $select = '', $join = ''){

    if($where && is_array($where)){
      if(!element('jud_jug_id',$where)) {
				if(is_array($jug_id)){
					$where_jug = '(';
					for($i=0;$i<count($jug_id);$i++){
						if($i != 0) $where_jug .= ' or ';
						$where_jug .= 'jud_jug_id = '.element($i,$jug_id);
					}
					$where_jug .= ')';
					$where[$where_jug] = null;
				} else {
					$where['jud_jug_id'] = $jug_id;
				}
			}
      if(!element('jud_deletion',$where)) $where['jud_deletion'] = 'N';
    } else {
			if(!element('jud_jug_id',$where)){
				if(is_array($jug_id)){
					$where_jug = '(';
					for($i=0;$i<count($jug_id);$i++){
						if($i != 0) $where_jug .= ' or ';
						$where_jug .= 'jud_jug_id = '.element($i,$jug_id);
					}
					$where_jug .= ')';
					$where = array(
						$where_jug   => null,
						'jud_deletion' => 'N',
					);
				} else {
					$where = array(
						'jud_jug_id'   => $jug_id,
						'jud_deletion' => 'N',
					);
				}
			}
		}

		if($join && is_array($join)){

			$inner_array_join = false;
			$already_inner_array_join_judge_group = false;
			$already_inner_array_join_whitelist = false;
			$array_join = false;
			$already_array_join_judge_group = false;
			$already_array_join_whitelist = false;

			foreach($join as $key => $value){
				if(is_array($value)){
					$inner_array_join = true;
					foreach($value as $skey => $svalue){
						if($key == 'table' && $value == 'rs_judge_group'){
							$already_inner_array_join_judge_group = true;
						}
						if($key == 'table' && $value == 'rs_whitelist'){
							$already_inner_array_join_whitelist = true;
						}
					}
				} else {
					$array_join = true;
					if($key == 'table' && $value == 'rs_judge_group'){
						$already_array_join_judge_group = true;
					}
					if($key == 'table' && $value == 'rs_whitelist'){
						$already_array_join_whitelist = true;
					}
				}
			}
			if($inner_array_join){
				if(!$already_inner_array_join_judge_group){
					$newArr = array();
					$newArr[] = array('table' => 'rs_judge_group', 'on' => 'rs_judge.jud_jug_id = rs_judge_group.jug_id', 'type' => 'inner');
					foreach($join as $value){
						$newArr[] = $value;
					}
					$join = $newArr;
				}
				if(!$already_inner_array_join_whitelist && $jug_id != 3){
					$newArr = array();
					$newArr[] = array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner');
					foreach($join as $value){
						$newArr[] = $value;
					}
					$join = $newArr;
				}
			}
			if ($array_join){
				$newArr = array();
				if(!$already_array_join_whitelist && $jug_id != 3){
					$newArr[] = array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner');
				}
				if(!$already_array_join_judge_group){
					$newArr[]= 	array('table' => 'rs_judge_group', 'on' => 'rs_judge.jud_jug_id = rs_judge_group.jug_id', 'type' => 'inner');
				}
				$newArr[] =	$join;
				$join = $newArr;
			}
		} else {
			$join = array(
				array('table' => 'rs_judge_group', 'on' => 'rs_judge.jud_jug_id = rs_judge_group.jug_id', 'type' => 'inner'),
			);
			if($jug_id != 3) $join[] = array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner');
		}
    $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

  public function get_one_judge($jug_id, $primary_value = '', $select = '', $where = '', $join = '')
	{
		$search_where = array(
			$this->primary_key => $primary_value
		);
		if(is_array($where)){
			$search_where = array_merge($search_where,$where);
		}
    //get_one으로는 join이 안되서 어쩔 수 없이 위 함수를 활용
    $result = $this->get_judge_list($jug_id,1,0,$search_where, '', $this->primary_key, 'desc', '', '','',$select,$join);
    if(element('total_rows',$result) === 0){
      return array();
    } else {
      return element(0,element('list',$result));
    }
	}

	/*
  ** 클릭한 버튼에 따라 필수값 여부 확인을 위해 데이터 저장
  ** 한글이 입력되지는 않았는지 확인하는 function
  */
  public $post_form_data = array(
		'value'		=> null
  );
	public function check_deny_data($value){
		$this->lang->load('cic_formvalidation_callback', $this->session->userdata('lang'));
		$data = $this->post_form_data;
		if(element('value',$data) == 'deny' && !$value){
			$this->form_validation->set_message('check_deny', '반려시 반려사유를 입력하셔야합니다.');
			return false;
		}
		return true;
	}
	public function check_warn_data($value){
    $data = $this->post_form_data;
		if(element('value',$data) == 'warn' && !$value){
			$this->form_validation->set_message('check_warn', '경고+반려시 반려사유를 입력하셔야합니다.');
			return false;
		}
		if(element('value',$data) == 'warn' && !$value){
			$this->form_validation->set_message('check_warn', '경고+반려시 경고사유를 입력하셔야합니다.');
			return false;
		}
		return true;
	}


  function check_wht_id_is($wht_id){
		$this->lang->load('cic_formvalidation_callback', $this->session->userdata('lang'));
    $this->load->model('RS_whitelist_model');
    $value = $this->RS_whitelist_model->get_one($wht_id,'wht_id',array('wht_deletion'=>'N'));
    if(!element('wht_id',$value)){
      $this->form_validation->set_message('check_wht_id_is', $this->lang->line('check_wht_id_is1'));
      return false;
    } else {
      return true;
    }
  }

  function check_wht_id_url($check_url){
		$this->lang->load('cic_formvalidation_callback', $this->session->userdata('lang'));
    $value = $this->check_url_right($this->set_wht_id, $check_url);
    if(!$value){
      $this->form_validation->set_message('check_wht_id_url', $this->lang->line('check_wht_id_url1'));
      return false;
    } else {
      return true;
    }
  }

  function check_met_id_is($met_id_array){
		$this->lang->load('cic_formvalidation_callback', $this->session->userdata('lang'));
    $met_id_array = $this->set_met_id;
    $this->load->model('RS_mediatype_model');
    $getdata = $this->RS_mediatype_model->get_mediatype_index();
    $flag = false;
    $emergFlag = false;
    foreach($met_id_array as $l){

      //목록에 하나라도 있으면 true
      if(in_array($l,$getdata)) $flag = true;

      //오히려 array 에 존재하지 않으면 악성시도로 판단
      if(!in_array($l,$getdata)) {
        $emergFlag = true;
        break;
      }

    }
    if($emergFlag){
      $this->form_validation->set_message('check_met_id_is', $this->lang->line('check_met_id_is1'));
      return false;
    }
    if($flag){
      return true;
    } else {
      $this->form_validation->set_message('check_met_id_is', $this->lang->line('check_met_id_is2'));
      return false;
    }
  }

  function check_url_right($wht_id, $check_url){
    $this->load->model('RS_whitelist_model'); //화이트 리스트 확인
    $whiteList = $this->RS_whitelist_model->get_whitelist_domain(array('wht_id' => $wht_id)); //화이트 리스트
    $whiteFlag = false;
    foreach($whiteList AS $w){
      if(mb_substr_count($check_url,$w)){ $whiteFlag = true; break; }  //만일 해당 화이트 리스트의 도메인이 있다면 whiteFlag true로 변환후 break
    }
    if($whiteFlag){
      return true;
    } else {
      return false;
    }
  }

  public function replace_apply_mission_judge($jud_arr){
	$this->load->model('RS_missionlist_model');
	$this->load->model('RS_media_model');
	$this->db->trans_start();
	// return $jud_arr;
	if(! is_array($jud_arr)){return is_array($jud_arr);}
	$mem_id = $this->session->userdata('mem_id');
	$mem_data =  $this->Member_model->get_by_memid($mem_id);
	if(! $mem_data){ return 'not found member data'; }
	$_now = date('Y-m-d H:i:s');
	$_ip = $this->input->ip_address();
	$result = array();
	$mis_arr = array();
	$mis_id = 0;
	
    foreach($jud_arr AS $jud){
		//미디어가 심사중에 있는지 확인
		$other_judge = $this->RS_media_model->check_other_judge($jud['jud_med_id']);
		if($other_judge != '미션심사 진행중입니다.' && $other_judge != false){
			if($other_judge === true){
				return 'error occur for check other judge';
			}else{
				return $other_judge;
			}
		}
	//   $this->db->join('rs_mission_apply rs_apply','rs_apply.med_id = rs_media.med_id', 'LEFT OUTER');
		$mission_data = $this->RS_missionlist_model->get_one_mission($jud['jud_mis_id']);
		if($mission_data['state'] != 'process'){ return 'mission closed'; }
		$this->db->join('rs_judge', "rs_judge.jud_med_id = rs_media.med_id AND rs_judge.jud_deletion = 'N' AND rs_judge.jud_jug_id = 1 AND rs_judge.jud_mis_id = ".$jud['jud_mis_id']." AND rs_judge.jud_med_id = ".$jud['jud_med_id'], 'LEFT OUTER');
		$this->db->where('rs_media.med_id', $jud['jud_med_id']);
		$this->db->where('rs_media.med_deletion', 'N');
		$this->db->where('rs_media.mem_id', $mem_id);
		$this->db->order_by('ISNULL(rs_judge.jud_wdate)','ASC');
		$this->db->order_by('rs_judge.jud_wdate','DESC');
		$this->db->from('rs_media');
		$this->db->select('rs_media.*, rs_judge.*');
		$med_data = $this->db->get()->row_array();

		if(!$med_data){return 'not found media data : '.$this->db->last_query();}

		switch(element('jud_state',$med_data)){
			case 0 :
			case NULL :
			$tmpArr = array(
				'jud_mem_id'      => $mem_id,
				'jud_register_ip' => $_ip,
				'jud_wdate'       => $_now,
				'jud_med_id'      => $med_data['med_id'],
				'jud_med_name'    => $med_data['med_name'],
				'jud_med_admin'   => $med_data['med_admin'],
				'jud_med_wht_id'  => $med_data['med_wht_id'],
				'jud_med_url'     => $med_data['med_url'],
				'jud_mem_nickname'=> $mem_data['mem_nickname'],
				'jud_superpoint'  => $med_data['med_superpoint']
			);
			$applyArr = array('med_id' => $med_data['med_id'], 'mis_id' => $jud['jud_mis_id']);

			$merge_data =array_merge($jud, $tmpArr);
			$jud_id = $this->insert($merge_data);
			$this->db->insert('rs_mission_apply', $applyArr);
			//미션 총액 더하기
			$this->db->where('mip_mis_id', $jud['jud_mis_id']);
			$this->db->set('mip_tpoint', 'mip_tpoint + '.$med_data['med_superpoint'], false);
			$this->db->update('rs_missionpoint');
			//총액 가져와서 해당 미션의 최고 금액과 비교하여 오버되었으면 종료
			$this->db->where('mip_mis_id', $jud['jud_mis_id']);
			$total_point = $this->db->get('rs_missionpoint')->row_array()['mip_tpoint'];
			$max_point = $mission_data['mis_max_point']*1.01; //(최대 미디어 super point) * 101% 
			if($max_point < $total_point){ return 'mission over max point';}
			if(($mission_data['mis_max_point'] <= $total_point) && ($max_point >= $total_point)){ 
				/*만일 해당 미션에 참여한 미디어까지의 총합이 (최대 미디어 super point) * 101% 보다 작거나 같고 
				**(최대 미디어 super point) 보다 크거나 같으면 해당 미션은 여기서 마감 처리
				*/
				if($mission_data['mis_endtype'] == 1 || $mission_data['mis_endtype'] == 3){
					$this->RS_missionlist_model->update($mission_data['mis_id'], array('mis_end' => 1));
				}else{
					return 'mission already over';
				}
			}

			//로그 쌓기용 result 추가  
			$result[] = array(
				'jul_jug_id' 	=> 1,
				'jul_jud_id' 	=> $jud_id,
				'jul_med_id' 	=> $med_data['med_id'],
				'jul_state'	 	=> 1,
				'jul_mem_id' 	=> $mem_id,
				'jul_user_id'	=> $mem_data['mem_userid'],
				'jul_datetime'	=> $_now,
				'jul_ip'		=> $_ip,
				'jul_useragent'	=> $this->agent->agent_string(),
				'jul_data'		=> json_encode($merge_data)
			);
			break;

			case 1 :
			if(element('jud_attach', $jud)){
				$updateArr = array(
				'jud_attach'  =>  element('jud_attach', $jud)
				);
				if(!$this->update($med_data['jud_id'], $updateArr)){
					return 'jud_attach update error occur';
				}
				$result[] = array(
					'jul_jug_id' 	=> 1,
					'jul_jud_id' 	=> $med_data['jud_id'],
					'jul_med_id' 	=> $med_data['med_id'],
					'jul_state'	 	=> 1,
					'jul_mem_id' 	=> $mem_id,
					'jul_user_id'	=> $mem_data['mem_userid'],
					'jul_datetime'	=> $_now,
					'jul_ip'		=> $_ip,
					'jul_useragent'	=> $this->agent->agent_string(),
					'jul_data'		=> json_encode($updateArr)
				);
			}
			break;

			default :
				return 'judge_state error '.element('jud_state',$med_data);
		}
	}
	if($result){
		if(!$this->db->insert_batch('rs_judge_log',$result)){ return 'log data insert error'.$this->db->last_query(); }
	}

	$this->db->trans_complete();
	return true;
  }
}
