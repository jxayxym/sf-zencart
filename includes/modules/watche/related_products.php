<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}
$related_products_sql = 'SELECT products_id2 as products_id FROM '.TABLE_EXT_RELATED_PRODUCTS.' WHERE products_id1='.(int)$_GET['products_id'];
$related_products_sql .= ' UNION SELECT products_id1 as products_id FROM '.TABLE_EXT_RELATED_PRODUCTS.' WHERE products_id2='.(int)$_GET['products_id'];

$related_products_sql = 'SELECT p.products_id,pd.products_name,p.products_image FROM '.TABLE_PRODUCTS.' p JOIN '.TABLE_PRODUCTS_DESCRIPTION.' pd ON p.products_id=pd.products_id WHERE p.products_id IN('.$related_products_sql.')';

$related_products_list = $db->execute($related_products_sql);
