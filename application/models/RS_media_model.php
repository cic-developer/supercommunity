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
  ** 미디어 목록->detail 페이지에서 수정시 사용
  */
  public $set_wht_id = null;
  public $set_met_id = array();

  /*
  ** Member 별 media List 가져오는 함수, mem_id가 없으면 전체 미디어
  ** option의 경우 state(상태), wdate_start와 wdate_end(작성일 범위), mdate_start와 mdate_end(변경일 범위)
  ** med_id(미디어 id), limit_count와 limit_index(로우 범위 지정), med_wht_id(whiteList id), med_name과 med_url 은 like로 검색 \
  ** 결과값은 return array(mem_data => '멤버 데이터', med_list => '미디어 리스트' )
  */
  // public function get_media($mem_id = NULL, $option = array()){
  //   if($mem_id){
  //     $this->db->where('mem_id',$mem_id);
  //   }else{
  //     $mem_data = NULL;
  //   }
  //   if($option){
  //     if(($state = element('state',$option))){
  //       $this->db->where('med_state',$state);
  //     }
  //     if(($wdate_start = element('wdate_start',$option))){
  //       $this->db->where('med_wdate >=',$wdate_start." 00:00:00");
  //     }
  //     if(($wdate_end = element('wdate_end',$option))){
  //       $this->db->where('med_wdate <=',$wdate_end." 23:59:59");
  //     }
  //     if(($mdate_start = element('mdate_start',$option))){
  //       $this->db->where('med_mdate >=',$mdate_start." 00:00:00");
  //     }
  //     if(($mdate_end = element('mdate_end',$option))){
  //       $this->db->where('med_mdate <=',$mdate_end." 23:59:59");
  //     }
  //     if(($med_id = element('med_id',$option))){
  //       $this->db->where('med_id',$med_id);
  //     }
  //     if(($limit_count = element('limit_count',$option)) && ($limit_index = element('limit_index',$option))){
  //       $this->db->limit($limit_count, $limit_index);
  //     }else if(($limit_count = element('limit_count',$option))){
  //       $this->db->limit($limit_count);
  //     }
  //     if(($med_name = element('med_name',$option))){
  //       $this->db->like('med_name',$med_name);
  //     }
  //     if(($med_url = element('med_url',$option))){
  //       $this->db->like('med_url',$med_url);
  //     }
  //   }

  //   $med_list = $this->db->get('rs_media')->result();
  //   return $med_list;
  // }

  function registMedia($insertData){
    // 기본적인 등록 정보 시작 
    if(!element('mem_id', $insertData)){ return false; } //mem_id 즉 유저 id가 없는 경우
    $is_url_right = $this->check_url_right(element('med_wht_id',$insertData),element('med_url', $insertData));
    if(!$is_url_right){ return 'not_matched_white_list'; } 

    $now = date('Y-m-d H:i:s');
    if($insertData['med_id']){
      $insertData['med_mdate'] = $now;
      if($this->update($insertData['med_id'], $insertData)){
        $med_id = $insertData['med_id'];
      }
    }else{
      $insertData['med_wdate'] = $now;
      $med_id = $this->insert($insertData);
    }

    if($med_id){
      $is_duplication =  $this->check_media_duplication($med_id, element('med_url', $insertData));  //중복확인된 리스트를 가지고 중복이 있을경우 db에 등록
      if($is_duplication){
        $sql = "REPLACE INTO rs_media_duplication (med_id, dup_id, med_url) VALUES ";
        $count = 1;
        foreach($is_duplication AS $dup){
          $sql .= "('".$med_id."', '".$dup->med_id."', '".$insertData['med_url']."' )";
          if(count($is_duplication) > $count++){
            $sql .= " , ";  
          }
        }
        $this->db->query($sql);
      }
      return $med_id;
    }
  }

  function getMissionMedia($mis_id, $mem_id){
    $this->db->join('rs_judge juge', 'jud_mis_id = '.$mis_id.' AND jud_jug_id = 1 AND jud_state != 0 AND jud_med_id = med_id', 'LEFT OUTER');
    return $this->get('','',array('mem_id' => $mem_id, 'med_state' => 3));
  }

  function check_media_duplication($med_id, $med_url){
    if(($_http_pos = strpos($med_url,'//')) !== false){
      $med_url = substr($med_url, $_http_pos + 2);
    }
    if($med_id){
      $this->db->where('med_id != ', $med_id);
    }
    $this->db->where('med_state >', 0);
    $this->db->where('med_deletion','N');
    $this->db->like('med_url', $med_url);
    return $this->db->get('rs_media')->result();
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
