<?php
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
if (isset ( $_GET ['sort'] ) && strlen ( $_GET ['sort'] ) > 3) {
	$_GET ['sort'] = substr ( $_GET ['sort'], 0, 3 );
}

if (! isset ( $select_column_list ))
	$select_column_list = "";

if (isset ( $_GET ['options_values_id'] )) {
	$options_values_id = explode ( '_', $_GET ['options_values_id'] );
	$join_products_attributes = ',' . TABLE_PRODUCTS_ATTRIBUTES . ' pa ';
	$where_products_attributes = ' and pa.products_id=p.products_id and pa.options_values_id in (' . implode ( ',', $options_values_id ) . ') group by p.products_id having count(*)>=' . count ( $options_values_id );
} else {
	$join_products_attributes = '';
	$where_products_attributes = ' ';
}

$current_category_and_sub_category = array ();
zen_get_subcategories ( $current_category_and_sub_category, $current_category_id ); // 获得当前分类及其子类
$current_category_and_sub_category [] = $current_category_id; // 分类

$listing_sql = "select distinct p.products_id as products_id," . $select_column_list . " p.products_type, p.master_categories_id, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status =1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status
       from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c left join " . TABLE_SPECIALS . " s on p2c.products_id = s.products_id " . $join_products_attributes . "where p.products_status = 1
         and p.products_id = p2c.products_id
         and pd.products_id = p2c.products_id
         and pd.language_id = '" . ( int ) $_SESSION ['languages_id'] . "'
         and p2c.categories_id in (" . implode ( ',', $current_category_and_sub_category ) . ")" . $where_products_attributes;

if ((zen_not_null ( $_GET ['amountfrom'] ) && preg_match ( '/^[0-9]+$/', $_GET ['amountfrom'] )) || (zen_not_null ( $_GET ['amountto'] ) && preg_match ( '/^[0-9]+$/', $_GET ['amountto'] ))) {
	if (zen_not_null ( $_GET ['amountfrom'] )) {
		$amountfrom = $currencies->value ( $_GET ['amountfrom'], true, 'USD' );
		$listing_sql .= ' and p.products_price>=' . $amountfrom;
	}
	
	if (zen_not_null ( $_GET ['amountto'] )) {
		$amountto = $currencies->value ( $_GET ['amountto'], true, 'USD' );
		$listing_sql .= ' and p.products_price<=' . $amountto;
	}
}

if (zen_not_null ( $manufacturers_array )) {
	$listing_sql .= ' and p.manufacturers_id IN(' . implode ( ',', $manufacturers_array ) . ') ';
}
// set the default sort order setting from the Admin when not defined by customer
if (! isset ( $_GET ['sort'] ) and PRODUCT_LISTING_DEFAULT_SORT_ORDER != '') {
	$_GET ['sort'] = PRODUCT_LISTING_DEFAULT_SORT_ORDER;
}
if (isset ( $sort_list )) {
	if (preg_match('/^([0-2])([ad])$/', $_GET ['sort'],$match)) {
		$sort_field = $sort_list['sort_data'][$match[1]]['field'];
		$sort_type  = $match['2']=='a'?'ASC':'DESC';
	}else{
		$_GET ['sort'] = key($sort_list['sort_selection']);
		$sort_field = $sort_list['sort_default']['field'];
		$sort_type  = 'DESC';
	}
	$listing_sql .= ' order by '.$sort_field.' '.$sort_type;
}
