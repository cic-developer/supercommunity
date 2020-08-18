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
        $return = '승인요청';
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

