<script src="<?php echo HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_TEMPLATE.'jscript/srcMarquee.js' ?>" type="text/javascript"></script>
<script src="<?php echo HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_TEMPLATE.'jscript/jquery.lazyload.js' ?>" type="text/javascript"></script>
<script src="<?php echo HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_TEMPLATE.'jscript/jquery.scroll.js' ?>" type="text/javascript"></script>
<style>
.lazy {display: none;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("img.lazy").show().lazyload({
		effect : "fadeIn",
	});	
});
function TidybuyPopupWindow(url,width,height) {
	var width = width || 800;
	var height = height || 600;
	window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width='+width+',height='+height+',screenX=150,screenY=150,top=150,left=150');
}
</script>