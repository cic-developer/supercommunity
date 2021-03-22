<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// PER 광고 컨설팅 문의
$lang[0] = '내미디어';   //상단 문자
$lang[1] = '미션신청';   //미디어 리스트 테이블 위 글자
$lang[2] = '<tr>
<th>미디어네임</th>
<th>관리자명</th>
<th>입장링크</th>
<th>게시링크</th>
<th>게시인증</th>
<th>SUPER POINT</th>
<th>예상지급 <br>PER PPOINT</th>
<th>신청상태<br>자동체크</th>
</tr>';// 미션 테이블 헤드 th
$lang[3] = '미션보기'; //미션 더보기 버튼
$lang[4] = "미션썸네일" ; //이미지 로드 실패시 메시지
$lang[5] = '파일은 최대 10MB까지 업로드 가능합니다.';    //이미지 업로드시 validation 메시지
$lang[6] = '이미지 파일만 업로드 가능합니다.';           //이미지 업로드시 validation 메시지
$lang[7] = '지원하지 않는 이미지 파일입니다.';           //이미지 업로드시 validation 메시지
$lang[8] = '*관리자 신청확인 전까지 게시인증 수정이 가능합니다.';
$lang[9] = '*관리자가 신청확인 후에는 게시인증 수정이 불가능합니다.';
$lang[10] = '*포스팅 URL을 입력하세요.';
$lang[11] = '승인완료'; // 미디어 상태 표시(승인)
$lang[12] = '반려'; // 미디어 상태 표시(반려)
$lang[13] = '심사중'; // 미디어 상태 표시(심사중)
$lang[14] = '지급됨'; // 미디어 상태 표시(지급됨)
$lang[15] = '[미션신청 안내]';
$lang[16] = '*신청 거절 내역및 사유는  MY PAGE > 미션인증현황에서 확인 할 수 있습니다.';
$lang[17] = '[슈퍼포인트 안내]';
$lang[18] = '*내 미디어의 슈퍼포인트가 미션에 할당된 슈퍼포인트보다 작은지 확인해주세요.';
$lang[19] = '*잔여 퍼 포인트 소진에 따라 조기 마감될수 있는 점 주의 바랍니다';
$lang[20] = '신청가능';
$lang['c_1'] = '해당 미션은 종료/공개 예정입니다. \n Per Shouting 페이지로 이동합니다.'; //미션 진입시 진행중이 아닌 미션일 경우
$lang['c_2'] = '미션 신청 완료!';    //미션 신청 완료 message
$lang['c_3'] = '미디어'; //미션 신청하는 미디어가 있는지 체크, 없으면 나가리다
$lang['c_4'] = '등록된 미디어가 없습니다. 미디어 신청페이지로 이동합니다.'; //미디어 없는경우 redirect message
$lang['c_5'] = '계정 정보를 찾을 수 없습니다.';
$lang['c_6'] = '다른 심사 진행중인 미디어는 미션 심사를 진행하실 수 없습니다.';
$lang['c_7'] = '미션 신청 포인트가 남은 잔여 포인트보다 많습니다.';
$lang['c_8'] = '미션이 마감되었습니다.';
$lang['c_9'] = '이미지 등록중 오류가 발생하였습니다.';
$lang['c_10'] = '이미지를 등록해주세요';
$lang['require_login'] = '로그인이 필요한 서비스 입니다.';
$lang['modalContent'] = '
<div class="modal-content" >
<div class="modal-header">
    <h4 class="modal-title">미션 참여 안내</h4>
    <button type="button" class="close" onclick="history.back()">×</button>
</div>
<div class="modal-body">
    <p class="start">슈퍼커뮤니티에서는 <span style="font-weight:bold; color:#f40315;">어뷰징행위</span>를 금지합니다.<br>
    아래의 주의사항을 확인해주세요.<br></p>
    <br>
    <br>
    <span style="font-weight: bold;">1.</span> 타인의 게시글을 무단으로 복사하여 미션에 참여하는 경우<br>
    <br>
    <span style="font-weight: bold;">2.</span> 성의 없는 게시글(저품질)을 게시한 경우<br>
    <br>
    <span style="font-weight: bold;">3.</span> 미션 내용과 관계없는 내용을 게시한 경우<br>
    <br>
    <span style="font-weight: bold;">4.</span> 미션 보상 수령 후 게시글을 삭제하는 경우<br>
    <br>
    <br>
    <p class="start2">위의 내용에 해당하는 경우 <span style="font-weight:bold; color:#f40315;">어뷰징 및 부정 사용자</span>로 간주할 수 있으며,<br>
    어뷰징 행위 및 부정 사용 사항에 대해 경고 또는 반려 처리되며 <br>
    리워드를 지급받을 수 없습니다.<br></p>
    <br>
    <br>
    경고를 받는 경우<br>
    <br>
    <p class="start3">1회 경고 패널티 적용<br>
    2회 경고 영구정지<br></p>
    <br>
    의 제재가 이루어집니다. 감사합니다.
</div>
<div class="modal-footer">
    <div class="btn-group">
        <label>
            <input type="checkbox" class="btn btn-info set_state" data-dismiss="modal">
            위의 내용에 동의합니다.
        </label>
    </div>
</div>
</div>
';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';
$lang[] = '';