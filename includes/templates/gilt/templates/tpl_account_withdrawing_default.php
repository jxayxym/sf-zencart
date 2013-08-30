<?php
if ($account_blance<100)
	echo '<p>Sorry!Because your account blance is less than $100,you can\'t withdrawe it! </p>';
else{
?>
<?php 
echo zen_draw_form('form1', zen_href_link(FILENAME_ACCOUNT_WITHDRAWING));
?>
<div>
<div style="text-align: center;border:1px solid #000;margin-top:20px;">
	<div style="background:#F21010;color:#fff;font-weight:bold;font-size:20px;border-bottom:1px solid #000;">Please input the amount you want withdrawe:</div>
	<div style="margin-top:10px;margin-bottom:10px; ">
	<input type="text" style="width:100px;" name="amount_withdrawe">(<?php echo $currencies->currencies[$_SESSION['currency']]['title']?>)
	<input type="submit" value="Apply">
	<p style="color:red;"><?php echo $msg;?></p>
	</div>
	<div style="text-align: left;">
	<p style="color:red;">*Your account blance is <?php echo $currencies->format($account_blance) ?> and you have appled to withdrawe <?php echo $currencies->format($amount_appling)?>,so what you input can't beyond <?php echo $currencies->format($account_blance-$amount_appling) ?>!</p>
	</div>
</div>
</form>
<?php
}	