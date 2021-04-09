<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Login Log model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Member_login_log_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'member_login_log';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mll_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$select = 'member_login_log.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon';
		$join[] = array('table' => 'member', 'on' => 'member_login_log.mem_id = member.mem_id', 'type' => 'left');
		$result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
	}

	public function get_bad_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
		$this->db->select('member_login_log.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon, member.mem_denied, overlap_table.overlap_count');
		$this->db->join("
		(
			SELECT mll_ip, COUNT(*) AS overlap_count
			FROM 
				(
					SELECT mll_ip
					FROM member_login_log
					GROUP BY 
						mem_id, mll_ip
				) AS mll_table
			GROUP BY
				mll_ip
		) AS overlap_table" , 'member_login_log.mll_ip = overlap_table.mll_ip', 'left');
		$this->db->join('member', 'member_login_log.mem_id = member.mem_id', 'left');
		$this->db->order_by('member_login_log.mll_ip');
		$this->db->where('overlap_table.overlap_count >', 1);
		$this->db->where('member.mem_denied < ', 1);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		
		if($where){
			$this->db->where($where);
		}
		
		if ($like) {
			$this->db->like($like);
		}

		$forder = (strtoupper($forder) === 'ASC') ? 'ASC' : 'DESC';
		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';

		// $count_by_where = array();
		$search_where = array();
		$search_like = array();
		$search_or_like = array();
		if ($sfield && is_array($sfield)) {
			foreach ($sfield as $skey => $sval) {
				$ssf = $sval;
				if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
					if (in_array($ssf, $this->search_field_equal)) {
						$search_where[$ssf] = $skeyword;
					} else {
						$swordarray = explode(' ', $skeyword);
						foreach ($swordarray as $str) {
							if (empty($ssf)) {
								continue;
							}
							if ($sop === 'AND') {
								$search_like[] = array($ssf => $str);
							} else {
								$search_or_like[] = array($ssf => $str);
							}
						}
					}
				}
			}
		} else {
			$ssf = $sfield;
			if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
				if (in_array($ssf, $this->search_field_equal)) {
					$search_where[$ssf] = $skeyword;
				} else {
					$swordarray = explode(' ', $skeyword);
					foreach ($swordarray as $str) {
						if (empty($ssf)) {
							continue;
						}
						if ($sop === 'AND') {
							$search_like[] = array($ssf => $str);
						} else {
							$search_or_like[] = array($ssf => $str);
						}
					}
				}
			}
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		$qry = $this->db->get('member_login_log');
		$result['list'] = $qry->result_array();

		$this->db->select('member_login_log.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon, member.mem_denied, overlap_table.overlap_count');
		$this->db->join("
		(
			SELECT mll_ip, COUNT(*) AS overlap_count
			FROM 
				(
					SELECT mll_ip
					FROM member_login_log
					GROUP BY 
						mem_id, mll_ip
				) AS mll_table
			GROUP BY
				mll_ip
		) AS overlap_table" , 'member_login_log.mll_ip = overlap_table.mll_ip', 'left');
		$this->db->join('member', 'member_login_log.mem_id = member.mem_id', 'left');
		$this->db->order_by('member_login_log.mll_ip');
		$this->db->where('overlap_table.overlap_count >', 1);
		$this->db->where('member.mem_denied < ', 1);
		
		if($where){
			$this->db->where($where);
		}
		
		if ($like) {
			$this->db->like($like);
		}

		$forder = (strtoupper($forder) === 'ASC') ? 'ASC' : 'DESC';
		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';

		// $count_by_where = array();
		$search_where = array();
		$search_like = array();
		$search_or_like = array();
		if ($sfield && is_array($sfield)) {
			foreach ($sfield as $skey => $sval) {
				$ssf = $sval;
				if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
					if (in_array($ssf, $this->search_field_equal)) {
						$search_where[$ssf] = $skeyword;
					} else {
						$swordarray = explode(' ', $skeyword);
						foreach ($swordarray as $str) {
							if (empty($ssf)) {
								continue;
							}
							if ($sop === 'AND') {
								$search_like[] = array($ssf => $str);
							} else {
								$search_or_like[] = array($ssf => $str);
							}
						}
					}
				}
			}
		} else {
			$ssf = $sfield;
			if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
				if (in_array($ssf, $this->search_field_equal)) {
					$search_where[$ssf] = $skeyword;
				} else {
					$swordarray = explode(' ', $skeyword);
					foreach ($swordarray as $str) {
						if (empty($ssf)) {
							continue;
						}
						if ($sop === 'AND') {
							$search_like[] = array($ssf => $str);
						} else {
							$search_or_like[] = array($ssf => $str);
						}
					}
				}
			}
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		$qry = $this->db->get('member_login_log');
		$result['total_rows'] = count($qry->result_array());
		// echo $this->db->last_query(); exit;
		return $result;
	}


	public function get_login_success_count($type = 'd', $start_date = '', $end_date = '', $orderby = 'asc')
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
		$left = ($type === 'y') ? 4 : ($type === 'm' ? 7 : 10);
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';

		$this->db->select('count(*) as cnt, left(mll_datetime, ' . $left . ') as day ', false);
		$this->db->where('mll_success', 1);
		$this->db->where('left(mll_datetime, 10) >=', $start_date);
		$this->db->where('left(mll_datetime, 10) <=', $end_date);
		$this->db->group_by('day');
		$this->db->order_by('mll_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}


	public function get_login_fail_count($type = 'd', $start_date = '', $end_date = '', $orderby = 'asc')
	{
		if (empty($start_date) OR empty($end_date)) {
			return false;
		}
		$left = ($type === 'y') ? 4 : ($type === 'm' ? 7 : 10);
		if (strtolower($orderby) !== 'desc') $orderby = 'asc';

		$this->db->select('count(*) as cnt, left(mll_datetime, ' . $left . ') as day ', false);
		$this->db->where('mll_success', 0);
		$this->db->where('left(mll_datetime, 10) >=', $start_date);
		$this->db->where('left(mll_datetime, 10) <=', $end_date);
		$this->db->group_by('day');
		$this->db->order_by('mll_datetime', $orderby);
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}
}
