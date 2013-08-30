<?php
if ($_GET['main_page']=='index'){
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
$option_name_to_shop_by = array(9);
if (zen_not_null($option_name_to_shop_by)){
	$where_can_shop_by = ' and products_options_id in('.implode(',',$option_name_to_shop_by).') ';
}else 
	$where_can_shop_by = '';


if (isset($_GET['options_values_id'])){
	$optons_values_id = explode('_',$_GET['options_values_id']);
	$sql_products = 'select p.products_id from '.TABLE_PRODUCTS.' p join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p.products_id=p2c.products_id '.
			'join '.TABLE_CATEGORIES.' c on c.categories_id=p2c.categories_id join '.TABLE_PRODUCTS_ATTRIBUTES.' pa on pa.products_id=p.products_id ';
			
// 	$sql_products = $sql_products .'where p2c.categories_id in('.implode(',',$categories).') and pa.options_values_id IN('.implode(',', $optons_values_id).') union '.
	$sql_products = $sql_products .'where p2c.categories_id in('.implode(',',$categories).') and pa.options_id in (select products_options_id from '.TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS.' where products_options_values_id IN('.implode(',', $optons_values_id).')'.$where_can_shop_by.')';

	$where_products_in = 'and p.products_id in ('.$sql_products.')';
}else{
	$optons_values_id = array();
	$sql_products = 'select p.products_id from '.TABLE_PRODUCTS.' p join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p2c.products_id=p.products_id where p2c.categories_id in('.implode(',',$categories).')';
	$where_products_in = 'and p.products_id in ('.$sql_products.')';
}

$sql = 'select pa.options_id,po.products_options_name,pa.options_values_id,pov.products_options_values_name from ('.$sql_products.') as t '.
"join ".TABLE_PRODUCTS_ATTRIBUTES." pa on pa.products_id=t.products_id ".
'join '.TABLE_PRODUCTS_OPTIONS.' po on po.products_options_id=pa.options_id '.
'join '.TABLE_PRODUCTS_OPTIONS_VALUES.' pov on pov.products_options_values_id=pa.options_values_id ';
if (zen_not_null($where_can_shop_by))
	$sql .= $where_can_shop_by;
$sql .='group by options_values_id';
	
$options_list = array();
if (isset($_GET['options_values_id'])){
	$sql_options = 'select products_options_id,products_options_values_id from '.TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS.' where products_options_values_id IN('.implode(',', $optons_values_id).')';
	$r = $db->Execute($sql_options);
	$current_options_to_values = array();
	while (!$r->EOF){
		$current_options_to_values[$r->fields['products_options_id']][$r->fields['products_options_values_id']] = $r->fields['products_options_values_id'];
		$r->MoveNext();
	}
	$sql_count = 'select count(*) as products_num from (select pa.products_id from '.TABLE_PRODUCTS_ATTRIBUTES.' pa join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p2c.products_id=pa.products_id where options_values_id in(%s) and p2c.categories_id in('.implode(',',$categories).') group by pa.products_id having count(*)>=%s) as t';
}else{
	$current_options_to_values = array();
	$sql_count = 'select count(*) as products_num from '.TABLE_PRODUCTS_ATTRIBUTES.' pa join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p2c.products_id=pa.products_id where options_values_id=%s and p2c.categories_id in ('.implode(',',$categories).')';
}	

$r = $db->Execute($sql);
	if ($r->RecordCount()>0){
		while (!$r->EOF){
			if (isset($current_options_to_values[$r->fields['options_id']]) && isset($current_options_to_values[$r->fields['options_id']][$r->fields['options_values_id']])){
					$_sql_count = sprintf($sql_count,implode(',',$optons_values_id),count($optons_values_id));
			}elseif (isset($current_options_to_values[$r->fields['options_id']]) && !isset($current_options_to_values[$r->fields['options_id']][$r->fields['options_values_id']])){
				$_optins_values_id = current($current_options_to_values[$r->fields['options_id']]);
				$count_option_values_id = array_diff($optons_values_id, array($_optins_values_id));
				$count_option_values_id[] = $r->fields['options_values_id'];
				$_sql_count = sprintf($sql_count,implode(',',$count_option_values_id),count($count_option_values_id));
			}else{
				$count_option_values_id = array_merge($optons_values_id,array($r->fields['options_values_id']));
				$_sql_count = sprintf($sql_count,implode(',',$count_option_values_id),count($count_option_values_id));
			}
			$r_products_num = $db->Execute($_sql_count);
			if ($r_products_num->fields['products_num']>0){
				if (!isset($options_list[$r->fields['options_id']])){
					$options_list[$r->fields['options_id']] = array('option_name'=>$r->fields['products_options_name'],'options_values'=>array());
				}	
				$options_list[$r->fields['options_id']]['options_values'][$r->fields['options_values_id']] =
				array(
						'option_value_name'=>$r->fields['products_options_values_name'],
						'option_value_id'=>$r->fields['options_values_id'],
						'products_num'=>$r_products_num->fields['products_num'],
						// 				'link'=>zen_href_link(FILENAME_DEFAULT,$link_params.'options_values_id='.implode('_', $options_values_id_link)),
				);							
			}

			$r->MoveNext();
		}
		$title = 'Shop By';
		if (isset($_GET['options_values_id'])){
			$title .= '<a class="shopByClearAll" href="'.zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('options_values_id','sort'))).'">-Clear All</a>';
		}
		$link = false;
		require($template->get_template_dir('tpl_products_options.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_options.php');
	}
}	