<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sample_scheduler class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 스케쥴러를 통해 실행되는 샘플 class 입니다.
 */
class Scheduler extends CB_Controller
{
	private $CI;

	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
        $ip = $this->CI->input->ip_address();
        if(strcmp('127.0.0.1',$ip) === 0 || strcmp('13.209.87.198',$ip) === 0){
            echo "접근 완료";
        }else{
            echo "해당 아이피에서는 접근이 불가능합니다.";
            exit;
        }
	}

	public function index()
	{
		$ip = $this->CI->input->ip_address();
		// log_message('debug', $ip . '에서 Sample_scheduler 가 실행되었습니다.');
		// echo $ip . '에서 Sample_scheduler 가 실행되었습니다.';
		if(strcmp('127.0.0.1',$ip) == 0 || strcmp('172.31.32.47',$ip) == 0){
		}
	}


	public function scheduler()
	{
		$ip = $this->CI->input->ip_address();
		log_message('debug', $ip . '에서 Sample_scheduler 가 실행되었습니다.');
	}

	//경고 자동차감
	public function delete_warn(){
		$ip = $this->CI->input->ip_address();
		echo $ip . '에서 scheduler 에 접근하였습니다.';
		
        // echo $ip . '에서 scheduler 가 실행되었습니다.';
        log_message('error', $ip . '에서 scheduler 가 실행되었습니다.');
        $_now = date('Y-m-d H:i:s');
        $this->CI->db->where('mdw_ddate <=', $_now);
        $warn_list = $this->CI->db->get('member_delete_warn')->result();
        foreach($warn_list AS $l){
            $this->CI->db->delete('member_extra_vars',array(
                'mev_key' 	=> $l->mdw_type,
                'mev_value' => $l->mdw_value,
                'mem_id'	=> $l->mdw_mem_id
            ));
        }
        $this->CI->db->delete('member_delete_warn',array('mdw_ddate <=' => $_now));
	}
}
?>