<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Medialist model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_medialist_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_medialist';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mis_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

  /*
  ** 미션 목록 불러오는 function
  */
	public function get_medialist_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
    if($where && is_array($where)){
      if(!isset($where['mis_deletion'])) $where['mis_deletion'] = 'N';
    } else {
      $where = array(
        'mis_deletion' => 'N'
      );
    }
    $select = array(
      'rs_missionlist.*',
      'rs_missionpoint.mip_tpoint as tpoint',
      'CASE WHEN rs_missionlist.mis_max_point = 0 THEN 0 ELSE (rs_missionpoint.mip_tpoint/rs_missionlist.mis_max_point*100) END percentage',
      'CASE WHEN rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'") THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "'.cdate('Y-m-d H:i:s').'" THEN "planned" ELSE "process" END) END state'
    );
    // join 방법
    $join[] = array('table' => 'rs_missionpoint', 'on' => 'rs_missionlist.mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner');
    $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
  }
  public function get_one_mission($primary_value = '', $select = '', $where = '')
	{
    //get_one으로는 join이 안되서 어쩔 수 없이 위 함수를 활용
    $result = $this->get_missionlist_list(1,0,array($this->primary_key => $primary_value), '', $this->primary_key, 'desc', '', '');
    if(element('total_rows',$result) === 0){
      return array();
    } else {
      return element(0,element('list',$result));
    }
  }
  /*
  ** post 로 전송된 도메인 목록에 http, https 가 입력되어있는지
  ** 한글이 입력되지는 않았는지 확인하는 function
  */
  public function check_is_youtubeurl_right($domain){
    $domain = strtolower($domain);
    if($domain && strpos($domain,'youtube.com') == false){
      $this->form_validation->set_message('is_youtubeurl_right', '유튜브 영상 주소만 입력하실 수 있습니다.');
      return false;
    }
    return true;
  }
  
  /*
  ** mis_thumb_type 값이 1 인데 image 가 없을경우 2인데 유튜브링크가 없을 경우 차단
  ** 한글이 입력되지는 않았는지 확인하는 function
  */
  public $post_thumb_data = array(
    'mid'                 => 0,
    'get_mis_thumb_image' => '',
    'thumb_image'         => array(),
    'thumb_youtube'       => '',
    'mis_thumb_image_del' => 0
  );
	public function check_thumb_data($value){
    $data = $this->post_thumb_data;
		if($value == 1 && !element('name',element('thumb_image',$data))){
      if(!element('mid',$data) || (element('mid',$data) && !element('get_mis_thumb_image',$data))){
        $this->form_validation->set_message('check_image_type', '이미지를 선택하셨으면 이미지를 선택하셔야 합니다.');
        return false;
      }
      if(element('mis_thumb_image_del',$data)){
        $this->form_validation->set_message('check_image_type', '이미지를 선택하신 선택 후 삭제하실 수 있습니다.');
        return false;
      }
		} else if($value == 2 && !element('thumb_youtube',$data)){
      $this->form_validation->set_message('check_image_type', '유튜브를 선택하셨으면 유튜브 주소를 입력하셔야합니다.');
			return false;
    }
		return true;
	}

  /*
  ** 해당 미션이 마감되었는지 확인하는 Function
  */
  public function get_is_this_mission_end($mis_id){
    $getdata = $this->get_one($mis_id);
    if(!$getdata) return false;
    if(element('mis_end',$getdata)/* || element('mis_max_point',$getdata) < 해당 미션 승인 포인트 */){
      return 'mission end'; //미션 종료
    } else if (strtotime(element('mis_opendate',$getdata)) > time()){
      return 'planned mission'; //미션 예정
    } else {
      return 'mission proceeding'; //미션 진행중
    }
  }
}
