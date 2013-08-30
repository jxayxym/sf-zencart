<?php
if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
$action = $_GET['action'];
switch ($action){
	case 'confirm_receive':
		$sql = 'update ' . TABLE_FANLI_TIXIAN .' set status=1000 where status=100 and fanli_tixian_id=\''.(int)$_GET['tixian_id'].'\'';
		$db->Execute($sql);
		break;
}

$sql = 'select * from ' . TABLE_FANLI_TIXIAN . ' where customers_id='.$_SESSION['customer_id'] .' order by status ASC,add_time ASC'; 
$result_withdrawed = $db->Execute($sql);

$breadcrumb->add('Account', zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add('Withdrawed');