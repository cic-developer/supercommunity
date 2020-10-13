<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *--------------------------------------------------------------------------
 *Admin Page 에 보일 메뉴를 정의합니다.
 *--------------------------------------------------------------------------
 *
 * Admin Page 에 새로운 메뉴 추가시 이곳에서 수정해주시면 됩니다.
 *
 */


$config['admin_page_menu']['cic'] =
	array(
		'__config'						=> array('CIC 관리', 'fa-university'),
		'menu'								=> array(
			'missionlist'				=> array('미션등록', ''),
			'judgemission'			=> array('미션심사', ''),
			'medialist'					=> array('미디어목록', ''),
			'judgemedia'				=> array('미디어심사', ''),
			'judgewithdraw'			=> array('출금심사', ''),
			'advertisementlist'	=> array('광고', ''),
			'Inquiry'			=> array('문의사항',''),
			'setting'			=> array('CIC 설정', ''),
			'auth'				=> array('지갑등록', '')
		),
	);
