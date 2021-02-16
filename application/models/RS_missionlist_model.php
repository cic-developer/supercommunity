<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Missionlist model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_missionlist_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_missionlist';

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
	public function get_missionlist_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
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
      'CASE WHEN rs_missionlist.mis_max_point = 0 OR (rs_missionlist.mis_endtype != 1 AND rs_missionlist.mis_endtype != 3) THEN 0 ELSE (rs_missionpoint.mip_tpoint/rs_missionlist.mis_max_point*100) END percentage',
      ' CASE WHEN rs_missionlist.mis_endtype = 1 THEN
          CASE WHEN rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.cdate('Y-m-d H:i:s').'") THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "'.cdate('Y-m-d H:i:s').'" THEN "planned" ELSE "process" END) END
        ELSE
          CASE WHEN rs_missionlist.mis_endtype = 2 THEN
            CASE WHEN rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.cdate('Y-m-d H:i:s').'") THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "'.cdate('Y-m-d H:i:s').'" THEN "planned" ELSE "process" END) END
          ELSE
            CASE WHEN rs_missionlist.mis_endtype = 3 THEN
            CASE WHEN rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "'.cdate('Y-m-d H:i:s').'" THEN "planned" ELSE "process" END) END
            ELSE
              CASE WHEN rs_missionlist.mis_endtype = 0 THEN
              CASE WHEN rs_missionlist.mis_end = 1 THEN "end" ELSE ( CASE WHEN rs_missionlist.mis_opendate > "'.cdate('Y-m-d H:i:s').'" THEN "planned" ELSE "process" END) END
              ELSE
                "unhandled_state"
              END
            END
          END
        END state',
        'rs_whitelist.wht_attach'
    );
    // join 방법
    $join[] = array('table' => 'rs_missionpoint', 'on' => 'rs_missionlist.mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner');
    $join[] = array('table' => 'rs_whitelist', 'on' => 'rs_missionlist.mis_apply_wht_id = rs_whitelist.wht_id', 'type' => 'left outer');
    $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
  }

  public function get_one_mission($primary_value = ''/*, $select = '', $where = ''*/)
	{
    //get_one으로는 join이 안되서 어쩔 수 없이 위 함수를 활용
    $result = $this->get_missionlist_list(1,0,array($this->primary_key => $primary_value), '', $this->primary_key, 'desc', '', '');
    if(element('total_rows',$result) === 0){
      return array();
    } else {
      return element(0,element('list',$result));
    }
  }
  

  public function get_clientMissionlist($limit = 10, $offset = 0, $state = false, $search = false){
      $this->db->select('rs_pershoutinglist.*, rs_whitelist.wht_attach');
      if($state){
        $this->db->where('state', $state);
      }
      if($search){
        $this->db->group_start();
        $this->db->like('ko_title', $search);
        $this->db->or_like('ko_content', $search);
        $this->db->or_like('en_content', $search);
        $this->db->or_like('en_title', $search);
        $this->db->group_end();
      }
      $this->db->join('rs_whitelist', 'rs_pershoutinglist.mis_wht_id = rs_whitelist.wht_id', 'LEFT OUTER');
      // $this->db->from($subquery);
      $this->db->limit($limit, $offset);
      $result['list'] = $this->db->get('rs_pershoutinglist')->result_array();

      // print_r($result['list']); 
      // exit;

      $this->db->select('count(*) as rownum');
      if($state){
        $this->db->where('state', $state);
      }
      if($search){
        $this->db->group_start();
        $this->db->like('ko_title', $search);
        $this->db->or_like('ko_content', $search);
        $this->db->or_like('en_content', $search);
        $this->db->or_like('en_title', $search);
        $this->db->group_end();
      }
      // $this->db->from($subquery);
      $result['total_rows'] = $this->db->get('rs_pershoutinglist')->row_array()['rownum'];

      return $result;
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
    'mis_thumb_image_del' => 0,
    'mis_endtype'         => 0,
    'mis_opendate'        => '0000-00-00 00:00:00',
    'mis_enddate'         => '0000-00-00 00:00:00',
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

	public function check_endtype_sp($value){
    $endtype = element('mis_endtype',$this->post_thumb_data);
		if(($endtype == 1 || $endtype == 3) && (int)$value<1){
      $this->form_validation->set_message('check_endtype_sp', '선택하신 마감유형은 최대 슈퍼포인트를 필수적으로 입력하셔야합니다.');
			return false;
    }
		return true;
  }

	public function check_endtype_enddate($value){
    $endtype  = element('mis_endtype',$this->post_thumb_data);
    $opendate = element('mis_opendate',$this->post_thumb_data);
    $enddate  = element('mis_enddate',$this->post_thumb_data);

		if(($endtype == 1 || $endtype == 2) && !$value){
      $this->form_validation->set_message('check_endtype_enddate', '선택하신 마감유형은 마감일 필수적으로 입력하셔야합니다.');
      return false;
			if(strtotime($opendate) > strtotime($enddate)){
        $this->form_validation->set_message('check_endtype_enddate', '마감일은 오픈날짜보다 이후여야 합니다.');
        return false;
			}
    }
		return true;
  }

  
	public function check_datetime($value){
    $is_datetime = strtotime($value); // https://www.php.net/manual/en/function.strtotime.php
		if($value && (!$is_datetime || $is_datetime == -1)){
      $this->form_validation->set_message('check_datetime', '비정상적인 날짜 정보가 입력되었습니다.');
			return false;
    }
		return true;
  }




  public function get_mission_apply_total_superpoint($mis_id){
    $this->db->join('rs_media','jud_med_id = med_id');
    $this->db->where(array(
      'jud_deletion' => 'N',
      'jud_jug_id'  => 1,
      'jud_mis_id'  => $mis_id,
    ));
    $this->db->select('SUM(med_superpoint) AS sum_superpoint');
    $sum_superpoint = $this->db->get('rs_judge')->row()->sum_superpoint;
    return $sum_superpoint ? $sum_superpoint : 0 ;
  }

  private function get_distribute_list(){
    $where = array();
    $where['mis_deletion'] = "N";
    $where['mis_distribute'] = "N";
    $where[' 
    CASE WHEN rs_missionlist.mis_endtype = 1 THEN
      (rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'"))
    ELSE
      CASE WHEN rs_missionlist.mis_endtype = 2 THEN
        (rs_missionlist.mis_end = 1 OR ( rs_missionlist.mis_enddate != "0000-00-00 00:00:00" AND rs_missionlist.mis_enddate <= "'.date('Y-m-d H:i:s').'"))
      ELSE
        CASE WHEN rs_missionlist.mis_endtype = 3 THEN
          (rs_missionlist.mis_max_point <= rs_missionpoint.mip_tpoint OR rs_missionlist.mis_end = 1)
        ELSE
          (rs_missionlist.mis_end = 1)
        END
      END
    END
  '] = null;
  $join = array('table' => 'rs_missionpoint', 'on' => 'rs_missionlist.mis_id = rs_missionpoint.mip_mis_id', 'type' => 'inner');
  return $this->_get_list_common('mis_id,mis_title,mis_per_token,mis_sf_percentage,mip_tpoint',$join,'','',$where);
  }

  public function distribute_point(){
    #crontab
    $data = $this->get_distribute_list();
    $total_row = element('total_rows',$data);
    if(!$total_row || $total_row<1){
      /*
      ** 분배처리할 미션이 없음.
      */
      return true;
    }
    $list = element('list',$data);
    $this->load->model('RS_judge_model');
    foreach($list as $l){
      $mis_id            = element('mis_id',$l);
      $mis_title         = element('mis_title',$l);
      $mis_per_token     = element('mis_per_token',$l);
      $mis_sf_percentage = element('mis_sf_percentage',$l);
      $mip_tpoint        = element('mip_tpoint',$l) ? element('mip_tpoint',$l) : 1; //분모 0 방지
      $where = array();
      $where['jud_mis_id'] = $mis_id;
      $where['jud_state'] = 3;
      $where['jud_deletion'] = "N";
      $join = array(
        array('table' => 'rs_whitelist', 'on' => 'rs_judge.jud_med_wht_id = rs_whitelist.wht_id', 'type' => 'inner'),
        array('table' => 'member_group_member', 'on' => 'rs_judge.jud_mem_id = member_group_member.mem_id AND member_group_member.mgr_id = 2', 'type' => 'left'),
      );
      $userlist = $this->RS_judge_model->get('','jud_id,jud_mem_id,jud_med_name,jud_superpoint,wht_title,mgm_id',$where,'','','','',$join);
      foreach($userlist as $u){
        /*
        ** 해당유저 superfriend 일 경우 추가 포인트 지급
        */
        $sf_percentage = 100;
        if(element('mgm_id',$u)) $sf_percentage += $mis_sf_percentage;
        $sf_percentage = $sf_percentage / 100;
        $point = floor(element('jud_superpoint',$u)*$mis_per_token*$sf_percentage/$mip_tpoint*10)/10; //소수점 1의자리수 밑으로 버림하기위해, 곱하기 10 해서 버림 후 나누기10
        $this->point->insert_point(
          element('jud_mem_id',$u),
          $point,
					'"' . $mis_title . '" 미션 "' . element('wht_title',$u) . '( '.element('jud_med_name',$u) . '|' . element('jud_med_id',$u) . ' )' . '" 미디어에 해당하는 PERPOINT 지급'. element('mgm_id',$u) ? '(슈퍼프랜드 추가지급포함)' : '',
					'distribute',
					element('jud_id',$u),
					'미션수행 포인트 지급'
        );
        $updatepoint = array(
          'jud_point' => $point
        );
        $this->RS_judge_model->update(element('jud_id',$u),$updatepoint);
      }
    }
  }
}
