<?php
function sf_get_customer_coupons(){
	global $db;
	$sql = 'select * from '.TABLE_COUPONS.' c join '.TABLE_COUPONS_DESCRIPTION.' cd on c.coupon_id=cd.coupon_id '.
		 	'where coupon_type!=\'G\' and coupon_active=\'Y\'';
	$r = $db->Execute($sql);
	return $r;
}

function sf_get_customer_gift_certificate($customer_id){
	global $db;
	$sql = 'select * from '.TABLE_COUPONS.' c join '.TABLE_COUPON_EMAIL_TRACK.' cet on c.coupon_id=cet.coupon_id '.
			'join '.TABLE_CUSTOMERS.' t_c on t_c.customers_email_address=cet.emailed_to '.
			'left join '.TABLE_COUPON_REDEEM_TRACK.' crt on crt.coupon_id=c.coupon_id '.
			'where coupon_type=\'G\' and t_c.customers_id='.$customer_id;
	$r = $db->Execute($sql);
	return $r;
}

function sf_get_customer_gv_blance($customer_id){
	global $db,$currencies;
	$gv_query = "SELECT amount
             FROM " . TABLE_COUPON_GV_CUSTOMER . "
             WHERE customer_id = :customersID";
	
	$gv_query = $db->bindVars($gv_query, ':customersID', $customer_id, 'integer');
	$gv_result = $db->Execute($gv_query);
	$customer_gv_balance = 0;
	if ($gv_result->RecordCount() && $gv_result->fields['amount'] > 0 ) {
		$customer_gv_balance = $currencies->format($gv_result->fields['amount']);
	}	
	return $customer_gv_balance;
}
function sf_valid_coupons($coupons_id,$customer_id){
	global $db;
	$sql = 'select * from '.TABLE_COUPONS.' where coupon_start_date<=now() and coupon_expire_date>=now() and coupon_id='.$coupons_id;
	$r = $db->Execute($sql);
	if($r->RecordCount()==0){
		return false;
	}
	$sql = 'select count(*) as all_used from '.TABLE_COUPON_REDEEM_TRACK.' where coupon_id='.$coupons_id;
	$r2 = $db->Execute($sql);//所有用户总共使用的次数
	$sql = 'select count(*) as customer_used from '.TABLE_COUPON_REDEEM_TRACK.' where coupon_id='.$coupons_id.' and customer_id='.$customer_id;
	$r3 = $db->Execute($sql);//指定的用户总共使用的次数
	
	if($r->fields['uses_per_user']<=$r3->fields['customer_used']){
		return false;
	}elseif ($r->fields['uses_per_coupon']>0 && $r->fields['uses_per_coupon']<=$r2->fields['all_used']){
		return false;
	}
	return true;
}