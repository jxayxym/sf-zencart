<?php
$i = 0;
while (!$weakly_deal_items->EOF){
	if ($i%2==0){
		$class_name = "mr5";
	}else{
		$class_name = "ml5";
	}
	$price = zen_get_products_actual_price($weakly_deal_items->fields['products_id']);
	$display_price = $currencies->display_price($price,0);
?>
	<div class="back weakly_deal_item mb5 <?php echo $class_name ?>">
	<a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$weakly_deal_items->fields['products_id'])?>">
		<img alt="<?php echo $weakly_deal_items->fields['products_name']?>" src="<?php echo DIR_WS_IMAGES.$weakly_deal_items->fields['products_image']?>" width="300px" height="280px" />
	</a>
	<div class="weekly_deal_item_price"><?php echo $display_price?></div>
	</div>
<?php
	$i++;
	if($i%2==0){
		echo '<br class="clearBoth" />';
	}
	
	$weakly_deal_items->MoveNext();
}
?>
<script>
<?php 
$weak = date(w)=='0'?7:date(w);//获取今天星期几
$end_date = date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")+(7-$weak), date("Y")));//距周未结束天数
list($end_y,$end_m,$end_d) = explode('-', $end_date);
?>
var SysSecond;
var InterValObj;
timenow = new Date(<?php echo date('Y')?>,<?php echo date('m')?>,<?php echo date('d')?>,<?php echo date('H')?>,<?php echo date('i')?>,<?php echo date('s')?>);
time = timenow.getTime();
endtime  = new Date(<?php echo $end_y?>,<?php echo $end_m?>,<?php echo $end_d?>,23,59,59);
end = endtime.getTime();
SysSecond = Math.floor(((end - time)/1000));
InterValObj = window.setInterval(SetRemainTime, 1000);   
function SetRemainTime() {
	if (SysSecond > 0) {
		SysSecond =SysSecond-1;
		var second = Math.floor(SysSecond % 60);               
		var minite = Math.floor((SysSecond / 60) % 60);   
		var hour = Math.floor((SysSecond / 3600) % 24);      
		var day = Math.floor((SysSecond / 3600) / 24);
		if(second<10){
			second = '0'+second;
		}
		if(hour<10){
			hour = '0'+hour;
		}
		if(minite<10){
			minite = '0'+minite;
		}
		$("#lblRemainTime").html('Remaining Time:'+day +"d-"+ hour +"h-"+ minite +"m-"+ second +"s");

	} else {
		SysSecond = SysSecond + 604800;
	}
};
</script>