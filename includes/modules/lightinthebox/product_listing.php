<?php
/**
 * listing module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: listing.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$show_submit = zen_run_normal();

$listing_split = new sf_splitPageResults($listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
$zco_notifier->notify('NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT', $listing_split->number_of_rows);
$num_products_count = $listing_split->number_of_rows;
$product_listing_num_pre_row = 3;

// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < $product_listing_num_pre_row || $product_listing_num_pre_row == 0) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/$product_listing_num_pre_row);
  }
//   echo $listing_split->sql_query;exit;
  $listing = $db->Execute($listing_split->sql_query,false,true,3600);
  $row = 0;
  $col = 0;
  while (!$listing->EOF) {
    $products_price = zen_get_products_display_price($listing->fields['products_id']);
    $products_reivews = '';
    if (has_review($listing->fields['products_id'],$reviews_info)){
    	$products_reivews = 'Reviews:<img src="'.DIR_WS_TEMPLATES.'template_default/images/stars_'.$reviews_info['average_rating'].'_small.gif'.'" alt="reviews rating">'.$reviews_info['reviews_total'].'Reviews';
    }
    
    
    if (has_review($listing->fields['products_id'],$reviews_info)){
    	$products_reivews = 'Reviews:<img src="'.DIR_WS_TEMPLATES.'template_default/images/stars_'.$reviews_info['average_rating'].'_small.gif'.'" alt="reviews rating">'.$reviews_info['reviews_total'].'Reviews';
    }else
    	$products_reivews = '&nbsp;';
    $list_box_contents[$row][$col] = array('params' =>'class="back"' . ' ' . 'style="width:' . $col_width . '%;"',
    'text' => '<div class="photo_frame">'.(($listing->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<div class="t-a_c"><a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . $productsInCategory[$listing->fields['products_id']] . '&products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT).'</a></div>') . '<div class="product_listing_name"><a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . $productsInCategory[$listing->fields['products_id']] . '&products_id=' . $listing->fields['products_id']) . '" title="'.zen_output_string($listing->fields['products_name']).'">' . zen_trunc_string($listing->fields['products_name'],100) . '</a></div><p class="product_listing_price"><span class="product_listing_currency">' .$_SESSION['currency'] .' </span>'.$products_price.'</p><p>'.$products_reivews.'</p></div>');

    $col ++;
    if ($col > ($product_listing_num_pre_row - 1)) {
      $col = 0;
      $row ++;
    }
    $listing->MoveNext();
  }

  $title = false; 
}else{
	$title = false;
	$list_box_contents = array();
	
	$list_box_contents[0][0] = array('params' => 'class="productListing-data"',
			'text' => TEXT_NO_PRODUCTS);	
}
?>