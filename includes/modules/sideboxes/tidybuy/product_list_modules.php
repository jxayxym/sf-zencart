<?php
$column_box_default = 'tpl_box_default_left.php';
if (zen_not_null($cPath)) {
	require DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/manufacturers.php';
}
require DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/categories.php';
require DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/price_range.php';
require DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/recently_viewed.php';
require DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/products_options.php';