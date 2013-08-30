<?php
$content = '';
if (!empty($options)){
	$fn_zen_href_link_parameters1 = zen_get_all_get_params(array('options_values_id','page','info', 'x', 'y'));
	if (isset($_GET['options_values_id']))
		$_GET_options_values_id = array_unique(array_map('zen_string_to_int',explode('_',$_GET['options_values_id'])));
	else 
		$_GET_options_values_id = array();
	$content_group_choosed = '';
	$the_options_values_choosed = array();
	$sql = 'select p.products_id from '.TABLE_PRODUCTS_ATTRIBUTES.' pa1 '.
	       'JOIN '.TABLE_PRODUCTS.' p ON p.products_id=pa1.products_id ';
	$join_cPath = $where_cPath = $join_options = $where_options = $group_options = '';
	if (isset($_GET['cPath'])){
		$join_cPath = 'JOIN '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c ON p2c.products_id=p.products_id '; 
		$join_cPath .= 'JOIN '.TABLE_CATEGORIES.' c ON c.categories_id=p2c.categories_id ';
		$where_cPath = 'AND p2c.categories_id IN('.implode(',',$categories).') AND  c.categories_status=1 ';
	}
	if (isset($_GET['alpha_filter_id'])&&!empty($_GET['alpha_filter_id'])){
		$join_products_description = 'join '.TABLE_PRODUCTS_DESCRIPTION.' pd on pd.products_id=p.products_id ';
		$alpha_sort = " and pd.products_name REGEXP '^" . chr((int)$_GET['alpha_filter_id']) . "' ";
	}else {
		$join_products_description = '';
		$alpha_sort = '';
	}
	$where_options ='AND pa1.options_values_id IN(%s) ';//%s
	$group_options = 'group by p.products_id having count(*)>=%s ';//%s
	
	$sql = 'SELECT count(*) as count from ('.
			$sql.$join_products_description.$join_cPath.$join_options.'WHERE p.products_status=1 '.$where_cPath.$where_options.' and products_date_available<\''.date('Y-m-d 00:00:00').'\''.$alpha_sort.$group_options.
			') as t';
	foreach ($options as $products_options_id=>$products_options_values){
                $option_name = current(current($products_options_values));
		//判断是当前选项是否有被选择
		$content .= '<li id="ShopBy'.zen_parse_input_field_data($option_name,array(' '=>'')).'" class="ShopByAttributes back"><span class="ShopByAttributes-Header">Shop&nbsp;By&nbsp;'.$option_name;
		$num = 0;//每行属性的计数
		
		//判断是当前集合中属性选项是否有被选择
		$intersect = array_intersect(array_keys($products_options_values),$_GET_options_values_id);		
		if (empty($intersect)){
			$products_options_values_id_count = $_GET_options_values_id;
		}else{
			$products_options_values_id_count = array_diff($_GET_options_values_id,$intersect);
		}
		$no_limit = true;
		$no_limit_option_values_id = $products_options_values_id_count;
		$temp_options_values_id_count = array();
		$first_flag = true;
		foreach ($products_options_values as $products_options_values_id=>$option_info){
			if ($first_flag == true ){
				if (empty($intersect))
					$content .= '</span><ul id="ShopBy'.zen_parse_input_field_data($option_name,array(' '=>'')).'-Body" class="ShopByAttributes-Body l-s_n">';		
				else{
					$index = current($intersect);
					$content .= ':&nbsp;<span class="c-gold">'.$products_options_values[$index]['products_options_values_name'].'</span></span><ul id="ShopBy'.zen_parse_input_field_data($option_name,array(' '=>'')).'-Body" class="ShopByAttributes-Body l-s_n">';
				}
				$first_flag = false;
			}
			$temp_options_values_id_count = $products_options_values_id_count;
			$temp_options_values_id_count[] = $products_options_values_id;
			$sql_count = sprintf($sql,implode(',', $temp_options_values_id_count),count($temp_options_values_id_count));
//			echo $sql_count,'<br />';exit;
			$count = $db->Execute($sql_count,false,true);
			if (in_array($products_options_values_id, $_GET_options_values_id)){
				$class = 'class="the_choosed_option"';
			}else{
				$class = '';
			}
//			if ($count->fields['count']>0){
				if ($no_limit){
					if ((empty($intersect)))
						$class_nolimit = 'class="the_choosed_option"';
					else 
						$class_nolimit = '';	
					if (empty($no_limit_option_values_id))
						$content .= '<li '.$class_nolimit.'><a href="'.zen_href_link(FILENAME_DEFAULT,$fn_zen_href_link_parameters1).'">No Limit</a></li>';
					else
						$content .= '<li'.$class_nolimit.'><a href="'.zen_href_link(FILENAME_DEFAULT,$fn_zen_href_link_parameters1.'&options_values_id='.implode('_',$no_limit_option_values_id)).'">No Limit</a></li>';
					$no_limit = false;
				}
                                $attributes_image = empty($option_info['attributes_image'])?'':zen_image(DIR_WS_IMAGES.$option_info['attributes_image'],$option_info['products_options_values_name'],20,20);        
				if (empty($class))
					$content .= '<li><a href="'.zen_href_link(FILENAME_DEFAULT,$fn_zen_href_link_parameters1.'&options_values_id='.implode('_',$temp_options_values_id_count)).'">'.$attributes_image.$option_info['products_options_values_name'].'('.$count->fields['count'].')</a></li>';
				else {
					if (empty($no_limit_option_values_id))
						$href = zen_href_link(FILENAME_DEFAULT,$fn_zen_href_link_parameters1);
					else 
						$href = zen_href_link(FILENAME_DEFAULT,$fn_zen_href_link_parameters1.'&options_values_id='.implode('_',$no_limit_option_values_id));
					$content .= '<li '.$class.'><a href="'.$href.'">'.$attributes_image.$option_info['products_options_values_name'].'('.$count->fields['count'].')</a></li>';
				}
//				$num++;
//			}
		}
		$content .= '</ul></li>';
	}
	$content = '<div id="ShopByWrapper"><ul id="ShopBy" class="l-s_n">'.$content.'</ul></div>';
}
echo $content;