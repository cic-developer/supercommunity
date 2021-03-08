<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Extra Vars model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Member_extra_vars_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'member_extra_vars';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $parent_key = 'mem_id';

	public $meta_key = 'mev_key';

	public $meta_value = 'mev_value';

	public $cache_prefix= 'member_extra_vars/member-extra-vars-model-get-'; // 캐시 사용시 프리픽스

	public $cache_time = 86400; // 캐시 저장시간

	function __construct()
	{
		parent::__construct();

		check_cache_dir('member_extra_vars');
	}


	public function get_all_meta($mem_id = 0)
	{
		if (empty($mem_id)) {
			return false;
		}

		$cachename = $this->cache_prefix . $mem_id;
		$data = array();
		if ( ! $data = $this->cache->get($cachename)) {
			$result = array();
			$res = $this->get($primary_value = '', $select = '', array($this->parent_key => $mem_id));
			if ($res && is_array($res)) {
				foreach ($res as $val) {
					$result[$val[$this->meta_key]] = $val[$this->meta_value];
				}
			}
			$data['result'] = $result;
			$data['cached'] = '1';
			$this->cache->save($cachename, $data, $this->cache_time);
		}
		return isset($data['result']) ? $data['result'] : false;
	}


	public function save($mem_id = 0, $savedata = '')
	{
		if (empty($mem_id)) {
			return false;
		}
		if ($savedata && is_array($savedata)) {
			foreach ($savedata as $column => $value) {
				$this->meta_update($mem_id, $column, $value);
			}
		}
		$this->cache->delete($this->cache_prefix . $mem_id);
	}


	public function deletemeta($mem_id = 0)
	{
		if (empty($mem_id)) {
			return false;
		}
		$this->delete_where(array($this->parent_key => $mem_id));
		$this->cache->delete($this->cache_prefix . $mem_id);
	}


	public function meta_update($mem_id = 0, $column = '', $value = false)
	{
		if (empty($mem_id)) {
			return false;
		}
		$column = trim($column);
		if (empty($column)) {
			return false;
		}

		$old_value = $this->item($mem_id, $column);
		if (empty($value)) {
			$value = '';
		}
		if ($value === $old_value) {
			return false;
		}

		if (is_array($value)) {
			$value = json_encode($value);
		}
		if (false === $old_value) {
			return $this->add_meta($mem_id, $column, $value);
		}

		return $this->update_meta($mem_id, $column, $value);
	}


	public function item($mem_id = 0, $column = '')
	{
		if (empty($mem_id)) {
			return false;
		}
		if (empty($column)) {
			return false;
		}

		$result = $this->get_all_meta($mem_id);

		return isset($result[ $column ]) ? $result[ $column ] : false;
	}


	public function add_meta($mem_id = 0, $column = '', $value = '')
	{
		if (empty($mem_id)) {
			return false;
		}
		$column = trim($column);
		if (empty($column)) {
			return false;
		}

		$updatedata = array(
			'mem_id' => $mem_id,
			'mev_key' => $column,
			'mev_value' => $value,
		);
		$this->db->replace($this->_table, $updatedata);
		//meta data가 경고인 경우 자동 경감을 추가해준다.
		if(strcmp($column,'mem_warn_1') == 0 || strcmp($column,'mem_warn_2') == 0 ){
			$this->load->model('RS_main_config_model');
			$_date = $this->RS_main_config_model->get_one('','',array('mcf_main' => 'Y'))['mcf_warningdate'];
			// print_r($_date); exit;
			$delete_date = date("Y-m-d H:i:s", strtotime("+".$_date." days"));
			if($_date){
				$insert_data = array(
					'mdw_mem_id' => $mem_id,
					'mdw_type'	=> $column,
					'mdw_value' => $value,
					'mdw_wdate'	=> date('Y-m-d H:i:s'),
					'mdw_ddate' => $delete_date
				);
				$this->db->set($insert_data);
				$this->db->insert('member_delete_warn');
			}
		}
		//---------------------------------------------------
		return true;
	}


	public function deletemeta_item($column = '')
	{
		if (empty($column)) {
			return false;
		}
		$this->delete_where(array($this->meta_key => $column));
	}


	public function update_meta($mem_id = 0, $column = '', $value = '')
	{
		if (empty($mem_id)) {
			return false;
		}
		$column = trim($column);
		if (empty($column)) {
			return false;
		}

		$this->db->where($this->parent_key, $mem_id);
		$this->db->where($this->meta_key, $column);
		$data = array($this->meta_value => $value);
		$this->db->update($this->_table, $data);
		//meta data가 경고인 경우 자동 경감을 추가해준다.
		if(strcmp($column,'mem_warn_1') == 0 || strcmp($column,'mem_warn_2') == 0 ){
			$this->load->model('RS_main_config_model');
			$_date = $this->RS_main_config_model->get_one('','',array('mcf_main' => 'Y'))['mcf_warningdate'];
			// print_r($_date); exit;
			$delete_date = date("Y-m-d H:i:s", strtotime("+".$_date." days"));
			if($_date){
				$insert_data = array(
					'mdw_mem_id' => $mem_id,
					'mdw_type'	=> $column,
					'mdw_value' => $value,
					'mdw_wdate'	=> date('Y-m-d H:i:s'),
					'mdw_ddate' => $delete_date
				);
				$this->db->set($insert_data);
				$this->db->insert('member_delete_warn');
			}
		}
		//---------------------------------------------------
		return true;
	}
}
