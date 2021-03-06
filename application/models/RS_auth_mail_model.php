<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class RS_auth_mail_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_auth_mail';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'atm_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}
}
