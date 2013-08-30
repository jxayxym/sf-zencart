<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
//$page = isset($_GET['page'])?(int)$_GET['page']:1;
$listing_split = new splitPageResults($_SESSION['listing_sql'], MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
if ($listing_split->number_of_rows > 0) {
  $rows = 0;
  $col = 0;
  $listing = $db->Execute($listing_split->sql_query);
  define('NUM_ROW', 3);
  $width = floor(100/NUM_ROW);
  while (!$listing->EOF) {
	$text = '';
    if (isset($_GET['manufacturers_id'])) {
      $text .= '<a class="listingProductImageWrapper" href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH,''/* IMAGE_PRODUCT_LISTING_HEIGHT*/, 'class="listingProductImage"') . '</a><br />';
    } else {
      $text .= '<a class="listingProductImageWrapper" href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, ''/* IMAGE_PRODUCT_LISTING_HEIGHT*/, 'class="listingProductImage"') . '</a><br />';
    }	
	$prodcuts_name = '<h3 class="itemTitle"><a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id'] > 0) ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']) . '">' . zen_trunc_string($listing->fields['products_name'],60) . '</a></h3>';    
	$prodcuts_price = '<div class="product_listing-price productFinalPrice">'.$currencies->display_price((zen_get_products_actual_price($listing->fields['products_id'])),0).'</div><br />';

    // more info in place of buy now
    $lc_button = '';
    if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
    	$lc_button = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? $_GET['cPath'] : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
    } else {
       if (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0) {
         if (
         	// not a hide qty box product
         	$listing->fields['products_qty_box_status'] != 0 &&
            // product type can be added to cart
            zen_get_products_allow_add_to_cart($listing->fields['products_id']) != 'N'
            &&
            // product is not call for price
            $listing->fields['product_is_call'] == 0
            &&
            // product is in stock or customers may add it to cart anyway
            ($listing->fields['products_quantity'] > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0) ) {
            $how_many++;
          }
          // hide quantity box
          if ($listing->fields['products_qty_box_status'] == 0) {
            $lc_button = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
          } else {
            $lc_button = TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART . "<input type=\"text\" name=\"products_id[" . $listing->fields['products_id'] . "]\" value=\"0\" size=\"4\" />";
          }
        } else {
		// qty box with add to cart button
          if (PRODUCT_LIST_PRICE_BUY_NOW == '2' && $listing->fields['products_qty_box_status'] != 0) {
            $lc_button= zen_draw_form('cart_quantity', zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=add_product&products_id=' . $listing->fields['products_id']), 'post', 'enctype="multipart/form-data"') . '<input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($listing->fields['products_id'])) . '" maxlength="6" size="4" /><br />' . zen_draw_hidden_field('products_id', $listing->fields['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</form>';
          } else {
            $lc_button = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
          }
        }
      }
	  $the_button = $lc_button;
      $products_link = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . ( ($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ? zen_get_generated_category_path_rev($_GET['filter_id']) : $_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id'])) . '&products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
//      $text .= '<br />' . zen_get_buy_now_button($listing->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($listing->fields['products_id']);
//      $text .= '<br />' . (zen_get_show_product_switch($listing->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($listing->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
  	$products_reivews = '';
      if (has_review($listing->fields['products_id'],$reviews_info)){
		$products_reivews = 'Reviews:<img src="'.DIR_WS_TEMPLATES.'template_default/images/stars_'.$reviews_info['average_rating'].'_small.gif'.'" alt="reviews rating">'.$reviews_info['reviews_total'].'Reviews';
	}
        $text .= "<div class=\"products_item-more_info\">".$prodcuts_name.$products_reivews."</div>".$prodcuts_price;
      $list_box_contents[$rows][$col] = array('params' => 'class="back" '.'style="width:'.$width.'%;"',
                                              'text'  => '<div class="products_item">'.$text.'</div>');
      $col++;
      if ($col%NUM_ROW==0){
      	$col = 0;
      	$rows++;
      } 
      $listing->MoveNext();
    }
/**
 * load the list_box_content template to display the products
 */
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
}
