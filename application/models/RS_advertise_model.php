<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Whitelist Log model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_advertise_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_advertise';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'ad_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	function get_random(){
		$result = $this->_get('','', "ad_deletion = 'N' AND ad_state = 1", 1, 0, 'ad_id', 'RANDOM');
		if($result){
			return $result->row_array();
		}else{
			return array();
		}
	}

}
