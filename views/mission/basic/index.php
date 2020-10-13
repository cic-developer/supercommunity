<div>
    <ul style="padding: 0;">
<?php foreach($view['data']['list'] AS $d){ // 여기서부터 li 닫는데까지 반복해서 li 만들어줌?>
        <li style="list-style-type: none; display: inline-block">
            <div style="float:left; width:30%">
                <img src="<?= thumb_url('mission_thumb_img', element('mis_thumb_image', $d), 400, 300)?>" alt="<?=element('mis_thumb_image', $d)?>" />
            </div>
            <div style="float:right; width:30%">
                여기가 오른쪽
            </div>
        </li>
<?php } ?>
    </ul>
</div>