<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Whitelist model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_media_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_media';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'med_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

  /*
  ** Member 별 media List 가져오는 함수, mem_id가 없으면 전체 미디어
  ** option의 경우 state(상태), wdate_start와 wdate_end(작성일 범위), mdate_start와 mdate_end(변경일 범위)
  ** med_id(미디어 id), limit_count와 limit_index(로우 범위 지정), med_wht_id(whiteList id), med_name과 med_url 은 like로 검색 \
  ** 결과값은 return array(mem_data => '멤버 데이터', med_list => '미디어 리스트' )
  */
  public function get_media($mem_id = NULL, $option = array()){
    if($mem_id){
      $this->db->where('mem_id',$mem_id);
      $mem_data = $this->db->get('member')->row();
      $this->db->where('mem_id',$mem_id);
    }else{
      $mem_data = NULL;
    }
    if($option){
      if(($state = element('state',$option))){
        $this->db->where('med_state',$state);
      }
      if(($wdate_start = element('wdate_start',$option))){
        $this->db->where('med_wdate >=',$wdate_start." 00:00:00");
      }
      if(($wdate_end = element('wdate_end',$option))){
        $this->db->where('med_wdate <=',$wdate_end." 23:59:59");
      }
      if(($mdate_start = element('mdate_start',$option))){
        $this->db->where('med_mdate >=',$mdate_start." 00:00:00");
      }
      if(($mdate_end = element('mdate_end',$option))){
        $this->db->where('med_mdate <=',$mdate_end." 23:59:59");
      }
      if(($med_id = element('med_id',$option))){
        $this->db->where('med_id',$med_id);
      }
      if(($limit_count = element('limit_count',$option)) && ($limit_index = element('limit_index',$option))){
        $this->db->limit($limit_count, $limit_index);
      }else if(($limit_count = element('limit_count',$option))){
        $this->db->limit($limit_count);
      }
      if(($med_name = element('med_name',$option))){
        $this->db->like('med_name',$med_name);
      }
      if(($med_url = element('med_url',$option))){
        $this->db->like('med_url',$med_url);
      }
    }

    $med_list = $this->db->get('rs_media')->result();
    return array('mem_data' => $mem_data, 'med_list' => $med_list);
  }

  function registMedia($insertData){
    // 기본적인 등록 정보 시작 
    if(!element('mem_id', $insertData)){ return false; } //mem_id 즉 유저 id가 없는 경우
    $this->load->model('RS_whitelist_model');
    print_r($this->RS_whitelist_model->get_whitelist_domain(array('wht_id' => $this->input->post('wht_list'))));
    exit;

    $now = date('Y-m-d H:i:s');
    $this->db->set('med_wht_id', element('med_wht_id',$insertData));
    $this->db->set('med_name', element('med_name',$insertData));
    $this->db->set('med_admin', element('med_admin',$insertData));
    $this->db->set('med_url', element('med_url', $insertData));
    $this->db->set('mem_id', element('mem_id', $insertData));
    $this->db->set('med_mdate', $now);
    // 기본적인 등록 정보 끝
    if(element('med_id', $insertData)){ //med_id가 있고 값이 0이 아닌 경우 수정
      if(element('med_state',$insertData)){ //상태값은 혹시라도 꼬이면 골치아프니 한번 더 확인
        $this->db->set('med_state', $insertData['med_state']);
      }
      //유저 id 와 미디어 id가 일치하는 경우에만
      $this->db->where('mem_id', $insertData['mem_id']); 
      $this->db->where('med_id', $insertData['med_id']);
      if($this->db->update('rs_media')){  //업데이트 후 결과값을 가지고 결과 출력
        $is_duplication =  $this->check_media_duplication($insertData['med_id'], element('med_url', $insertData)); //중복확인된 리스트를 가지고 중복이 있을경우 db에 등록
        $insertArr = array();
        foreach($is_duplication AS $dup){
          $insertArr[] = array(
            'med_id'  => $insertData['med_id'],
            'dup_id'  => $dup->med_id,
            'med_url' => $insertData['med_url']
          );
        }
        if($insertArr){
          $this->db->insert_batch('rs_media_duplication',$insertArr);
        }
        return $insertData['med_id'];
      }else{
        return false;
      }
    }else{
      //등록일과 수정일이 같아야함
      $this->db->set('med_wdate', $now);
      $this->db->set('med_mdate', $now);
      if($this->db->insert('rs_media')){ //rs_media에 insert
        $med_id = $this->db->insert_id(); //등록된 med_id와
        if($med_id){
          $is_duplication =  $this->check_media_duplication($med_id, element('med_url', $insertData));  //중복확인된 리스트를 가지고 중복이 있을경우 db에 등록
          $insertArr = array();
          foreach($is_duplication AS $dup){
            $insertArr[] = array(
              'med_id'  => $med_id,
              'dup_id'  => $dup->med_id,
              'med_url' => $insertData['med_url']
            );
          }
          if($insertArr){
            $this->db->insert_batch('rs_media_duplication',$insertArr);
          }
          return $med_id;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
  }

  function check_media_duplication($med_id, $med_url){
    if($med_id){
      $this->db->where('med_id != ', $med_id);
    }
    $this->db->where('med_url', $med_url);
    return $this->db->get('rs_media')->result();
  }
}
