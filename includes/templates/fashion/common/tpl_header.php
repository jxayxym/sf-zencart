<?php
// Display all header alerts via messageStack:
if ($messageStack->size ( 'header' ) > 0) {
	echo $messageStack->output ( 'header' );
}
if (isset ( $_GET ['error_message'] ) && zen_not_null ( $_GET ['error_message'] )) {
	echo htmlspecialchars ( urldecode ( $_GET ['error_message'] ), ENT_COMPAT, CHARSET, TRUE );
}
if (isset ( $_GET ['info_message'] ) && zen_not_null ( $_GET ['info_message'] )) {
	echo htmlspecialchars ( $_GET ['info_message'], ENT_COMPAT, CHARSET, TRUE );
} else {
}
?>
<!--bof-header logo and navigation display-->
<?php
if (! isset ( $flag_disable_header ) || ! $flag_disable_header) {
	?>

<div id="headerWrapper">
	<div id="topheader">
		<div id="welcomeText"><?php echo sprintf(HEADER_WELCOM_TEXT,strtr(HTTP_SERVER,array('http://'=>'','https://'=>'','www.'=>'')));?></div>
		<div id="currency-selector" class="yui3-menu yui3-menu-horizontal yui3-menubuttonnav">
			<div class="yui3-menu-content">
				<ul>
					<li><a href="#" class="yui3-menu-label"><?php echo $_SESSION['currency'] ?>▼</a>
						<div class="yui3-menu">
							<div class="yui3-menu-content">
							<ul>
							<?php
							reset ( $currencies->currencies );
							$parameters = zen_get_all_get_params ( array ('info','x','y') );
							$i = 1;
							while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
								if ($key == $_SESSION ['currency']) continue;
								echo '<li class="currencyItem"><a href="' . zen_href_link ( $_GET ['main_page'], 'currency=' . $key . '&' . $parameters ) . '"' . '><img src="'.DIR_WS_IMAGES.'flags/'.$key.'.png" alt="'.$value ['title'].'">' . $value ['title'] . '</a></li>';
							}
							?>
							</ul>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!--bof-branding display-->
	<div id="logoWrapper">
		<div id="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</a>'; ?></div>
<?php if (HEADER_SALES_TEXT != '' || (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2))) { ?>
    <div id="taglineWrapper">
<?php
		if (HEADER_SALES_TEXT != '') {
			?>
      <div id="tagline"><?php echo HEADER_SALES_TEXT;?></div>
<?php
		}
		?>
<?php

		if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists ( 'dynamic', SHOW_BANNERS_GROUP_SET2 )) {
			if ($banner->RecordCount () > 0) {
				?>
      <div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner);?></div>
<?php
			}
		}
		?>
    </div>
<?php } // no HEADER_SALES_TEXT or SHOW_BANNERS_GROUP_SET2 ?>
</div>
	<br class="clearBoth" />
	<!--eof-branding display-->

	<!--eof-header logo and navigation display-->

	<!--bof-optional categories tabs navigation display-->
<?php require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
<!--eof-optional categories tabs navigation display-->

	<!--bof-header ezpage links-->
<?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
<?php require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
<?php } ?>
<!--eof-header ezpage links-->
</div>
<?php } ?>
<script type="text/javascript">
YUI().use('node-menunav', function(Y) {

    //  Retrieve the Node instance representing the root menu
    //  (<div id="productsandservices">) and call the "plug" method
    //  passing in a reference to the MenuNav Node Plugin.

    var menu = Y.one("#currency-selector");

    menu.plug(Y.Plugin.NodeMenuNav);

});
</script>