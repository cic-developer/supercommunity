<?php
defined('BASEPATH') or exit('No direct script access allowed');
// PER 광고 컨설팅 문의
$lang[0] = 'Media';   //상단 문자
$lang[1] = 'Application for mission';   //미디어 리스트 테이블 위 글자
$lang[2] = '<tr>
<th>Media name</th>
<th>Name of administrator </th>
<th>Admission link</th>
<th>Auth URL</th>
<th>Post Confirmation</th>
<th>Policy check</th>
<th>Applicable<br>Automatic check </th>
</tr>'; // 미션 테이블 헤드 th
$lang[3] = 'Mission View'; //미션 더보기 버튼
$lang[4] = "Mission Thumbnail"; //이미지 로드 실패시 메시지
$lang[5] = 'Up to 10MB of files can be uploaded';    //이미지 업로드시 validation 메시지
$lang[6] = 'Only image files can be uploaded';           //이미지 업로드시 validation 메시지
$lang[7] = 'Unsupported image file format';           //이미지 업로드시 validation 메시지
$lang[8] = '*Post Confirmation can be modified until confirm';
$lang[9] = "*When manager confirms, Post Confirmation can't be modified";
$lang[10] = '*Input the posted URL.';
$lang[11] = 'approved'; // 미디어 상태 표시(승인)
$lang[12] = 'refused'; // 미디어 상태 표시(반려)
$lang[13] = 'reviewing'; // 미디어 상태 표시(심사중)
$lang[14] = 'provided'; // 미디어 상태 표시(지급됨)
$lang[15] = '[Mission Application Guide]';
$lang[16] = '*The details and reasons for rejection of the application can be <br/>&nbsp; found on MY PAGE> Mission Certification Status.';
$lang[17] = '[Super Point Information]';
$lang[18] = '*Please make sure your media&#39;s Super Point is less than the Super Point<br/>&nbsp;	assigned to the mission.';
$lang[19] = '*Please note that there may be an early closing due to the exhaustion<br/>&nbsp; of the remaining perpoint.';
$lang[20] = 'applicable';
$lang['c_1'] = 'The mission will be closed/released. \n Go to the Per Shouting page.'; //미션 진입시 진행중이 아닌 미션일 경우
$lang['c_2'] = 'Mission Application Completed!';    //미션 신청 완료 message
$lang['c_3'] = 'Media'; //미션 신청하는 미디어가 있는지 체크, 없으면 나가리다
$lang['c_4'] = 'No registered media. Go to the Media Application page'; //미디어 없는경우 redirect message
$lang['c_5'] = 'Account information not found.';
$lang['c_6'] = 'Other media in the process of screening cannot proceed with the mission review.';
$lang['c_7'] = 'Mission application points are more than remaining points.';
$lang['c_8'] = 'Mission closed.';
$lang['c_9'] = 'An error occurred while registering the image registration.';
$lang['c_10'] = 'Please register the image.';
$lang['require_login'] = 'This service requires login.';
$lang['modalContent'] = '
<div class="modal-content">
<div class="modal-header">
    <h4 class="modal-title">Mission participation guide</h4>
    <button type="button" class="close" onclick="history.back()">×</button>
</div>
<div class="modal-body">
    <p class="start">Supercommunity prohibits <span style="font-weight:bold; color:#f40315;">abuse</span>.<br>
    Please check the precautions below.<br></p>
    <br>
    <br>
    <span style="font-weight: bold;">1.</span> Participating in the mission by copying someone else\'s post without permission<br>
    <br>
    <span style="font-weight: bold;">2.</span> If you have posted a post with no sincerity (low quality)<br>
    <br>
    <span style="font-weight: bold;">3.</span> In case of posting content not related to the mission content<br>
    <br>
    <span style="font-weight: bold;">4.</span> When deleting a post after receiving a mission reward<br>
    <br>
    <span style="font-weight: bold;">5.</span> Participating in two missions with one post<br>
    <br>
    <span style="font-weight: bold;">6.</span> Participating in the mission with the same content in different media<br>
    <br>
    <br>
    <p class="start2">In the case of the above, it can be regarded as <span style="font-weight:bold; color:#f40315;">Abusing and fraudulent users</span>.
    Abusing behavior and fraudulent use are warned or rejected. <br>
    I cannot receive the reward.<br></p>
    <br>
    <br>
    If you get a warning<br>
    <br>
    <p class="start3">One-time warning penalty applied<br>
    Permanent suspension of two warnings<br></p>
    <br>
    Sanctions are made. Thank you.
</div>
<div class="modal-footer">
    <div class="btn-group">
        <label>
            <input type="checkbox" class="btn btn-info set_state" id="infoModalBtn">
            I agree to the above.
        </label>
    </div>
</div>
</div>
';

$lang['modalContentWarning'] = '
<div class="modal-content">
<div class="modal-header">
    <h4 class="modal-title">Precautions</h4>
    <button type="button" class="close" id="warningModalXBtn">×</button>
</div>
<div class="modal-body">
<p>Since the Super Community is a self-participation rewarding</p><br>
<p>influencer advertising platform, it supports automated matching</p><br>
<p>between advertisers and influencers as much as possible. The Super</p><br>
<p>Community is responsible for the performance, stability, etc. of the</p><br>
<p>project and<span style="font-weight:bold; color:#f40315;"> we do not take any legal responsibilities found.</span></p><br>
</div>
<div class="modal-footer">
    <div class="btn-group" >
        <label>
            <input type="checkbox" class="btn btn-info set_state" id="warningModalBtn">
            Not available for 7 days
        </label>
    </div>
</div>
</div>';
$lang['c_11'] = 'Worng Media link.\nplease check your Media link';
$lang['alert_1'] = 'There is no media you have requested.';
$lang['confirm_1'] = 'Please, attach Image';
$lang['alert_message_modify'] = 'Modifications completed';
$lang['paymentPolicy_popup']  = 'View Policy';
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
