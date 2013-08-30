<?php
/**
 * Page Template - Featured Products listing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_featured_products_default.php 2603 2005-12-19 20:22:08Z wilt $
 */
?>
<div class="centerColumn" id="featuredDefault">

<h1 id="featuredDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php
/**
 * display the featured products
 */
require($template->get_template_dir('/tpl_modules_products_featured_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_featured_listing.php'); ?>

<?php
  if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div id="featuredProductsListingBottomLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
<div id="featuredProductsListingBottomNumber" class="navSplitPagesResult"><?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS); ?></div>
<?php
  }
?>
</div>