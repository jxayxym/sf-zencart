<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Tue Aug 14 14:56:11 2012 +0100 Modified in v1.5.1 $
 */
?>

<?php
  // Display all header alerts via messageStack:
  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
  echo htmlspecialchars(urldecode($_GET['error_message']), ENT_COMPAT, CHARSET, TRUE);
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo htmlspecialchars($_GET['info_message'], ENT_COMPAT, CHARSET, TRUE);
} else {

}
?>


<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>

<div id="headerWrapper">
<div id="navTopWrapper">
	<ul id="navTop" class="layout_site_width">
		<li id="navCurrencyWrapper" class="back">
			<div><label>Currency:</label><span class="current_currency"><?php echo $_SESSION['currency'] ?></span></div>
			<div class="arrow-s"></div>
			<ul id="currencyList">
			<?php 
			  reset($currencies->currencies);
			  ksort($currencies->currencies);
			  $parameters = zen_get_all_get_params(array('info', 'x', 'y'));
			  $i = 1;
			  while (list($key, $value) = each($currencies->currencies)) {
				if ($key==$_SESSION['currency'])
					echo '<li class="back currencyItem">'.$value['title'].'</li>';
				else
					echo'<li class="back currencyItem"><a href="'.zen_href_link($_GET['main_page'],'currency='.$key.'&'.$parameters).'"'.'>'.$value['title'].'</a></li>';
				if (($i++)%3==0) echo '<li class="clearBoth"></li>';
			  }
			?>
			</ul>
		<li>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_FAQ) ?>">Help</a></li>
		<?php 
		if($_SESSION['customer_id']==''){
		?>
		<li class="forward p-r"><a href="<?php echo zen_href_link(FILENAME_LOGIN) ?>">Join/Sign In</a><div class="promote_register"></div></li>
		<?php
		}else{
		?>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_LOGOFF) ?>">Sign Out</a></li>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT) ?>">My Account</a></li>
		<?php
		}
		?>
		<li class="forward">Welcome to <?php echo preg_replace('/http:\/\/(www.)?/', '', HTTP_SERVER)?></li>
	</ul>
</div>

<!--bof-branding display-->
<div id="logoWrapper" class="layout_site_width">
    <div id="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</a>'; ?></div>
	<div id="navMainSearch"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
	<div id="pay_head" class="back"></div>
	<div id="shipping_head" class="back"></div>
	<div id="headerShoppingCart" class="back"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>">Shopping<br />Cart(<?php echo $_SESSION['cart']->count_contents()==0?'empty':$_SESSION['cart']->count_contents() ?>)</a></div>
</div>
<br class="clearBoth" />
<!--eof-branding display-->

<?php if (HEADER_SALES_TEXT != '' || (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2))) { ?>
    <div id="taglineWrapper" class="layout_site_width">
<?php
              if (HEADER_SALES_TEXT != '') {
?>
      <div id="tagline"><?php echo HEADER_SALES_TEXT;?></div>
<?php
              }
?>
<?php
              if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
                if ($banner->RecordCount() > 0) {
?>
      <div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner);?></div>
<?php
                }
              }
?>
    </div>
<?php } // no HEADER_SALES_TEXT or SHOW_BANNERS_GROUP_SET2 ?>


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