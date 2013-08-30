<?php
$sql = 'select po.products_options_id,po.products_options_name,pov.products_options_values_id,pov.products_options_values_name from '.TABLE_PRODUCTS_OPTIONS.' po join '.TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS.' po2pov on po2pov.products_options_id=po.products_options_id '.
		'join '.TABLE_PRODUCTS_OPTIONS_VALUES.' pov on pov.products_options_values_id=po2pov.products_options_values_id where po.language_id='.(int)$_SESSION['languages_id'].' and pov.language_id='.(int)$_SESSION['languages_id'].' order by po.products_options_sort_order ASC,pov.products_options_values_sort_order ASC';
$r = $db->Execute($sql);
$attributes_tabs = array();
while (!$r->EOF){
	$attributes_tabs[$r->fields['products_options_id']]['text'] = $r->fields['products_options_name'];
	$attributes_tabs[$r->fields['products_options_id']]['children'][$r->fields['products_options_values_id']] = array(
		'value_name'=>$r->fields['products_options_values_name']
	);
	$r->MoveNext();
}