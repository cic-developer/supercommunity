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

		if ($CI->uri->segment(1) === 'install') {
			return;
		}

		if (config_item('use_lock_ip') && $CI->cbconfig->item('site_ip_whitelist')) {
			$whitelist = $CI->cbconfig->item('site_ip_whitelist');
			$whitelist = preg_replace("/[\r|\n|\r\n]+/", ',', $whitelist);
			$whitelist = preg_replace("/\s+/", '', $whitelist);
			if (preg_match('/(<\?|<\?php|\?>)/xsm', $whitelist)) {
				$whitelist = '';
			}
			if ($whitelist) {
				$whitelist = explode(',', trim($whitelist, ','));
				$whitelist = array_unique($whitelist);
				if (is_array($whitelist)) {
					$CI->load->library('Ipfilter');
					$ipfilter = new Ipfilter();
					if ( ! $ipfilter->filter($whitelist)) {
						$title = ($CI->cbconfig->item('site_blacklist_title'))
							? $CI->cbconfig->item('site_blacklist_title')
							: 'Maintenance in progress...';
						$message = $CI->cbconfig->item('site_blacklist_content');

						show_error($message, '500', $title);

						exit;
					}
				}
			}
		}
		if (config_item('use_lock_ip') && $CI->cbconfig->item('site_ip_blacklist')) {
			$blacklist = $CI->cbconfig->item('site_ip_blacklist');
			$blacklist = preg_replace("/[\r|\n|\r\n]+/", ',', $blacklist);
			$blacklist = preg_replace("/\s+/", '', $blacklist);
			if (preg_match('/(<\?|<\?php|\?>)/xsm', $blacklist)) {
				$blacklist = '';
			}
			if ($blacklist) {
				$blacklist = explode(',', trim($blacklist, ','));
				$blacklist = array_unique($blacklist);
				if (is_array($blacklist)) {
					$CI->load->library('Ipfilter');
					$ipfilter = new Ipfilter();
					if ($ipfilter->filter($blacklist)) {
						$title = ($CI->cbconfig->item('site_blacklist_title'))
							? $CI->cbconfig->item('site_blacklist_title')
							: 'Maintenance in progress...';
						$message = $CI->cbconfig->item('site_blacklist_content');
						show_error($message, '500', $title);
						exit;
					}
				}
			}
		}

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

        if($CI->session->flashdata('popup_on') && $CI->input->ip_address() == '49.163.50.132' && $device_view_type == 'desktop'){
            echo "<script>window.open('".base_url('/Popup/notiPopup/1')."','CIC Popup', '"."location = no"."')</script>";
        }
	}
}
