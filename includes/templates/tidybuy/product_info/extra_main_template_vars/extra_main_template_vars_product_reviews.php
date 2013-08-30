<?php
if(file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/product_reviews.php')){
	include DIR_WS_LANGUAGES . $_SESSION['language'] . '/' .$template_dir . '/product_reviews.php';
}else{
	include DIR_WS_LANGUAGES . $_SESSION['language'] . '/product_reviews.php';
}

  $review_status = " and r.status = 1";

  $reviews_query_raw = "SELECT r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, r.customers_name
                        FROM " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                        WHERE r.products_id = :productsID
                        AND r.reviews_id = rd.reviews_id
                        AND rd.languages_id = :languagesID " . $review_status . "
                        ORDER BY r.reviews_id desc";

  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':productsID', $_GET['products_id'], 'integer');
  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $reviews_split = new splitPageResults($reviews_query_raw,'');
  
  $reviews_list = $db->Execute($reviews_split->sql_query);
  $reviewsArray = array();
  $total_rating = 0;
  while (!$reviews_list->EOF) {
  	$reviewsArray[] = array('id'=>$reviews_list->fields['reviews_id'],
  	                        'customersName'=>$reviews_list->fields['customers_name'],
  	                        'dateAdded'=>$reviews_list->fields['date_added'],
  	                        'reviewsText'=>$reviews_list->fields['reviews_text'],
  	                        'reviewsRating'=>$reviews_list->fields['reviews_rating']);
	$total_rating += 	$reviews_list->fields['reviews_rating'];
    $reviews_list->MoveNext();
  }