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
if (isset($_GET['options_values_id']) && preg_match('/\d(_\d)*/',$_GET['options_values_id'])){
	$optons_values_id = explode('_',$_GET['options_values_id']);
	$where_options_value .= ' and pa.options_values_id in('.implode(',',$optons_values_id).') group by p.products_id having count(*)>='.count($optons_values_id);
}else{
	$optons_values_id = array();
}

$sql_products = 'select distinct p.products_id from '.TABLE_PRODUCTS.' p join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p.products_id=p2c.products_id '.
		'join '.TABLE_CATEGORIES.' c on c.categories_id=p2c.categories_id join '.TABLE_PRODUCTS_ATTRIBUTES.' pa on pa.products_id=p.products_id '.
		'where p2c.categories_id in('.implode(',',$categories).') and p.products_status=1 ';

if ((zen_not_null($_GET['amountfrom']) && preg_match('/^[0-9]+$/',$_GET['amountfrom'])) ||
(zen_not_null($_GET['amountto'])   && preg_match('/^[0-9]+$/',$_GET['amountto']))
) {
	if (zen_not_null($_GET['amountfrom'])){
		$amountfrom = $currencies->value($_GET['amountfrom'],true,'USD');
		$sql_products .= ' and p.products_price>='.$amountfrom;
	}

	if (zen_not_null($_GET['amountto'])){
		$amountto = $currencies->value($_GET['amountto'],true,'USD');
		$sql_products .= ' and p.products_price<='.$amountto;
	}
}

if (zen_not_null($manufacturers_array)){
	$sql_products .= ' and p.manufacturers_id IN('.implode(',',$manufacturers_array).')';
}

if (isset($where_options_value) && zen_not_null($where_options_value)){
	$sql_products .= $where_options_value;
}



$r = $db->Execute($sql_products,false,false,604800);//缓存7天
if ($r->RecordCount()>0){
	$in_products_id = '0';
	$sql = 'select p.products_id,pa.options_id,po.products_options_name,pa.options_values_id,pov.products_options_values_name,count(options_values_id) as products_num from '.TABLE_PRODUCTS_ATTRIBUTES.' pa '.
	'join '.TABLE_PRODUCTS_OPTIONS.' po on po.products_options_id=pa.options_id '.
	'join '.TABLE_PRODUCTS_OPTIONS_VALUES.' pov on pov.products_options_values_id=pa.options_values_id '.
	'join '.TABLE_PRODUCTS.' p on p.products_id=pa.products_id '.
	'join ('.$sql_products.') t on t.products_id=pa.products_id '.
	'where products_options_type!=1 group by pa.options_values_id';

	$r = $db->Execute($sql,false,false,604800);//缓存7天
	if ($r->RecordCount()>0){
		while (!$r->EOF){
			if (!isset($options_list[$r->fields['options_id']])){
				$options_list[$r->fields['options_id']] = array('option_name'=>$r->fields['products_options_name'],'options_values'=>array());
			}	
			$options_list[$r->fields['options_id']]['options_values'][$r->fields['options_values_id']] =
			array(
					'option_value_name'=>$r->fields['products_options_values_name'],
					'option_value_id'=>$r->fields['options_values_id'],
					'products_num'=>$r->fields['products_num'],
// 					'link'=>zen_href_link(FILENAME_DEFAULT,$link_params.'options_values_id='.implode('_', $options_values_id_link)),
			);							

			$r->MoveNext();
		}
		$title = 'Shop By';
// 		if (isset($_GET['options_values_id'])){
// 			$title .= '<a class="shopByClearAll" href="'.zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('options_values_id','sort'))).'">Clear All</a>';
// 		}
		$link = false;
		$box_id = 'shopbySidebox';
		include($template->get_template_dir('tpl_products_options.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_products_options.php');
		require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);	
	}
}