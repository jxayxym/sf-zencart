<?php
function getPaymentMethod($order_id){
	global $db;
	$sql = 'select payment_method from '.TABLE_ORDERS.' where orders_id='.(int)$order_id;
	$r = $db->execute($sql);
	return $r->fields['payment_method'];
}