<?php
if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
$return_money_customer = new ReturnMoneyCustomer($_SESSION['customer_id']);

$sql = 'select distinct(cf.fanlidian_id) as fanlidian_id,add_date,fanli_configure from ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN_FANLI .' cff '.
	   'join ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN .' cf on cf.fanlidian_id=cff.fanlidian_id '.
	   'where customers_id='.$_SESSION['customer_id'] . ' order by cf.fanlidian_id ASC , cff.fanli_date DESC';
$result_rebate_points = $db->Execute($sql);

$rebate_point_id = array();
while (!$result_rebate_points->EOF){
	$configure = unserialize($result_rebate_points->fields['fanli_configure']);
	$fanli_end = date('Y-m-d',strtotime($result_rebate_points->fields['add_date'])+$configure['fanli_tianshu']*24*60*60);//返利结束日期
	
	$rebate_point_id[sizeof($rebate_point_id)] = array(
		'fanlidian_id'=>$result_rebate_points->fields['fanlidian_id'],
		'add_date'=>$result_rebate_points->fields['add_date'],
		'fanli_end'=>$fanli_end,
	);
	$result_rebate_points->MoveNext();
}

$sql = 'select * from ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN_FANLI .' cff '.
	   'join ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN .' cf on cf.fanlidian_id=cff.fanlidian_id '.
	   'where customers_id='.$_SESSION['customer_id'] . ' order by cf.fanlidian_id ASC , cff.fanli_date DESC';

$r = $db->Execute($sql);
$record_fanli = array();
while (!$r->EOF){
	$record_fanli[$r->fields['fanli_date']][$r->fields['fanlidian_id']] = $r->fields['jinqian']; 
	$r->MoveNext();
}

$breadcrumb->add('Account', zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add('Rebate Detail');
