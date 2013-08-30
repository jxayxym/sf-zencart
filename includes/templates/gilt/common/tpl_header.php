<?php
  // Display all header alerts via messageStack:
  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
  echo htmlspecialchars(urldecode($_GET['error_message']));
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo htmlspecialchars($_GET['info_message']);
} else {
}
?>
<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>
<div id="headerWrapper">
	<div class="layout-center1000 pr h100">
		<div id="logoWrapper"><div><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</a>'; ?></div></div>
		<div id="navUser">
		<?php 
		if ($_SESSION['customer_id']=='') {
		?>
			<div class="mr20 back"><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></div>
			<div class="mr20 back"><a href="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CREATE_ACCOUNT; ?></a></div>
		<?php
		}else{
		?>
		<div class="mr20 back"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT)?>"><?php echo HEADER_TITLE_MY_ACCOUNT?></a></div>
		<div class="mr20 back"><a href="<?php echo zen_href_link(FILENAME_LOGOFF)?>"><?php echo HEADER_TITLE_LOGOFF?></a></div>
		<?php	
		}
		?>
			<div id="cart-util" class="back">
	            <div>
	                <span>Cart</span>
	                <span class="arrow-w"></span>
	                <span class="cart-util-amount"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>"><?php echo $_SESSION['cart']->count_contents()?></a></span>
	                <?php
	                if($_SESSION['cart']->count_contents()>0){
	                ?>
	                <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING)?>" class="cart-util-checkout">Checkout</a>
	                <?php
	                }
	                ?>
	            </div>
		    </div>
		</div>
		<div id="category_tabs_wrapper">
			<?php require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
			<div id="navMainSearch"><?php require DIR_WS_MODULES.zen_get_module_directory('search_header.php'); ?></div>
			<br class="clearBoth" />
		</div>
	</div>
</div>
<?php } ?>