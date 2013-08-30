<?php
include(DIR_WS_MODULES . zen_get_module_directory('related_products.php'));

if ($related_products_list->RecordCount()>0) {
	echo '<div>'.sprintf(TABLE_HEADING_RELATED_PRODUCTS,$related_products_list->RecordCount()).'</div>';
	echo '<ul class="related_products_wrapper">';
	while (!$related_products_list->EOF){
		echo '<li class="back"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$related_products_list->fields['products_id']).'"><img src="'.DIR_WS_IMAGES.$related_products_list->fields['products_image'].'" alt="'.$related_products_list->fields['products_name'].'" width="50px" height="80px" /></a></li>';
		$related_products_list->MoveNext();
	}
	echo '</ul>';
}