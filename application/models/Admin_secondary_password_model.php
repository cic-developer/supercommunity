<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Autologin model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Admin_secondary_password_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'admin_secondary_password';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'asp_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

    function checkPassword($_name, $_password){
        $this->db->where('asp_name', $_name);
        $this->db->where('asp_password',$_password);

        $result = $this->db->get($this->_table)->result();
        if($result) return $result[0]->asp_id;

        return 0;
    }
}
