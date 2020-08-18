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

	function __construct()
	{
		parent::__construct();
	}

	public function get_judge_list($jug_id = 0, $limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR', $select = '', $join = ''){

    if($where && is_array($where)){
      if(!isset($where['jud_jug_id'])) $where['jud_jug_id'] = $jug_id;
      if(!isset($where['jud_deletion'])) $where['jud_deletion'] = 'N';
    } else {
      $where = array(
				'jud_jug_id'   => $jug_id,
				'jud_deletion' => 'N',
      );
		}

		if($join && is_array($join)){

			$inner_array_join = false;
			$already_inner_array_join_judge_group = false;
			$already_inner_array_join_whitelist = false;
			$already_inner_array_join_missionlist = false;
			$array_join = false;
			$already_array_join_judge_group = false;
			$already_array_join_whitelist = false;
			$already_array_join_missionlist = false;

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
						if($key == 'table' && $value == 'rs_missionlist'){
							$already_inner_array_join_missionlist = true;
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
					if($key == 'table' && $value == 'rs_missionlist'){
						$already_array_join_missionlist = true;
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
				if(!$already_inner_array_join_whitelist){
					$newArr = array();
					$newArr[] = array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner');
					foreach($join as $value){
						$newArr[] = $value;
					}
					$join = $newArr;
				}
				if(!$already_inner_array_join_missionlist){
					$newArr = array();
					$newArr[] = array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner');
					foreach($join as $value){
						$newArr[] = $value;
					}
					$join = $newArr;
				}
			}
			if ($array_join){
				$newArr = array();
				if(!$already_array_join_whitelist){
					$newArr[] = array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner');
				}
				if(!$already_array_join_judge_group){
					$newArr[]= 	array('table' => 'rs_judge_group', 'on' => 'rs_judge.jud_jug_id = rs_judge_group.jug_id', 'type' => 'inner');
				}
				if(!$already_array_join_missionlist){
					$newArr[]= 	array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner');
				}
				$newArr[] =	$join;
				$join = $newArr;
			}
		} else {
			$join = array(
				array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner'),
				array('table' => 'rs_judge_group', 'on' => 'rs_judge.jud_jug_id = rs_judge_group.jug_id', 'type' => 'inner'),
				array('table' => 'rs_missionlist', 'on' => 'rs_judge.jud_mis_id = rs_missionlist.mis_id', 'type' => 'inner')
			);
		}
    $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

  public function get_one_judge($primary_value = '', $select = '', $where = '')
	{
    //get_one으로는 join이 안되서 어쩔 수 없이 위 함수를 활용
    $result = $this->get_judge_list(1,1,0,array($this->primary_key => $primary_value), '', $this->primary_key, 'desc', '', '');
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
}
