<?php
/**
 * new_products.php module
 *
 * @package modules
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: new_products.php 8730 2008-06-28 01:31:22Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$products_query = '';


if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                p.products_date_added, p.products_price, p.products_type, p.master_categories_id
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and   p.products_status = 1 ";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma

    $products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                  p.products_date_added, p.products_price, p.products_type, p.master_categories_id
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.products_status = 1
                           and p.products_id in (" . $list_of_products . ")";
  }
}
$products_query = $products_query.' order by pd.products_viewed DESC,p.products_sort_order,p.products_id';

if ($products_query != '') $popular_products = $db->Execute($products_query, MAX_DISPLAY_NEW_PRODUCTS);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($products_query == '') ? 0 : $popular_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS == 0 ) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS);
  }

  while (!$popular_products->EOF) {
    $products_price = zen_get_products_display_price($popular_products->fields['products_id']);
    if (!isset($productsInCategory[$popular_products->fields['products_id']])) $productsInCategory[$popular_products->fields['products_id']] = zen_get_generated_category_path_rev($popular_products->fields['master_categories_id']);

    $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsNew centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
    'text' => (($popular_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . zen_href_link(zen_get_info_page($popular_products->fields['products_id']), 'cPath=' . $productsInCategory[$popular_products->fields['products_id']] . '&products_id=' . $popular_products->fields['products_id']) . '"><img src="'.DIR_WS_IMAGES . $popular_products->fields['products_image'].'" alt="'.$popular_products->fields['products_name'].'" width="'.IMAGE_PRODUCT_NEW_WIDTH.'px" height="'.IMAGE_PRODUCT_NEW_HEIGHT.'px" /></a><br />') . '<a href="' . zen_href_link(zen_get_info_page($popular_products->fields['products_id']), 'cPath=' . $productsInCategory[$popular_products->fields['products_id']] . '&products_id=' . $popular_products->fields['products_id']) . '">' . zen_trunc_string($popular_products->fields['products_name'],40) . '</a><br /><p class="product_listing_price"><span class="product_listing_currency">'.$_SESSION['currency'].'</span>' . $products_price.'</p>');

    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $popular_products->MoveNext();
  }

  if ($popular_products->RecordCount() > 0) {
    if (isset($new_products_category_id) && $new_products_category_id != 0) {
      $category_title = zen_get_categories_name((int)$new_products_category_id);
      $title = '<h2 class="centerBoxHeading">' . sprintf(TABLE_HEADING_POPULAR_PRODUCTS, strftime('%B')) . ($category_title != '' ? ' - ' . $category_title : '' ) . '</h2>';
    } else {
      $title = '<h2 class="centerBoxHeading">' . sprintf(TABLE_HEADING_POPULAR_PRODUCTS, strftime('%B')) . '</h2>';
    }
    $zc_show_new_products = true;
  }
}
?>