<?php
/**
 * categories sidebox - prepares content for the main categories sidebox
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: categories.php 2718 2005-12-28 06:42:39Z drbyte $
 */

if(!empty($cPath_array)){		
	$cur_category = $cPath_array[sizeof($cPath_array)-1];//current category
	
	$box_id = 'sidebox_categories';
	$title = BOX_HEADING_CATEGORIES;
	$title_link = false;
	
    $sub_categories = $db->Execute("select c.categories_id,cd.categories_name,count(p2c.products_id) as total from " . TABLE_CATEGORIES . " c join ".TABLE_CATEGORIES_DESCRIPTION." cd on c.categories_id=cd.categories_id join ".TABLE_PRODUCTS_TO_CATEGORIES." p2c on p2c.categories_id=c.categories_id where categories_status=1 and parent_id={$cur_category} and language_id={$_SESSION['languages_id']} group by c.categories_id");
    if ($sub_categories->RecordCount() > 0) {
    	
		require($template->get_template_dir('tpl_categories.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_categories.php');
		
    	require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
	}else{
		$cur_category_parent = $db->execute('select parent_id from '.TABLE_CATEGORIES.' where categories_id='.$cur_category);
		if ($cur_category_parent->fields['parent_id']!=0) {
			$sub_categories = $db->Execute("select c.categories_id,cd.categories_name,count(p2c.products_id) as total from " . TABLE_CATEGORIES . " c join ".TABLE_CATEGORIES_DESCRIPTION." cd on c.categories_id=cd.categories_id join ".TABLE_PRODUCTS_TO_CATEGORIES." p2c on p2c.categories_id=c.categories_id where categories_status=1 and parent_id={$cur_category_parent->fields['parent_id']} and language_id={$_SESSION['languages_id']} group by c.categories_id");

			require($template->get_template_dir('tpl_categories.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_categories.php');
			
			require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);			
		}
	}
}	
?>