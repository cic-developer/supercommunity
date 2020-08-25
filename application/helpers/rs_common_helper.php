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
  function rs_cal_expected_point($mis_per_token, $med_superpoint, $total_super){
    return $mis_per_token*($med_superpoint/($total_super + $med_superpoint));
  }
}

