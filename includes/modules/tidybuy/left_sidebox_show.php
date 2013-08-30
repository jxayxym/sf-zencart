<?php
if ($this_is_home_page || COLUMN_LEFT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION ['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF == 'true' and ($_SESSION ['customers_authorization'] != 0 or $_SESSION ['customer_id'] == ''))) {
	$flag_disable_left = true;
} else {
	$flag_disable_left = false;
}
$left_modules = array(
	'0'=>DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/account_management.php',
	'1'=>'',
	'999'=>'',//default
);
$left_sidebox_show = array(
	'0'=>array(
		FILENAME_ACCOUNT,
		FILENAME_ACCOUNT_HISTORY,
		FILENAME_ACCOUNT_HISTORY_INFO,
		FILENAME_ADDRESS_BOOK,
		FILENAME_ADDRESS_BOOK_PROCESS,
		FILENAME_ACCOUNT_PASSWORD,
		FILENAME_ACCOUNT_EDIT,
		FILENAME_GV_SEND,
		FILENAME_ACCOUNT_NOTIFICATIONS,
		FILENAME_ACCOUNT_COUPONS,
		FILENAME_GV_FAQ
	),
	'1'=>array (
		FILENAME_LOGIN,
		FILENAME_CREATE_ACCOUNT_SUCCESS,
		FILENAME_SHOPPING_CART,
		FILENAME_CHECKOUT_SHIPPING,
		FILENAME_CHECKOUT_PAYMENT,
		FILENAME_CHECKOUT_CONFIRMATION,
		FILENAME_CHECKOUT_PAYMENT_ADDRESS,
	),
	'999'=>'default'
);

if (isset($category_depth) && ($category_depth == 'nested'||$category_depth == 'products')){
	$left_modules['999'] = DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/product_list_modules.php';
}
if ($flag_disable_left==false){
	$module_column_left_override = false;
	foreach ($left_modules as $k=>$modules_path){
		if (is_array($left_sidebox_show[$k]) && in_array($_GET ['main_page'], $left_sidebox_show[$k]) && !empty($modules_path)){
?>
<div id="navColumnOne" class="columnLeft back" style="width: <?php echo COLUMN_WIDTH_LEFT; ?>">
	<div id="navColumnOneWrapper" style="width: <?php echo BOX_WIDTH_LEFT; ?>"><?php require($modules_path); ?></div>
</div>
<?php	
			break;
		}elseif ($left_sidebox_show[$k]=='default' && !empty($modules_path)){
	?>
		<div id="navColumnOne" class="columnLeft back" style="width: <?php echo COLUMN_WIDTH_LEFT; ?>">
			<div id="navColumnOneWrapper" style="width: <?php echo BOX_WIDTH_LEFT; ?>"><?php require($modules_path); ?></div>
		</div>
	<?php 
			break;
		}
	}
}else{
}