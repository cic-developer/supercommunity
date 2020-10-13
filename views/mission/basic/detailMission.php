<?php /*카운트 다운용 CSS와 JS를 불러오는 부분입니다. 예시니까 다른걸 사용하셔도 상관없습니다*/?>
<link rel="stylesheet" href="<?=site_url('plugin/flipdown-master/src/flipdown.css')?>"/>
<script src="<?=site_url('plugin/flipdown-master/src/flipdown.js')?>"></script>

<?php /*카운트 다운용 div 만들어놓은겁니다. 마음대로 하셔도 상관없습니다*/?>
<div class="countDown">
    <div id="flipdown" class="flipdown"></div>
</div>


<?php /*데이터 확인용 div입니다. 삭제 예정이고 마음대로 하셔도 상관없습니다*/?>
<div class="data">
    <pre><?php print_r($mission_data)?></pre>
</div>

<?php /*filpdown 카운트 적용 js입니다. */?>
<script>
    var flipdown = new FlipDown(<?=strtotime($mission_data['mis_enddate'])?>);

    $(document).ready(function(){
        flipdown.start ();
        flipdown.ifEnded (() => {
            alert('미션이 종료되었습니다!');
        });
    });
    
    
</script>