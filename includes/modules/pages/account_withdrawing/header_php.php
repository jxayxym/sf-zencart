<?php
if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
$return_money_customer = new ReturnMoneyCustomer($_SESSION['customer_id']);

$account_blance = $return_money_customer->getTotalRebate()-$return_money_customer->getTotalWithdrawed();//余额

//计算提交申请,还未转账的余额
$sql = 'select sum(jinqian) as sum from ' . TABLE_FANLI_TIXIAN .' where customers_id='.(int)$_SESSION['customer_id'] .' and status<50';
$r = $db->Execute($sql);
$amount_appling = $r->fields['sum'];//已提交申请，还未处理的金额数
if ($_SERVER['REQUEST_METHOD']=='POST'){
	$configure = ReturnMoneyConfigure::getConfigure();
	$amount_withdrawe = (floatval($_POST['amount_withdrawe']/$currencies->currencies[$_SESSION['currency']]['value']));//申请提现余额
	//提现超过了余额
	if($amount_withdrawe<$configure['min_withdraw']){
		$msg = 'Sorry!The minimum amount you can withdrawe is '.$currencies->format($configure['min_withdraw']);
	}elseif(($amount_withdrawe+$amount_appling)>$account_blance){
		$msg = 'Sorry!The amount that you apply is beyond your account blance!';
	}else{
		$sql = 'insert into ' . TABLE_FANLI_TIXIAN .' values (NULL,'.$_SESSION['customer_id'].','.$amount_withdrawe.',\''.date('Y-m-d H:i:s').'\',0)';
		$db->Execute($sql);
		$amount_appling += $amount_withdrawe;
		$msg = 'Apply successfully!';
	}
}

$breadcrumb->add('Account', zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add('Withdrawing');