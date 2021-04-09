<!-- 팝업레이어 시작 -->
<style type="text/css">
/* html {
	overflow: hidden; 
	
}  */
.popup_layer {position:absolute; right:-10px; width: 580px; height:980px; margin-left:50px; background-image:url("/assets/images/popupbackground.png"); background-repeat : no-repeat;
        background-size : cover;  display: block; margin: 0px auto;}
.popup_layer_footer {padding:10px 0;background:#000;color:#fff;text-align:right}
.popup_layer_footer button {margin-right:10px;padding:5px 10px;border:0;background:#4F4F4F;color:#FFFFFF}
.popup_contents {width: 500px; height: 300px; outline: 1px dotted red;}
</style>

	<div id="popup_layer" class="popup_layer">
	<div class="popup_contents">
		<?php echo $mis_payment_policy ?>
	</div>
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
