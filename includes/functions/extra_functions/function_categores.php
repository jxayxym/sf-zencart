<?php
function get_top_categories(){
	return get_children_categories(0);
}	
function get_children_categories($parent_id=0){
	global $db;
	$sql = 'SELECT c1.categories_id,c1.categories_image,cd.categories_name,cd.categories_description FROM '.TABLE_CATEGORIES.' c1 '.
			'JOIN '.TABLE_CATEGORIES_DESCRIPTION.' cd ON '.
			'cd.categories_id=c1.categories_id  where c1.`parent_id`='.$parent_id.' and c1.categories_status=1 and cd.language_id='.(int)$_SESSION['languages_id'].' order by c1.sort_order ASC';
	$categories = $db->Execute($sql);
	$categories_array = array();
    while (!$categories->EOF) {
      $categories_array[] = array(
      	  'categories_id'=>$categories->fields['categories_id'],
      	  'categories_image'=>$categories->fields['categories_image'],
	  	  'categories_name'=>$categories->fields['categories_name'],
    	  'categories_description'=>$categories->fields['categories_description'],
      );

      $categories->MoveNext();
    }
    return $categories_array;
}

function get_master_categories_id($products_id){
	global $db;
	$sql = 'select master_categories_id from '.TABLE_PRODUCTS.' where products_id='.(int)$products_id;
	$r = $db->Execute($sql);
	return $r->fields['master_categories_id'];
}