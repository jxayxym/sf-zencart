<?php
if (zen_not_null($cPath)) {
	$filter_selected = array();
	if (zen_not_null($manufacturers_array)) {
		$parameters = zen_get_all_get_params(array('info', 'x', 'y','page','manufacturers_id'));
		foreach ($manufacturers_array as $entry){
			$temp_manufacturers_array = array_diff($manufacturers_array,array($entry));
			$link = zen_href_link(FILENAME_DEFAULT,$parameters.(zen_not_null($temp_manufacturers_array)?'manufacturers_id='.implode('_',$temp_manufacturers_array):''));
			$filter_selected[] = array(
				'text'=>get_manufacturers_name($entry),
				'link'=>$link	
			);
		}
	}
	
	if (zen_not_null($global_opv_id_array)) {
		$parameters = zen_get_all_get_params(array('info', 'x', 'y','page','options_values_id'));
		foreach ($global_opv_id_array as $entry){
			$temp_options_values_id_array = array_diff($global_opv_id_array,array($entry));
			$link = zen_href_link(FILENAME_DEFAULT,$parameters.(zen_not_null($temp_options_values_id_array)?'options_values_id='.implode('_',$temp_options_values_id_array):''));
			$filter_selected[] = array(
					'text'=>get_option_name($entry),
					'link'=>$link
			);
		}
	}
}