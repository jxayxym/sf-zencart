<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$sql = 'SELECT o_p.products_id,pd.products_name,p.products_image,count(o_p.products_id) as saled_num FROM '.TABLE_ORDERS_PRODUCTS.' o_p '.
		'JOIN '.TABLE_PRODUCTS.' p ON p.products_id=o_p.products_id '.
		'JOIN '.TABLE_ORDERS.' o ON o.orders_id=o_p.orders_id '.
		'JOIN '.TABLE_PRODUCTS_DESCRIPTION.' pd ON pd.products_id=p.products_id '.
		'GROUP BY o_p.products_id ORDER BY saled_num DESC,o.date_purchased';
//echo $sql;
$list_recently_puchased = $db->Execute($sql,100);	
?>