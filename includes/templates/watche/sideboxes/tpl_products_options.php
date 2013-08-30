<?php 
$content = '';
if (!empty($options_list)){
	$link_params = zen_get_all_get_params(array('options_values_id','sort'));
	$content .= '<ul id="shopByWrapper">';
	foreach ($options_list as $options_id=>$options_list_entry){
		$content .= '<li class="shopByOption">';
		$content .= '<div class="shopByOptionName">'.$options_list_entry['option_name'].'</div>';
		
		$options_values_id_array = array_keys($options_list_entry['options_values']);
		
		$html_options_list = '';
		$selected = false;
		foreach ($options_list_entry['options_values'] as $value_id=>$options_values_entry){
			if (in_array($value_id , $optons_values_id)){
				$options_values_id_link = array_diff($optons_values_id,array($value_id));
				$class_name = 'selected';
				$selected = true;
			}else{
				$options_values_id_link = array_merge($optons_values_id,array($value_id));
				$class_name = '';
			}
			
			if (zen_not_null($options_values_id_link))
				$options_values_id_params = 'options_values_id='.implode('_', $options_values_id_link);
			else
				$options_values_id_params = '';
			$html_options_list .= '<li class="shopByOptionValue"><a href="'.zen_href_link(FILENAME_DEFAULT,$link_params.$options_values_id_params).'" class="'.$class_name.'">'.$options_values_entry['option_value_name'].'('.$options_values_entry['products_num'].')</a></li>';
		}
		$content .= '<ul class="shopByOptionValueList'.($selected?' show':' hide').'">';
		$content .= $html_options_list;
		$content .= '</ul>';
		$content .= '</li>';
	}
	$content .= '</ul>';
}
?>