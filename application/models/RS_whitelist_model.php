<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Whitelist model class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class RS_whitelist_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'rs_whitelist';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'wht_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

  /*
  ** 화이트리스트 목록 불러오는 function
  */
	public function get_whitelist_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
	{
    if($where && is_array($where)){
      $where['wht_deletion'] = 'N';
    } else {
      $where = array(
        'wht_deletion' => 'N'
      );
    }
    // join 방법
		// if (isset($where['mgr_id'])) {
		// 	$select = 'member.*';
		// 	$join[] = array('table' => 'member_group_member', 'on' => 'member.mem_id = member_group_member.mem_id', 'type' => 'left');
    // }
    //$select = array('wht_id','wht_title','wht_domain');
    $result = $this->_get_list_common($select = '', '', $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
		return $result;
  }
  
  /*
  ** 화이트리스트 도메인들을 불러오는 function
  */
	public function get_whitelist_domain($where = '')
	{
    if($where && is_array($where)){
      $where['wht_deletion'] = 'N';
    } else {
      $where = array(
        'wht_deletion' => 'N'
      );
    }
    $result = $this->get('', 'wht_domains', $where, '', 0);
    $domainList = array();
    foreach($result as $l){
      $newlist = $this->get_explode_domain_list(element('wht_domains',$l));
      $domainList = array_merge($domainList,$newlist);
    }
    $domainList = array_unique($domainList);
		return $domainList;
  }
  
  /*
  ** 엔터로 된 도메인 목록 array로 분리하는 function
  */
  public function get_explode_domain_list($domains){
    $domainArr = preg_split('/\r\n|[\r\n]/',$domains);
    $domainArr = array_map('trim',$domainArr);
    return $domainArr;
  }

  /*
  ** post 로 전송된 도메인 목록에 http, https 가 입력되어있는지
  ** 한글이 입력되지는 않았는지 확인하는 function
  */
  public function check_is_domainlist_right($domains){
    // $this->load->library('form_validation');
    //     $this->form_validation->CI =& $this;
    $domainArr = $this->get_explode_domain_list($domains);
    $preg = '/^([a-z]+\.)?[a-z0-9\-]+\.[a-z]+$/';
    foreach($domainArr as $l){
      $l = strtolower($l);
      if(strpos('https://',$l)===0 || strpos('http://',$l)===0){
        $this->form_validation->set_message('is_domain_right', '도메인에 http:// 또는 https:// 를 입력하실 수 없습니다.');
        return false;
      }
      if(!preg_match($preg,$l)){
        $this->form_validation->set_message('is_domain_right', '도메인 형식에 맞지 않습니다.<br/>입력가능문자 : 영어, 숫자, 특수문자 -');
        return false;
      }
    }
    return true;
  }
}
