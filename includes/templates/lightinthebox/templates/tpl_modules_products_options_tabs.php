<?php
include(DIR_WS_MODULES . zen_get_module_directory('products_options_tabs.php'));
if (zen_not_null($attributes_tabs)) {
	echo '<ul id="attributes_tabs">';
	foreach ($attributes_tabs as $options_id=>$attributes_entry){
		echo '<li class="tabs_optons_name">'.$attributes_entry['text'];
		echo '<ul>';
		foreach ($attributes_entry['children'] as $options_values){
			echo '<li>'.$options_values['value_name'].'</li>';
		}
		echo '</ul>';
		echo '</li>';
	}
	echo '</ul>';
}
exit;