<?php
$sql = "select categories_id from ".TABLE_CATEGORIES.' where parent_id=0 and categories_status=1';
$top_categories = $db->Execute($sql);

$subcategories = array();
while (!$top_categories->EOF){
	$subcategories[$top_categories->fields['categories_id']] = array(); 
	zen_get_subcategories($subcategories[$top_categories->fields['categories_id']],$top_categories->fields['categories_id']);
	$subcategories[$top_categories->fields['categories_id']][] = $top_categories->fields['categories_id'];
	$top_categories->MoveNext();
}

$products_by_categories = array();

foreach ($subcategories as $top_categories_id=>$subcategories_id){
	$sql = 'select p.products_id,pd.products_name,p.products_image from '.TABLE_PRODUCTS.' p join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p.products_id=p2c.products_id '.
		   'join '.TABLE_PRODUCTS_DESCRIPTION.' pd on pd.products_id=p.products_id '.	
		   'where p2c.categories_id IN('.implode(',', $subcategories_id).') and p.products_status=1 '.
		   'order by p.products_sort_order DESC,p.products_id ASC '.
		   'limit 0,4';
	$r_products = $db->Execute($sql);
	while (!$r_products->EOF){
		$products_by_categories[$top_categories_id][] = array(
			'products_id'=>$r_products->fields['products_id'],	
			'products_name'=>$r_products->fields['products_name'],
			'products_image'=>$r_products->fields['products_image'],
		);
		$r_products->MoveNext();
	}
}