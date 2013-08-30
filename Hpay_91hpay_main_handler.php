<?php
/**
 *功能：91Hpays2s action
 *详细：用于返回后更新订单状态
 *版本：1.0.0
 *修改日期：2012.12.20
*/
if (!empty($_GET) && empty($_POST)) {
	$_POST = $_GET;
}
unset($_GET);
if (empty($_POST)) {
	die();
}
require('includes/application_top.php');
require('includes/functions/functions_Hpay.php');
$_GET = $_POST;
$order_id = trim($_GET['remark1']);
$lang_file = DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php';
if ( file_exists($lang_file)) {
	require($lang_file);
} else {
	require('includes/languages/english/checkout_process.php');
}
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
/**用于对回传的购物车数据进行遍历
 * $i<10对返回加密的数据进行限制，方式url传参过长
 */
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
$hpayid=$_GET['transid'];
$hpaydate=$_GET['transdate'];
$status=$_GET['status'];
$signature=$_GET['signature'];
write_log("s2s签名:".$signature."\n");
if(!($status=="Y")) {
	echo 'ISRESPONSION';//对非Y订单进行对账响应
	die(); //no need any output if failed.
	write_log('Payment is faild');
	$messageStack->add_session('checkout_payment', 'transaction failed!', 'error');
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT,'','SSL', true, false));
}
$hashkey = MODULE_PAYMENT_HPAY_HASHKEY;
write_log("s2s商户key:".$hashkey."\n");
write_log('md5 hash is :' . $hashkey);
$strcontent=$hashkey. $version . $encoding . $lang . $merchantid . $transtype . $orderid .
$orderdate . $currency. $orderamount . $paycurrency . $payamount .$remark1 . $remark2 .
$remark3 .  $product .$shippingfee . $deliveryname . $deliveryaddress . $deliverycountry .$deliveryprovince.
$deliverycity . $deliveryemail . $deliveryphone . $deliverypost . $hpayid . $hpaydate . $status;
write_log("s2s商户签名数据:".$strcontent."\n");
$getsignature=md5($strcontent);
write_log("s2s商户签名:".$getsignature."\n");
/**
 * 判断返回数据的签名是否与本地签名一致
 */
if(!($getsignature==$signature)) {
	die('Signature error!');
}
if ( defined('MODULE_PAYMENT_HPAY_PROCESSING_STATUS_ID') ) {
	$new_status = MODULE_PAYMENT_HPAY_PROCESSING_STATUS_ID;
} else {
	$new_status = 2;
}
$sql = "UPDATE " . TABLE_ORDERS  . "
    SET orders_status = $new_status " .  "
    WHERE orders_id = '" . $order_id . "'";
$db->Execute($sql);
require(DIR_WS_CLASSES . 'order.php');
global $order, $currencies;
$order = new order($order_id);
$comment = 'Order payment is successfull! Transaction ID:' . $hpayid;
$sql1="select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id='" .$order_id . "'";
$result=$db->Execute($sql1);
//添加对此对账bug判断
if(mysql_num_rows($result)< 3){
$sql_data_array = array('orders_id' => $order_id,
    'orders_status_id' => $new_status,
    'date_added' => 'now()',
    'comments' => $comment,
    'customer_notified' => '1'
);
zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
}
echo 'ISRESPONSION';
//$order->send_order_email($order_id,2);
$_SESSION['cart']->reset(true);
unset($_SESSION['order_id']);
unset($_SESSION['old_cur']);
?>
