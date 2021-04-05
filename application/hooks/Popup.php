<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Common hook class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */
 
class _Popup
{

	function init()
	{
		$CI =& get_instance();

		$CI->load->library('Mobile_detect');
		$detect = new Mobile_detect();

		$device_view_type = (get_cookie('device_view_type') === 'desktop' OR get_cookie('device_view_type') === 'mobile')
				? get_cookie('device_view_type') : '';
		if (empty($device_view_type)) {
			$device_view_type = $detect->isMobile() ? 'mobile' : 'desktop';
		}
		$CI->cbconfig->set_device_view_type($device_view_type);

		$device_type = $detect->isMobile() ? 'mobile' : 'desktop';
		$CI->cbconfig->set_device_type($device_type);

        if($CI->session->userdata('popup_on') && $device_view_type == 'desktop'){
            echo "<script>window.open('".base_url('/Popup/notiPopup/1')."','CIC Popup', '"."width=300, height=358,location = no"."')</script>";
        }
	}
}
