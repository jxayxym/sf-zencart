<?php
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays product-listing when a particular category/subcategory is selected for browsing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_product_list.php 15589 2010-02-27 15:03:49Z ajeh $
 */
?>
<div class="centerColumn" id="indexProductList">
<?php //require($template->get_template_dir('tpl_module_manufacturers_nav.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_module_manufacturers_nav.php');?>
<h1 id="productListHeading"><?php echo $breadcrumb->last(); ?></h1>

<?php
if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS == 'true') {
	// categories_image
	if ($categories_image = zen_get_categories_image ( $current_category_id )) {
		?>
<div id="categoryImgListing" class="categoryImg"><?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT); ?></div>
<?php
	}
} // categories_image
?>

<?php
// categories_description
if ($current_categories_description != '') {
	?>
<div id="indexProductListCatDescription" class="content"><?php echo $current_categories_description;  ?></div>
<?php } // categories_description ?>

<span class="forward mr10">
<?php
$parameters = zen_get_all_get_params(array('info', 'x', 'y','sort'));
$form = zen_draw_form ( 'sort', zen_href_link ( FILENAME_DEFAULT,$parameters), 'get' );
echo $form;
require (DIR_WS_MODULES . zen_get_module_directory ( 'product_listing_sorter.php' ));
?>
</form>
</span>
	<br class="clearBoth" />

<?php //require DIR_WS_MODULES . zen_get_module_directory('products_options.php');?>
<?php

require ($template->get_template_dir ( 'tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base, 'templates' ) . '/' . 'tpl_modules_product_listing.php');
?>


<?php
// // bof: categories error
if ($error_categories == true) {
	// verify lost category and reset category
	$check_category = $db->Execute ( "select categories_id from " . TABLE_CATEGORIES . " where categories_id='" . $cPath . "'" );
	if ($check_category->RecordCount () == 0) {
		$new_products_category_id = '0';
		$cPath = '';
	}
	?>

<?php
	$show_display_category = $db->Execute ( SQL_SHOW_PRODUCT_INFO_MISSING );
	
	while ( ! $show_display_category->EOF ) {
		?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_FEATURED_PRODUCTS') {
			?>
<?php

			/**
			 * display the Featured Products Center Box
			 */
			?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_SPECIALS_PRODUCTS') {
			?>
<?php

			/**
			 * display the Special Products Center Box
			 */
			?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_NEW_PRODUCTS') {
			?>
<?php

			/**
			 * display the New Products Center Box
			 */
			?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_UPCOMING') {
			include (DIR_WS_MODULES . zen_get_module_directory ( FILENAME_UPCOMING_PRODUCTS ));
		}
		?>
<?php

		$show_display_category->MoveNext ();
	} // !EOF
	?>
<?php } //// eof: categories error ?>

<?php
// // bof: categories
$show_display_category = $db->Execute ( SQL_SHOW_PRODUCT_INFO_LISTING_BELOW );
if ($error_categories == false and $show_display_category->RecordCount () > 0) {
	?>

<?php
	$show_display_category = $db->Execute ( SQL_SHOW_PRODUCT_INFO_LISTING_BELOW );
	while ( ! $show_display_category->EOF ) {
		?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_FEATURED_PRODUCTS') {
			?>
<?php

			/**
			 * display the Featured Products Center Box
			 */
			?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_SPECIALS_PRODUCTS') {
			?>
<?php

			/**
			 * display the Special Products Center Box
			 */
			?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_NEW_PRODUCTS') {
			?>
<?php

			/**
			 * display the New Products Center Box
			 */
			?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
		if ($show_display_category->fields ['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_UPCOMING') {
			include (DIR_WS_MODULES . zen_get_module_directory ( FILENAME_UPCOMING_PRODUCTS ));
		}
		?>
<?php

		$show_display_category->MoveNext ();
	} // !EOF
	?>

<?php
} // // eof: categories
?>

</div>
