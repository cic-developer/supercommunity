<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Mediatype Map model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_mediatype_map_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_mediatype_map';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mtm_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	public function insert_batch($data){
		if(!is_array($data)){ return false; }
		return $this->db->insert_batch($this->_table, $data);
	}
}
