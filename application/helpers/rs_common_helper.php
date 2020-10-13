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

if( ! function_exists('rs_cal_expected_point')){
  function rs_cal_expected_point($mis_per_token, $med_superpoint, $total_super = 0){
    // echo "mis_per_token : ". $mis_per_token;
    // echo "med_superpoint : ".$med_superpoint;
    // echo "total_super : ".$total_super;
    // exit;
    $max_total = $mis_per_token*($med_superpoint/($total_super + $med_superpoint));
    if($max_total > $med_superpoint){
      return $med_superpoint;
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

