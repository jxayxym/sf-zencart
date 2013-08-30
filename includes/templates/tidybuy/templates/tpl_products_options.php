<?php
$content = '';
if (!empty($options_list)){
	$link_params = zen_get_all_get_params(array('options_values_id','sort'));
	$content .= '<ul id="shopByWrapper">';
	foreach ($options_list as $options_id=>$options_list_entry){
		$content .= '<li class="shopByOption">';
		$content .= '<div class="shopByOptionName">'.$options_list_entry['option_name'].'</div>';
		$content .= '<ul class="shopByOptionValueList">';
		$options_values_id_array = array_keys($options_list_entry['options_values']);
		// 		var_dump($options_values_id_array);exit;
		foreach ($options_list_entry['options_values'] as $value_id=>$options_values_entry){
			if (in_array($value_id , $optons_values_id)){
				$options_values_id_link = array_diff($optons_values_id,array($value_id));
				$class_name = 'selected';
			}elseif (in_array($value_id , $options_values_id_array)){
				$options_values_id_link = array_diff($optons_values_id,$options_values_id_array);
				$options_values_id_link = array_merge($options_values_id_link,array($value_id));

				$class_name = '';
			}else{
				$options_values_id_link = array_merge($optons_values_id,array($value_id));
				$class_name = '';
			}
			if (zen_not_null($options_values_id_link))
				$options_values_id_params = 'options_values_id='.implode('_', $options_values_id_link);
			else
				$options_values_id_params = '';
			// 			echo $link_params.$options_values_id_params.'<br />';exit;
			$content .= '<li class="shopByOptionValue"><a href="'.zen_href_link(FILENAME_DEFAULT,$link_params.$options_values_id_params).'" class="'.$class_name.'">'.$options_values_entry['option_value_name'].'('.$options_values_entry['products_num'].')</a></li>';
		}
		$content .= '</ul>';
		$content .= '</li>';
	}
	$content .= '</ul><br class="clearBoth" />';
}
echo '<fieldset class="shopby">';
echo '<legend>'.$title.'</legend>';
echo $content;
echo '</fieldset>';
?>