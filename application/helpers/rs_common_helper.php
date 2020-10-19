<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Common helper
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

/**
 * rs_get_state
 */
if ( ! function_exists('rs_get_state')) {
	function rs_get_state($var)
	{
    switch($var){
      case 0:
        $return = '반려';
      break;
      case 1:
        $return = '대기중';
      break;
      case 3:
        $return = '승인완료';
      break;
      case 5:
        $return = '지급완료';
      break;
      default: 
        $return = 'error';
    }
		return $return;
	}
}

if( ! function_exists('rs_cal_expected_point2')){
  function rs_cal_expected_point($mis_per_token, $med_superpoint, $total_super, $jud_data){
    switch($jud_data['jud_state']){
      case 0 :
        if(isset($jud_data['jud_state'])){
          $max_total = 0;
          // var_dump($jud_data['jud_state']);
          // exit;
        }else{
          $max_total = $mis_per_token * ($med_superpoint/($total_super + $med_superpoint));
          if($max_total > $med_superpoint){
            $max_total = $med_superpoint;
          }
        }
      break;
      case 1 :
      case 3 :
        if($total_super <= 0){ //아무도 신청 안한경우 무한대가 되니까
          $total_super = 1; //1로 변경
        }
        $max_total = $mis_per_token * ($med_superpoint / $total_super);
        if($max_total > $med_superpoint){
          $max_total = $med_superpoint;
        }
      break;
      case 5 :
        $max_total = $jud_data['jud_point']; //지급 완료인 경우
      break;
    }
    
    return $max_total;
  }
}

if( ! function_exists('rs_cal_expected_point2')){
  function rs_cal_expected_point2($mis_per_token, $mis_max_point, $med_superpoint, $jud_data){
    switch($jud_data['jud_state']){
      case 0 :
        if(isset($jud_data['jud_state'])){
          $max_total = 0;
        }else{
          $max_total = $med_superpoint*($mis_per_token/$mis_max_point);
        }
      break;
      case 1 :
      case 3 :
        $max_total = $med_superpoint*($mis_per_token/$mis_max_point);
      break;
      case 5 :
        $max_total = $jud_data['jud_point']; //지급 완료인 경우
      break;
    }
    
    return $max_total;
  }
}

if(! function_exists('rs_get_YT_id')){
  function rs_get_YT_id($YT_FULL_URL){
    //유튜브 링크 생성
    $_YTlink = str_replace('https://www.youtube.com/watch?v=', '', $YT_FULL_URL);
    $_localAnd = strpos($_YTlink, '&');
    if($_localAnd){
        $_YTlink = substr($_YTlink , 0 , $_localAnd);
    }

    return $_YTlink;
  }
}

