<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Autologin model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Autologin_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'autologin';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'aul_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}
}
