<?php
$title = BOX_HEADING_PRICE_RANGE;
$box_id = 'pricerange';
require($template->get_template_dir('tpl_price_range.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_price_range.php');
require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);