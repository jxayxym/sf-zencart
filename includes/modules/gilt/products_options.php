<?php
$categories = array();
if (empty($_GET['cPath']))
	$cur_category = 0;
else
	$cur_category = array_pop(explode('_', $_GET['cPath']));
zen_get_subcategories($categories,$cur_category);
$categories[] = $cur_category;//分类
if (isset($_GET['alpha_filter_id'])&&!empty($_GET['alpha_filter_id'])){
	$join_products_description = 'join '.TABLE_PRODUCTS_DESCRIPTION.' pd on pd.products_id=p.products_id ';
	$alpha_sort = " and pd.products_name LIKE '" . chr((int)$_GET['alpha_filter_id']) . "%' ";
}else {
	$join_products_description = '';
	$alpha_sort = '';
}	
$sql = "select distinct(products_options_values_id),products_options_id,products_options_name,products_options_values_name,products_options_types_name,attributes_image from (".
	   "select po.products_options_id,po.products_options_name,pov.products_options_values_id,pov.products_options_values_name,pot.products_options_types_name,pa.attributes_image from " . TABLE_PRODUCTS_OPTIONS . " po " . 
	   "join ". TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS." pov_po on pov_po.products_options_id=po.products_options_id ".
	   "join ". TABLE_PRODUCTS_OPTIONS_VALUES." pov on pov.products_options_values_id=pov_po.products_options_values_id ".
	   "join ". TABLE_PRODUCTS_OPTIONS_TYPES." pot on pot.products_options_types_id=po.products_options_type ".
	   "join ".TABLE_PRODUCTS_ATTRIBUTES." pa ON pa.options_values_id=pov.products_options_values_id ".
	   "join ".TABLE_PRODUCTS." p on p.products_id=pa.products_id ".
	   $join_products_description.' '.
	   "join ".TABLE_PRODUCTS_TO_CATEGORIES." p2c on p2c.products_id=p.products_id ".	
	   "where pot.products_options_types_name IN('Dropdown','Radio','Checkbox','下拉','单选','多选') and po.language_id=".(int)$_SESSION['languages_id']." ".
	   "and pov.language_id=".(int)$_SESSION['languages_id']." ".
	   "and p2c.categories_id IN(".implode(',',$categories).") and products_date_available<'".date('Y-m-d 00:00:00')."' ".
	   $alpha_sort.' '.
	   "order by po.products_options_sort_order ASC,po.products_options_id ASC,pov.products_options_values_sort_order) as t";
//echo $sql;
$r = $db->Execute($sql);
$options = array();
if ($r->RecordCount()>0){
	while (!$r->EOF){
		$options[$r->fields['products_options_id']][$r->fields['products_options_values_id']] = array(
                    'products_options_name'=>$r->fields['products_options_name'],
                    'products_options_values_name'=>$r->fields['products_options_values_name'],
                    'products_options_types_name'=>$r->fields['products_options_types_name'],
                    'attributes_image'=>$r->fields['attributes_image'],
                        );
		$r->MoveNext();
	}
}
require $template->get_template_dir('tpl_module_products_options.php', DIR_WS_TEMPLATE, $current_page_base,'templates') . '/tpl_module_products_options.php';
