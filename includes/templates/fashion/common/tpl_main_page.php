<?php
// the following IF statement can be duplicated/modified as needed to set additional flags
if (in_array ( $current_page_base, explode ( ",", 'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces' ) )) {
	$flag_disable_right = true;
}

$header_template = 'tpl_header.php';
$footer_template = 'tpl_footer.php';
$left_column_file = 'column_left.php';
$right_column_file = 'column_right.php';
$body_id = ($this_is_home_page) ? 'indexHome' : str_replace ( '_', '', $_GET ['main_page'] );
?>
<body id="<?php echo $body_id . 'Body'; ?>"<?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?>>
<?php
if (SHOW_BANNERS_GROUP_SET1 != '' && $banner = zen_banner_exists ( 'dynamic', SHOW_BANNERS_GROUP_SET1 )) {
	if ($banner->RecordCount () > 0) {
		?>
<div id="bannerOne" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
	}
}
?>
<div id="mainWrapper">
<div id="hd">
<?php
if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION ['customers_authorization'] != 0 or $_SESSION ['customer_id'] == '')) {
	$flag_disable_header = true;
}
require($template->get_template_dir('tpl_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header.php');
?>
</div>
<div class="yui3-g">
</div>
<div id="ft"></div>
</div>
<!--bof- banner #6 display -->
<?php
if (SHOW_BANNERS_GROUP_SET6 != '' && $banner = zen_banner_exists ( 'dynamic', SHOW_BANNERS_GROUP_SET6 )) {
	if ($banner->RecordCount () > 0) {
		?>
<div id="bannerSix" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
	}
}
?>
<!--eof- banner #6 display -->
</body>