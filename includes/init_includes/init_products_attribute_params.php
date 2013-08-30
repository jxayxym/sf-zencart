<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

if (zen_not_null($_GET['options_values_id']) && preg_match('/\d(_\d)?/',$_GET['options_values_id'])) {
	$global_opv_id_params = $_GET['options_values_id'];
	$global_opv_id_array = explode('_', $global_opv_id_params);
}else{
	$global_opv_id_params = '';
	$global_opv_id_array = array();
}