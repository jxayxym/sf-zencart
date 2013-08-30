<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

if (isset($_GET['manufacturers_id']) && preg_match('/\d(_\d)?/',$_GET['manufacturers_id'])) {
  $manufacturers_params = $_GET['manufacturers_id'];
  $manufacturers_array = explode('_', $manufacturers_params);
}else{
	$manufacturers_params = '';
	$manufacturers_array = array();
}
