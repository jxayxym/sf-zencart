<?php
function emailNotifyAfterOrderConfirmation($order){
	global $db;
	$sql = 'select `customers_gender`,`customers_firstname` from '.TABLE_CUSTOMERS.' where `customers_id`='.(int)$_SESSION['customer_id'];
	$r = $db->Execute($sql);
	$block = array();
	$gender = $r->fields['customers_gender']=='f'?'Ms':'Mr';
	$subject = 'Comfirom your payment for your order';

	$block['EMAIL_SUBJECT'] = $subject;
	$block['EMAIL_MESSAGE_HTML'] .= 'Dear '.$gender.' '.$r->fields['customers_firstname'].'<br />';	
	if ($_SESSION['payment'] == 'moneygram'||$_SESSION['payment'] == 'westernunion'){
		$block['EMAIL_MESSAGE_HTML'] .= "    We're thanks for your shopping at our web site, I hope you're enjoyed with it, Because you have choosed ".$_SESSION['payment']." as your methods of payment, So you must to your local bank to complete the payment, And we're sorry about the inconvenience. <br />";
		$block['EMAIL_MESSAGE_HTML'] .= '<b>My information for you to send money with '.$_SESSION['payment'].' is as follows:</b><br />';
	
		$block['EMAIL_MESSAGE_HTML'] .= '*************************<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'First name:'.($_SESSION['payment'] == 'moneygram'?MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME:MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME).'<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'last name:'.($_SESSION['payment'] == 'moneygram'?MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME:MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME).'<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'country:'.($_SESSION['payment'] == 'moneygram'?MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY:MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY).'<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'zip code:'.($_SESSION['payment'] == 'moneygram'?MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP:MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP).'<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '*************************<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '<b>And please tell us your remittance information as follows:</b><br />';
		$block['EMAIL_MESSAGE_HTML'] .= '*************************<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'your name:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'first name:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'last name:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'street:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'state/city:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'country:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'MTCN（money transfer ctrl number ):<br />';
		$block['EMAIL_MESSAGE_HTML'] .= 'The total amount of money:<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '*************************<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '   After that please inform us so that we can arrange the shippment on time.<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '   May you have a good mind to spend every day!<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '                                                    vicky<br />';
		$block['EMAIL_MESSAGE_HTML'] .= '                                                    '.STORE_NAME.' service center<br />';
	}else{
		$block['EMAIL_MESSAGE_HTML'] .= "    We're thanks for your shopping at our web site, I hope you're enjoyed with it. <br />";
		$block['EMAIL_MESSAGE_HTML'] .= 'You have choosed paypal/visa as your methods of payment,and our store can\'t support paypal/visa payment the moment, But if you really want to pay with paypal, You can contact us or leave a message, Our customer service member will contact you as soon as possible. Thanks.And we\'re sorry about the inconvenience. '; 
	}
	$content = str_replace('<br />', "\n", $block['EMAIL_MESSAGE_HTML']);
//	echo $block['EMAIL_MESSAGE_HTML'];exit;
	$block['EMAIL_FOOTER_COPYRIGHT'] = EMAIL_FOOTER_COPYRIGHT;
	$block['EMAIL_DISCLAIMER'] = sprintf(EMAIL_DISCLAIMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS .' </a>');;
	$block['EMAIL_SPAM_DISCLAIMER'] = EMAIL_SPAM_DISCLAIMER;
	zen_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], $subject, $content, STORE_NAME, EMAIL_FROM,$block);
}