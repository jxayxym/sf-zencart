<div class="page_title"><?php echo $breadcrumb->last() ?></div>
<br class="clearBoth" />
<?php
require(DIR_WS_MODULES . zen_get_module_directory('category_list.php'));
?>
<div id="categories_list_container">
<?php
while (!$leaf_categories->EOF){
	echo '<div class="back category_item masonry_item"><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$leaf_categories->fields['categories_id']).'">';
	echo '<div class="category_item-title">'.$leaf_categories->fields['categories_name'].'</div>';
	echo zen_image(HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_IMAGES.$leaf_categories->fields['categories_image'],$leaf_categories->fields['categories_name'],300,280);
	if (zen_not_null($leaf_categories->fields['categories_description'])) echo '<div class="category_item-desc">'.$leaf_categories->fields['categories_description'].'</div>';
	echo '</a></div>';
	$leaf_categories->MoveNext();
}
?>
</div>


