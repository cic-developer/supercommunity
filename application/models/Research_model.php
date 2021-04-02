<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Scrap model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Research_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'research';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'res_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

	public function getList($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR'){

		$result = $this->_get_list_common(false, array('table' => 'member', 'on' => 'research.mem_id = member.mem_id'), $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}
}
