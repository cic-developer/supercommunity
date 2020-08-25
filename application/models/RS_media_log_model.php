<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Media Log model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_media_log_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_media_log';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mel_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

}
