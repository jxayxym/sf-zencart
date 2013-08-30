<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_REBATE_INTRODUCTION, 'false');

if ($_SESSION['customer_id']!='')
	$breadcrumb->add('Account',zen_href_link(FILENAME_ACCOUNT));
$breadcrumb->add(NAVBAR_TITLE);