<?php
/**
 *功能：91Hpay支付返回页面
 *详细：用于返回后更新订单状态，以及客户跳转
 *版本：1.0.0
 *修改日期：2012.12.20
 */
if (!empty($_GET) && empty($_POST)) {
	$_POST = $_GET;
}
unset($_GET);
require('includes/application_top.php');
if (empty($_POST)) {
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
}
require('includes/functions/functions_Hpay.php');
$_GET = $_POST;
$order_id = trim($_GET['remark1']);
unset($_SESSION['order_id']);
require(DIR_WS_CLASSES . 'shipping.php');
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($_SESSION['payment']);
$shipping_modules = new shipping($_SESSION['shipping']);
$version=$_GET['version'];
$encoding=$_GET['encoding'];
$lang=$_GET['language'];
$merchantid=$_GET['merchantid'];
$transtype=$_GET['transtype'];
$orderid=$_GET['orderid'];
$orderdate=$_GET['orderdate'];
$currency=$_GET['currency'];
$orderamount=$_GET['orderamount'];
$paycurrency=$_GET['paycurrency'];
$payamount=$_GET['payamount'];
$remark1=$_GET['remark1'];
$remark2=$_GET['remark2'];
$remark3=$_GET['remark3'];
$product='';
for($i=1;$i<=10;$i++) {
	if($_GET['productname'.$i]=='') {
		break;
	}
	$product=$product.$_GET['productname'.$i] . $_GET['productsn'.$i] . $_GET['quantity'.$i] . $_GET['unit'.$i];
}
$shippingfee=$_GET['shippingfee'];
$deliveryname=$_GET['deliveryname'];
$deliveryaddress=$_GET['deliveryaddress'];
$deliverycountry=$_GET['deliverycountry'];
$deliveryprovince=$_GET['deliveryprovince'];
$deliverycity=$_GET['deliverycity'];
$deliveryemail=$_GET['deliveryemail'];
$deliveryphone=$_GET['deliveryphone'];
$deliverypost=$_GET['deliverypost'];
$HPAYid=$_GET['transid'];
$HPAYdate=$_GET['transdate'];
$status=$_GET['status'];
$signature=$_GET['signature'];
if(($status=="N")){
	$messageStack->add_session('checkout_payment', 'Your payment transaction failed!Please check your credit card info and try again!', 'error');
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
}
$hashkey = MODULE_PAYMENT_HPAY_HASHKEY;
write_log(":".$signature."\n");
write_log(":".$hashkey."\n");
$strcontent=$hashkey . $version . $encoding . $lang . $merchantid . $transtype . $orderid .
$orderdate . $currency. $orderamount . $paycurrency . $payamount .$remark1 . $remark2 .
$remark3 .  $product .$shippingfee . $deliveryname . $deliveryaddress . $deliverycountry .$deliveryprovince.
$deliverycity . $deliveryemail . $deliveryphone . $deliverypost . $HPAYid . $HPAYdate . $status;
write_log(":".$strcontent."\n");
$getsignature=md5($strcontent);
write_log("".$getsignature."\n");
if(!($getsignature==$signature)) {
	write_log('md5 hash not match. ');
	$messageStack->add_session('checkout_payment', 'signature error!', 'error');
	unset($_SESSION['order_id']); //if the customer come back and replace same order which has been paid
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
}
if (defined('MODULE_PAYMENT_HPAY_PROCESSING_STATUS_ID') ) {
	$new_status = MODULE_PAYMENT_HPAY_PROCESSING_STATUS_ID;
} else {
	$new_status = 2;
}
if ($status == 'Y' || $status == 'y') {
	$sql = "UPDATE " . TABLE_ORDERS  . "
    SET orders_status = $new_status " .  "
    WHERE orders_id = '" . $order_id . "'";
	$db->Execute($sql);
}
require(DIR_WS_CLASSES . 'order.php');
$order = new order($order_id);

if($paycurrency==$currency&&$payamount!=$orderamount) {
	write_log('paycurrency and order currency is match, but payamount and orderamount is not match ');
	$messageStack->add_session('checkout_payment', 'payamount is not match orderamount!', 'error');
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
}
if ($status == 'Y' || $status == 'y') {
	$comment = 'Order payment is under process!';
	$comment = 'Order payment is successfull! Transaction ID:' . $HPAYid;
	$order_status = $new_status;
} else {
	$comment = 'Order payment is under process!';
	if ( defined('MODULE_PAYMENT_HPAY_ORDER_STATUS_ID') ) {
		$order_status = MODULE_PAYMENT_HPAY_ORDER_STATUS_ID ;
	} else {
		$order_status = 1;
	}
}
if ($status == 'Y' || $status == 'y') {
	$lang_file = DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php';
	if ( file_exists($lang_file)) {
		require_once($lang_file);
	} else {
		require_once('includes/languages/english/checkout_process.php');
	}
	//$order->send_order_email($new_order_id, 2);
}
$sql_data_array = array ('orders_id' => $order_id,
    'orders_status_id' => $order_status,
    'date_added' => 'now()',
    'comments' => $comment, 
    'customer_notified' => '1'
);
zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
$_SESSION['cart']->reset(true);
unset($_SESSION['order_id']);
unset($_SESSION['old_cur']);
zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL', true, false));
?>
