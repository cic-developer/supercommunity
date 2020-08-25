<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Mediatype model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_mediatype_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_mediatype';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'met_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

  /*
  ** 미디어성격 목록 불러오는 function
  */
	public function get_mediatype_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
    if($where && is_array($where)){
      if(!element('met_deletion',$where))$where['met_deletion'] = 'N';
    } else {
      $where = array(
        'met_deletion' => 'N'
      );
		}
    // join 방법
		// if (isset($where['mgr_id'])) {
		// 	$select = 'member.*';
		// 	$join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
    // }
    //$select = array('wht_id','wht_title','wht_domain');
    $result = $this->_get_list_common($select = '', $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
  }

  /*
  ** 미디어성격 index Array 불러오는 function
  */
	public function get_mediatype_index($where = '')
	{
    if($where && is_array($where)){
      if(!element('met_deletion',$where))$where['met_deletion'] = 'N';
    } else {
      $where = array(
        'met_deletion' => 'N'
      );
		}
		$getdata = $this->RS_mediatype_model->get('','',$where);
		$metArr = array();
		foreach($getdata as $l){
			$metArr[] = element('met_id',$l);
		}
		return $metArr;
	}
	


	public function update_mediatype($data = '')
	{
		$order = 1;
		if (element('met_id', $data) && is_array(element('met_id', $data))) {
			foreach (element('met_id', $data) as $key => $value) {
				if ( ! element($key, element('met_title', $data))) {
					continue;
				}
				if ($value) {
					$updatedata = array(
						'met_title' => $data['met_title'][$key],
						'met_order' => $order,
						'met_mdate' => cdate('Y-m-d H:i:s'),
						'met_modifier_mem_id'=> $this->session->userdata('mem_id'),
						'met_modifier_ip'=> $this->input->ip_address(),
					);
					$this->update($value, $updatedata);
				} else {
					$insertdata = array(
						'met_title' => $data['met_title'][$key],
						'met_order' => $order,
						'met_wdate' => cdate('Y-m-d H:i:s'),
						'met_mdate' => cdate('Y-m-d H:i:s'),
						'met_mem_id'=> $this->session->userdata('mem_id'),
						'met_register_ip'=> $this->input->ip_address(),
					);
					$this->insert($insertdata);
				}
			$order++;
			}
		}

		// 작성/수정 로그 기록
		$this->load->model('RS_mediatype_log_model');
		$logdata = array(
			'mtl_mem_id' => $this->session->userdata('mem_id'),
			'mtl_userid' => element('mem_userid',$this->Member_model->get_by_memid($this->session->userdata('mem_id'), 'mem_userid')),
			'mtl_datetime' => cdate('Y-m-d H:i:s'),
			'mtl_ip' => $this->input->ip_address(),
			'mtl_data' => json_encode($data,JSON_UNESCAPED_UNICODE),
			'mtl_useragent' => $this->agent->agent_string(),
		);
		$this->RS_mediatype_log_model->insert($logdata);

		$deletewhere = array(
			'met_mdate !=' => cdate('Y-m-d H:i:s'),
		);
		$deleteupdate = array(
			'met_deletion' => 'Y',
			'met_order' => 99999
		);
		$this->update('',$deleteupdate,$deletewhere);
	}

}
