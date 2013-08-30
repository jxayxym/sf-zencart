<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PAYMENT_METHODS, 'false');

$breadcrumb->add(NAVBAR_TITLE);