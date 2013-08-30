<?php
function is_new_product($products_id){
	global $db;
    $new_products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                  p.products_date_added, p.products_price, p.products_type, p.master_categories_id
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.products_status = 1
                           and p.products_id=".$products_id;
   $r = $db->Execute($new_products_query); 
	return $r->RecordCount()>=1?true:false;
}

function is_feature_product($products_id){
	global $db;
    $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id=".$products_id;
   $r = $db->Execute($featured_products_query); 
	return $r->RecordCount()>=1?true:false;    
}

function has_review($products_id,&$return_info=array()){
	global $db;	
  	$review_status = " and r.status = 1 ";

 	$sql = "select SUM(r.reviews_rating)/COUNT(rd.reviews_id) as average_rating,COUNT(rd.reviews_id) as reviews_total
                    from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, "
                           . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                    where p.products_status = '1'
                    and p.products_id = r.products_id
                    and r.reviews_id = rd.reviews_id
                    and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'
                    and p.products_id = pd.products_id
                    and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
                    $review_status;
	$sql .= " and p.products_id = '" . (int)$products_id . "'";
	
    $r = $db->Execute($sql); 
    if ($r->fields['reviews_total']>0){
    	$return_info['average_rating'] = (int)ceil($r->fields['average_rating']);
    	$return_info['reviews_total'] = $r->fields['reviews_total'];
    }
	return $r->fields['reviews_total']>0?true:false;                         
}
function get_product_master_category($products_id){
	global $db;		
	$sql = 'SELECT master_categories_id from '.TABLE_PRODUCTS.' WHERE products_id='.(int)$products_id;
	$r = $db->Execute($sql); 
	return $r->RecordCount()>0?$r->fields['master_categories_id']:false;
}