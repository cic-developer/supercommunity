<!-- 팝업레이어 시작 -->
<style type="text/css">
html {
	overflow: hidden; 
	/*팝업창 스크롤 안생기게 하려고*/
} 
.popup_layer {position:absolute; left: -6px; bottom: 5px; width: 480px; height:900px; background-image:url("/assets/images/popupbackground.png"); background-repeat : no-repeat;
        background-size : cover;  display: block; margin: 0px auto;}
.popup_layer_footer {padding:10px 0;background:#000;color:#fff;text-align:right}
.popup_layer_footer button {margin-right:10px;padding:5px 10px;border:0;background:#4F4F4F;color:#FFFFFF}
</style>

	<div id="popup_layer" class="popup_layer">
    <?php echo $mis_payment_policy ?>
	</div>


<script type="text/javascript">
//<![CDATA[
$(function() {
	$(window).load(function() {
		var strWidth = $('#popup_layer').outerWidth() + (window.outerWidth - window.innerWidth);
		var strHeight = $('#popup_layer').outerHeight() + (window.outerHeight - window.innerHeight);
		//resize 
		window.resizeTo( strWidth, strHeight );
	});
});
//]]>
</script>
<!-- 팝업레이어 끝 -->
