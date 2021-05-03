<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language hook class
 *
 * Copyright (주)알에스팀 <www.rs-team.com>
 *
 * @author (주)알에스팀 (developer@rs-team.com)
 */

class _Language
{

	private $CI;


	/**
	 * 언어팩에 활용될 세션을 설정하는 역할을 담당하고 있습니다.
	 */
	function init()
	{
    $this->CI =& get_instance();
    $default_lang = 'korean';
    $allowed_lang = array(
      'korean',
      'english'
    );
    $user_get_lang = $this->CI->input->get('lang');

    // querystring 에 lang 값이 존재 할 경우
    if($user_get_lang){
      
      // 허가된 언어팩일 경우 유저 요청대로 세팅
      if(in_array($user_get_lang, $allowed_lang)){

          $this->CI->session->set_userdata('lang', $user_get_lang);

      // 허가된 언어팩이 아닌 경우 기본값으로 세팅
      } else {

        if($this->CI->session->userdata('lang')){

          // nothing

        } else {

          // 이상한 lang 값 입력했으면 기본값 $default_lang;
          $this->CI->session->set_userdata('lang',$default_lang);

        }

      }

    // querystring 에 lang 값이 없을 경우
    } else {

      //설정된 lang 값이 있을경우
      if($this->CI->session->userdata('lang')){

        // nothing

      //설정된 lang 값이 없을경우 기본값 세팅
      } else {

        $this->CI->session->set_userdata('lang',$default_lang);

      }

    }

    /*
      한국어일때 한국어 게시판,
      영어일때 영어 게시판으로 이동
    */
    if($this->CI->session->userdata('lang') == 'korean' && ($this->CI->uri->segment(1) == 'board' || $this->CI->uri->segment(1) == 'post') && $this->CI->uri->segment(2) == 'noti_en'){
      redirect('/board/noti');
    } else if($this->CI->session->userdata('lang') == 'english' && ($this->CI->uri->segment(1) == 'board' || $this->CI->uri->segment(1) == 'post') && $this->CI->uri->segment(2) == 'noti'){
      redirect('/board/noti_en');
    }

    if($this->CI->session->userdata('lang') == 'korean' && ($this->CI->uri->segment(1) == 'board' || $this->CI->uri->segment(1) == 'post') && $this->CI->uri->segment(2) == 'wallet_noti_en'){
      redirect('/board/wallet_noti');
    } else if($this->CI->session->userdata('lang') == 'english' && ($this->CI->uri->segment(1) == 'board' || $this->CI->uri->segment(1) == 'post') && $this->CI->uri->segment(2) == 'wallet_noti'){
      redirect('/board/wallet_noti_en');
    }
	}
}
