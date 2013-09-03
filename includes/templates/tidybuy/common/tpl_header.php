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

<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>
<div id="headerWrapper">
<div class="headerBackground">
<div id="navTopWrapper">
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
	<ul id="navTop" class="layout_site_width">
		<li id="navCurrencyWrapper" class="back">
			<div><label>Currency:</label><span class="current_currency"><?php echo $_SESSION['currency'] ?></span></div>
			<ul id="currencyList">
			<?php 
			  reset($currencies->currencies);
			  ksort($currencies->currencies);
			  $parameters = zen_get_all_get_params(array('info', 'x', 'y'));
			  $i = 1;
			  while (list($key, $value) = each($currencies->currencies)) {
				if ($key==$_SESSION['currency'])
					echo '<li class="currencyItem">'.$value['title'].'</li>';
				else
					echo'<li class="currencyItem"><a href="'.zen_href_link($_GET['main_page'],'currency='.$key.'&'.$parameters).'"'.'>'.$value['title'].'</a></li>';
			  }
			?>
			</ul>
		</li>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_FAQ) ?>">Help</a></li>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_CONTACT_US) ?>">Contact Us</a></li>
		<?php 
		if($_SESSION['customer_id']==''){
		?>
		<li class="forward p-r"><a href="<?php echo zen_href_link(FILENAME_LOGIN) ?>">Join/Sign In</a><div class="promote_register"></div></li>
		<?php
		}else{
		?>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_LOGOFF) ?>">Sign Out</a></li>
		<li class="forward">Cart:(<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>">&nbsp;<?php echo $_SESSION['cart']->count_contents()==0?'empty':$_SESSION['cart']->count_contents() ?>&nbsp;)</a></li>
		<li class="forward"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT) ?>">My Account</a></li>
		<?php
		}
		?>
		<li class="forward">Welcome to <?php echo preg_replace('/http:\/\/(www.)?/', '', HTTP_SERVER)?></li>
	</ul>
</div>

<div class="p-r layout_site_width category_tabs_wrapper">
<div id="logo"><?php echo zen_image(DIR_WS_TEMPLATE.'images/logo.png','mon cheri logo',200,60) ?></div>
<div id="navMainSearch"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
<!--bof-optional categories tabs navigation display-->
<?php require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
<!--eof-optional categories tabs navigation display-->
<br class="clearBoth" />
</div>
</div>
</div>
<?php }?>