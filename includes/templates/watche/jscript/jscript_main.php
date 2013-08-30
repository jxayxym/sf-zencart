<link rel="stylesheet" href="<?php echo HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_TEMPLATE.'jscript/woothemes-FlexSlider-a4647ed/flexslider.css'?>" />
<script src="<?php echo HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_TEMPLATE.'jscript/woothemes-FlexSlider-a4647ed/jquery.flexslider-min.js' ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".current_currency").click(function(){
		$(".currencies_list").toggle();
	});
	$(".navAccount").click(function(){
		$('.account_operate').toggle();
		return false;
	});
});
</script>