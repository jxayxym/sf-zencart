<?php
if(true || $_GET['main_page']=='product_info'){
	$title = 'Recently Viewed';
	$title_link = false;
	$content = '';
	if(isset($recently_viewed)&&!empty($recently_viewed)){
		$sql = 'select p.products_id,pd.products_name,p.products_image,p.master_categories_id from ' . TABLE_PRODUCTS . ' p join '.
				TABLE_PRODUCTS_DESCRIPTION . ' pd on p.products_id=pd.products_id '.
				'where p.products_id in ('.implode(',', $recently_viewed).') order by field(p.products_id,'.implode(',', $recently_viewed).')';
		$recently_viewed_products = $db->Execute($sql);	
		require($template->get_template_dir('tpl_recently_viewed.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_recently_viewed.php');
	
		require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
	}
}