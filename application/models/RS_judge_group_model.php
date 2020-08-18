<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Judge Group model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_judge_group_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_judge_group';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'jug_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

}
