<?php
  if ($featured_products_split->number_of_rows > 0) {
    $featured_products = $db->Execute($featured_products_split->sql_query);
    $row = 0;
    $col = 0;
    $product_listing_num_pre_row = 4;
    $col_width = floor(100/$product_listing_num_pre_row);
    while (!$featured_products->EOF) {
  	
    	$products_price = zen_get_products_display_price($featured_products->fields['products_id']);
    	
    	if (has_review($featured_products->fields['products_id'],$reviews_info)){
    		$products_reivews = 'Reviews:<img src="'.DIR_WS_TEMPLATES.'template_default/images/stars_'.$reviews_info['average_rating'].'_small.gif'.'" alt="reviews rating">'.$reviews_info['reviews_total'].'Reviews';
    	}else
    		$products_reivews = '';
    	
    	$products_link = zen_href_link(zen_get_info_page($featured_products->fields['products_id']),'products_id=' . $featured_products->fields['products_id']);
    	$list_box_contents[$row][$col] = array('params' =>'class="centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
    			'text' => '<div class="photo_frame">'.(($featured_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . $products_link . '" class="listing_images_wrapper" >' . zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT) .'</a><br />') . '<a href="' . $products_link . '" title="'.zen_output_string($featured_products->fields['products_name']).'">' . zen_trunc_string($featured_products->fields['products_name'],50) . '</a><div class="product_listing_price"><span class="product_listing_currency">' .$_SESSION['currency'] .' </span>'.$products_price.'</div><div class="product_listing_reviews">'.$products_reivews.'</div></div>');
    	
    	$col ++;
    	if ($col > ($product_listing_num_pre_row - 1)) {
    		$col = 0;
    		$row ++;
    	}

      $featured_products->MoveNext();
    }
    
  } else {
  	$list_box_contents = array();
  	
  	$list_box_contents[0][0] = array('params' => 'class="productListing-data"',
  			'text' => TEXT_NO_PRODUCTS);  	
  }
  $title = false;
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>