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

  function registMedia($insertData){
    // 기본적인 등록 정보 시작 
    if(!element('mem_id', $insertData)){ return false; } //mem_id 즉 유저 id가 없는 경우
    $is_url_right = $this->check_url_right(element('med_wht_id',$insertData),element('med_url', $insertData));
    if(!$is_url_right){ return 'not_matched_white_list'; } 

    $now = date('Y-m-d H:i:s');
    if($insertData['med_id']){
      $other_judge = $this->check_other_judge($insertData['med_id']);
      if($other_judge){return $other_judge;}
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

  //mem_id 기준 승인된 미디어의 모든 super point의 총합을 구함, 없으면 모든 미디어의 총 super point
  function get_total_super($mem_id = 0){
    $this->db->select('SUM(med_superpoint) AS total_superpoint');
    if($mem_id){$this->db->where('mem_id', $mem_id);}
    $this->db->where(array('med_deletion' => 'N', 'med_state' => 3));
    return $this->db->get('rs_media')->row_array()['total_superpoint'];
  }


  //미션에 신청한 미디어들 전부 가져옴
  function getMissionMedia($mis_id, $mem_id){
    $_join = array(
      'table' => 'rs_judge juge',
      'on'    => 'jud_mis_id = '.$mis_id.' AND jud_jug_id = 1 AND jud_state != 0 AND jud_med_id = med_id',
      'type'  => 'LEFT OUTER'
    );
    $where = array(
      'mem_id' => $mem_id,
      'med_state' => 3
    );
    
    return $this->get('','', $where, '', 0,'jud_state', 'ASC', $_join);
  }

  function check_media_duplication($med_id, $med_url){
    // if(($_http_pos = strpos($med_url,'//')) !== false){
    //   $med_url = substr($med_url, $_http_pos + 2);
    // }
    if($med_id){
      $this->db->where('med_id != ', $med_id);
    }
    $this->db->where('med_state >', 0);
    $this->db->where('med_deletion','N');
    $this->db->where('med_url', $med_url);
    return $this->db->get('rs_media')->result();
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

  function callback_url_check($url){

    $wht_id = $this->set_wht_id;
    if($this->check_url_right($wht_id, $url)){
      return true;
    } else {
      $this->form_validation->set_message('callback_url_check',$this->lang->line('controller_8'));
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

  function check_other_judge($med_id){
    $this->lang->load('cic_media_model', $this->session->userdata('lang'));
    $where = array(
      'jud_deletion' => 'N',
      'jud_state'    => 1,
      'jud_mem_id'   => $this->session->userdata('mem_id'),
      'jud_med_id'   => $med_id
    );
    $this->db->order_by('jud_wdate','DESC');
    $this->db->limit(1);
    $this->db->where($where);
    $jud_data = $this->db->get('rs_judge')->row_array();
    
    switch($jud_data['jud_jug_id']){
      case 1 :
        return $this->lang->line('model_1');
      break;
      case 2 :
        return $this->lang->line('model_2');
      break;
      case 3 :
        return $this->lang->line('model_3');
      break;
      case 4 :
        return $this->lang->line('model_4');
      break;
      default :
        $where = array(
          'jud_deletion' => 'N',
          'jud_state'    => 3,
          'jud_jug_id'   => 1,
          'jud_mem_id'   => $this->session->userdata('mem_id'),
          'jud_med_id'   => $med_id
        );
        $this->db->order_by('jud_wdate','DESC');
        $this->db->limit(1);
        $this->db->where($where);
        $jud_data2 = $this->db->get('rs_judge')->row_array();
        if($jud_data2){
          return $this->lang->line('model_1');
        }
        if(!$jud_data){  return false; }
        return true;
    }

  }


}
