<?php
$customer_address_entries = sf_get_customers_address_book($_SESSION['customer_id']);
$_SESSION['navigation']->add_current_page();
require $template->get_template_dir('tpl_checkout_shipping_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_checkout_shipping_default.php';