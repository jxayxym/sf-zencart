<?php
$specials_query_raw = "SELECT p.products_id, p.products_image, pd.products_name,
                          p.master_categories_id
                         FROM (" . TABLE_PRODUCTS . " p
                         JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id and p.products_id = pd.products_id and p.products_status = '1'
                         AND s.status = 1
                         AND pd.language_id = :languagesID
                         ORDER BY s.specials_date_added DESC";

$specials_query_raw = $db->bindVars($specials_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
$specials_split = new splitPageResults($specials_query_raw, 12);
$specials = $db->Execute($specials_split->sql_query);
$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';
$product_listing_num_pre_row = 4;
$num_products_count = $specials->RecordCount();
if ($num_products_count) {
	$col_width = floor(100/$product_listing_num_pre_row);

	$list_box_contents = array();
	
	while (!$specials->EOF) {
    	$products_price = zen_get_products_display_price($specials->fields['products_id']);
    	
    	if (has_review($specials->fields['products_id'],$reviews_info)){
    		$products_reivews = 'Reviews:<img src="'.DIR_WS_TEMPLATES.'template_default/images/stars_'.$reviews_info['average_rating'].'_small.gif'.'" alt="reviews rating">'.$reviews_info['reviews_total'].'Reviews';
    	}else
    		$products_reivews = '';
    	
    	$products_link = zen_href_link(zen_get_info_page($specials->fields['products_id']),'products_id=' . $specials->fields['products_id']);
    	$list_box_contents[$row][$col] = array('params' =>'class="centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
    			'text' => '<div class="photo_frame">'.(($specials->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . $products_link . '" class="listing_images_wrapper" >' . zen_image(DIR_WS_IMAGES . $specials->fields['products_image'], $specials->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT) .'</a><br />') . '<a href="' . $products_link . '" title="'.zen_output_string($featured_products->fields['products_name']).'">' . zen_trunc_string($specials->fields['products_name'],50) . '</a><div class="product_listing_price"><span class="product_listing_currency">' .$_SESSION['currency'] .' </span>'.$products_price.'</div><div class="product_listing_reviews">'.$products_reivews.'</div></div>');
    	
    	$col ++;
    	if ($col > ($product_listing_num_pre_row - 1)) {
    		$col = 0;
    		$row ++;
    	}

		$specials->MoveNext();
	}
}