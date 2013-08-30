<?php
require(DIR_WS_MODULES . zen_get_module_directory('category_list.php'));

while (!$leaf_categories->EOF){
	echo '<div class="forward category_item masonry_item"><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$leaf_categories->fields['categories_id']).'">';
	echo '<div class="category_item-title">'.$leaf_categories->fields['categories_name'].'</div>';
	echo zen_image(HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_IMAGES.$leaf_categories->fields['categories_image'],$leaf_categories->fields['categories_name'],300,280);
	echo '</a></div>';
	$leaf_categories->MoveNext();
}