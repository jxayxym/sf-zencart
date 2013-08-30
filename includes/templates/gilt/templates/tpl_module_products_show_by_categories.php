<?php 
require DIR_WS_MODULES.zen_get_module_directory('products_show_by_category.php');

if (!empty($products_by_categories)){
	
	foreach ($products_by_categories as $categories_id=>$entry_products){
?>
<div class="products_show_categoris_item">
	<div class="products_show_by_category_title"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$categories_id)?>"><?php echo zen_get_category_name($categories_id,$_SESSION['languages_id'])?></a></div>
	<div class="products_show_products_items">
	<?php 
		foreach ($entry_products as $entry){
	?>	
		<div class="back mr5 products_show_products_item">
		<div class="products_show_products_image"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$entry['products_id'])?>"><?php echo zen_image(DIR_WS_IMAGES.$entry['products_image'],$entry['products_name'],'',200)?></a></div>
		<div class="shade"></div>
		<div class="products_show_products_item_price"><?php echo $currencies->display_price((zen_get_products_actual_price($entry['products_id'])),0)?></div>
		</div>	
	<?php		
		}
	?>
		<div class="back products_show_category products_show_products_item">
		<?php echo zen_image(DIR_WS_IMAGES.zen_get_categories_image($categories_id),'','',200)?><div class="shade"></div>
		<div class="products_show_categoryname"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$categories_id)?>"><?php echo zen_get_category_name($categories_id,$_SESSION['languages_id'])?></a></div>
		</div>
	</div>
	<br class="clearBoth" />
</div>
<?php		
	}
}