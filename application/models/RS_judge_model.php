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
    $this->load->model('RS_whitelist_model');
    $value = $this->RS_whitelist_model->get_one($wht_id,'wht_id',array('wht_deletion'=>'N'));
    if(!element('wht_id',$value)){
      $this->form_validation->set_message('check_wht_id_is','존재하지 않는 미디어플랫폼 입니다.');
      return false;
    } else {
      return true;
    }
  }

  function check_wht_id_url($check_url){
    $value = $this->check_url_right($this->set_wht_id, $check_url);
    if(!$value){
      $this->form_validation->set_message('check_wht_id_url','유효하지 않은 URL 입니다.');
      return false;
    } else {
      return true;
    }
  }

  function check_met_id_is($met_id_array){
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
      $this->form_validation->set_message('check_met_id_is','비정상적인 시도입니다.');
      return false;
    }
    if($flag){
      return true;
    } else {
      $this->form_validation->set_message('check_met_id_is','최소 1개 이상의 미디어 성격을 지정하셔야합니다.');
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
}
