<?php
if (isset($_GET['ajax'])&&$_GET['ajax']==true&&isset($_GET['product_info'])&&$_GET['product_info']==true) {
	if (isset($_GET['options_values_id'])){
		$op_ids = array_map('zen_string_to_int',explode('_', $_GET['options_values_id']));
		$from_option = ',sf_products_attributes pa ';
		$join_option = 'and pa.products_id=p.products_id and pa.options_values_id in('.implode(',', $op_ids).') ';
		$group_by = 'group by p.products_id having count(*)>='.count($op_ids).' ';
	}else 
		$from_option = $join_option = $group_by = '';
		
	if (isset($_GET['alpha_filter_id'])&&!empty($_GET['alpha_filter_id'])){
		$alpha_sort = " and pd.products_name REGEXP '^".chr((int)$_GET['alpha_filter_id']) . "' ";
	}else {
		$alpha_sort = '';
	}			
	$sql = 'select p.products_image, pd.products_name, p.products_id,p.products_type, p.products_price, p.products_tax_class_id from '. 
		   TABLE_PRODUCTS.' p , '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c ,'.TABLE_PRODUCTS_DESCRIPTION.' pd '.$from_option.
		   'where p.products_status = 1 and p.products_id = p2c.products_id '.
		   'and pd.products_id = p2c.products_id and pd.language_id ='.(int)$_SESSION['languages_id'].' '.
		   'and p2c.categories_id IN (%s) '.
		   $join_option.
		   $alpha_sort.
		   $group_by.
		   'order by p.products_sort_order, pd.products_name,p.products_id';
	$sql = 'select * from ('.$sql.') as t';	   
	$c = array_map('zen_string_to_int',explode('_', $_GET['cPath']));	
	if (empty($c)){
		$c = 0;
	}else{
		$c = array_pop($c);
	}
	$p2c_categories_id = array();
	zen_get_subcategories($p2c_categories_id,$c);
	$p2c_categories_id[] = $c;//分类
	$sql = sprintf($sql,implode(',', $p2c_categories_id));
	$r = $db->Execute($sql);
	$r_show = array();
	$row_index = 1;
	while (!$r->EOF){
		if ($r->fields['products_id']==$_GET['products_id'])
			break;
		$row_index++;
		$r->MoveNext();
	}
	$count_sql = 'select count(*) as count from('.$sql.') as t1';
	$r = $db->Execute($count_sql);
	$total = $r->fields['count'];//总数量
	$num_perpage = 8;//每页显示8条
	$page_num = ceil($total/$num_perpage);//总页数
	$cur_page = isset($_GET['ajax_page'])?(int)$_GET['ajax_page']:(ceil($row_index/$num_perpage));//当前页码
	
	$cur_page = $cur_page>$page_num?$page_num:($cur_page<0?1:$cur_page);
	$sql_show = $sql.' limit '.(($cur_page-1)*8).','.$num_perpage;
	$r = $db->Execute($sql_show);
	$data = array();
	
	if (isset($_GET['alpha_filter_id'])&&!empty($_GET['alpha_filter_id'])){
		$params .= '&alpha_filter_id='.$_GET['alpha_filter_id'];
	}
	if (isset($_GET['options_values_id'])){
		$params .= '&options_values_id='.$_GET['options_values_id'];
	}	
	if (isset($_GET['cPath'])){
		$params .= '&cPath='.$_GET['cPath'];	
	}	
	while (!$r->EOF){
		$products_name = array();
		explode_utf8_str($r->fields['products_name'],20,$products_name);
		$products_price = $currencies->display_price((zen_get_products_actual_price($r->fields['products_id'])),0);
		
	    $sale_discount = zen_get_products_save($r->fields['products_id'],1);
	    if ($sale_discount!=''){
	    	$special_flag = '<span class="index_icon-discount-s">'.$sale_discount.'</span>';
	    }else{
	    	$special_flag = '';
	    }		
	    if (!empty($params)) 
	    	$params .= '&';
		$data[] = array(
			'products_id'=>$r->fields['products_id'],
			'products_name'=>$products_name[0].'...',
			'products_price'=>$products_price,
			'products_image'=>DIR_WS_IMAGES.$r->fields['products_image'],
			'href'=>zen_href_link(FILENAME_PRODUCT_INFO,$params.'products_id='.$r->fields['products_id']),
			'special_flag'=>$special_flag,
		);
		$r->MoveNext();
	}	
//	$loop = 0;
//	while ($loop<3){
//		sleep(1);
//		$loop++;
//	}
	echo json_encode($data);
	exit;
}
?>
