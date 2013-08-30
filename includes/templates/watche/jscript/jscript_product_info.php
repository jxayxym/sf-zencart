<?php require DIR_WS_MODULES.'jqzoom/init_jqzoom.php';?>
<script type="text/javascript">
$(document).ready(function(){
	$(".righti, .lefti").tooltip();
	//自定义尺寸输入表单的显示与隐藏
	$("select[id='attrib-1']").change(function(i){
		if($(this).attr("value")=='1'){
			$(".wrapperAttribsOptions").filter(function(i){
				if($(".optionName",this).text().match('Bust|Waist|Hips|Hollow to Floor'))
					return true;
			}).show();
		}else{
			$(".wrapperAttribsOptions").filter(function(i){
				if($(".optionName",this).text().match('Bust|Waist|Hips|Hollow to Floor'))
					return true;
			}).hide();
		}
	});
	$("#attrib-6-0").attr("value","the same as the photo");
	$("input","#productAttributes").click(function(){
            if($.browser.msie) this.createTextRange().select();
            else {
                this.selectionStart = 0;
                this.selectionEnd = this.value.length;
            }
	});

	$("input[name='addToCart']").click(function(){
		var size = $("select[id='attrib-1']").val() || 9999;
		if(size==1){
			var bust = $("#attrib-2-0").val();
			var waist = $("#attrib-3-0").val();
			var hips = $("#attrib-4-0").val();
			var hollow_to_floor = $("#attrib-5-0").val();
			if(bust=="") {
				alert("Please input your bust value.");
				$("#attrib-2-0").focus();
				return false;
			}
			if(waist=="") {
				alert("Please input your waist value.");
				$("#attrib-3-0").focus();
				return false;
			}
			if(hips=="") {
				alert("Please input your hips value.");
				$("#attrib-4-0").focus();
				return false;
			}
			if(hollow_to_floor=="") {
				alert("Please input your hollow to floor value.");
				$("#attrib-5-0").focus();
				return false;
			}
		}

		if($("#attrib-6-0").size()){
			var color = $("#attrib-6-0").val();
			if(color==''){
				alert("Please input color value.");
				$("#attrib-6-0").focus();
				return false;			
			}
		}
		return true;
	});
});
</script>
