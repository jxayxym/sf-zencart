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
<div id="headerTopDecoration"></div>

<!--bof-branding display-->
<div id="logoWrapper" class="layout_width">
    <div id="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT,HEADER_LOGO_WIDTH,HEADER_LOGO_HEIGHT) . '</a>'; ?></div>
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
              if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
                if ($banner->RecordCount() > 0) {
?>
      <div id="bannerTwo" class="banners back"><?php echo zen_display_banner('static', $banner);?></div>
<?php
                }
              }
?>
    </div>
<?php } // no HEADER_SALES_TEXT or SHOW_BANNERS_GROUP_SET2 ?>
<img src="<?php echo DIR_WS_IMAGES.'banners/free-shipping.png'?>" width="256px" alt="free shipping">
<ul class="join_sign_in">
<?php 
if($_SESSION['customer_id']==''){
?>
<li><a href="<?php echo zen_href_link(FILENAME_LOGIN) ?>"><?php echo HEADER_TITLE_LOGIN_REGISTER?></a></li>
<?php
}else{
?>
<li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT);?>"><?php echo HEADER_TITLE_MY_ACCOUNT ?></a></li>
<li><a href="<?php echo zen_href_link(FILENAME_LOGOFF);?>"><?php echo HEADER_TITLE_LOGOFF ?></a></li>
<?php	
}
?>
<li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>"><?php echo HEADER_TITLE_CONTACT_US?></a></li>
</ul>
<br class="clearBoth" />
<!--eof-branding display-->

<!--eof-header logo and navigation display-->

<div id="navMainWrapper" class="layout_width">
	<div class="allCates">
	<div class="allCatesLabel"><?php echo HEADER_SHOP_ALL_CATEGORIES?><span></span></div>
	<!--bof-optional categories tabs navigation display-->
	<?php require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
	<!--eof-optional categories tabs navigation display-->	
	</div>
	<div id="navMainSearch"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
	<div id="navCart">
		<div class="navCart"><span id="cartCount"><?php echo $_SESSION['cart']->count_contents()?></span><span id="cartText"><?php echo HEADER_TITLE_MY_CART?>&nbsp;&nbsp;▼</span></div>
		<div id="cartInfo">
		<?php 
		if ($_SESSION['cart']->count_contents()==0) {
			echo '<p>'.TEXT_EMPTY_CART.'</p>';
		}else{
			echo '<ul class="l-s_n">';
			foreach ($_SESSION['cart']->contents as $pid=>$qty){
				$products_info = get_product_info($pid);
				echo '<li><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$pid).'" class="clearBoth"><img src="'.DIR_WS_IMAGES.$products_info['products_image'].'" width="50px"/>'.zen_trunc_string($products_info['products_name'],40).'</a></li>';
			}
			echo '<li class="cartTotal">Cart Total&nbsp;:&nbsp;'.$_SESSION['cart']->show_total().'&nbsp;'.$_SESSION['currency'].'<a href="'.zen_href_link(FILENAME_SHOPPING_CART).'"><span class="cssButton">'.HEADER_TITLE_CHECKOUT.'</span></a></li>';
			echo '</ul>';
		}
		?>
		</div>
	</div>
</div>
</div>
<?php } ?>