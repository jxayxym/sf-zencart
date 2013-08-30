<?php
// the following IF statement can be duplicated/modified as needed to set additional flags
  if (in_array($current_page_base,explode(",",'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces')) ) {
    $flag_disable_right = true;
  }

  $header_template = 'tpl_header.php';
  $footer_template = 'tpl_footer.php';
  $left_column_file = 'column_left.php';
  $right_column_file = 'column_right.php';
  $body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
?>
<body id="<?php echo $body_id . 'Body'; ?>"<?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?>>
<?php
  if (SHOW_BANNERS_GROUP_SET1 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET1)) {
    if ($banner->RecordCount() > 0) {
?>
<div id="bannerOne" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
    }
  }
?>

<div id="mainWrapper">
<?php
require($template->get_template_dir('tpl_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header.php');
?>
<?php
  if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
    if ($banner->RecordCount() > 0) {
?>
<div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
    }
  }
?>
<div class="<?php echo $body_id . 'MainContent'; ?>">
<?php 
if ($this_is_home_page) {
	echo '<div class="homePageBg"></div>';
}?>
<div class="layout-center1000">
<noscript><div class="noscript"><p><strong>JavaScript seems to be disabled in your browser.</strong><br />You must have JavaScript enabled in your browser to utilize the functionality of this website.</p></div></noscript>
	<div id="contentMainWrapper" <?php if (!$this_is_home_page) echo 'class="bk_white"';?>>
		<!-- bof  breadcrumb -->
		<?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page) ) { ?>
		<div id="navBreadCrumb"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
		<?php } ?>
		<!-- eof breadcrumb -->	
		<?php require(DIR_WS_MODULES . $template_dir . '/left_sidebox_show.php');?>
		<div id="<?php echo $body_id . 'Content'; ?>" class="contentMain">
			<?php require($body_code); ?>
		</div>
		<br class="clearBoth" />
	</div>
</div>
</div>
<?php 
require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');
?> 
<!--bof- banner #6 display -->
<?php
  if (SHOW_BANNERS_GROUP_SET6 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET6)) {
    if ($banner->RecordCount() > 0) {
?>
<div id="bannerSix" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
    }
  }
?>

</div>

</body>