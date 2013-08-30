<div class="centerColumn" id="indexDefault">
	<div class="categories_list_container">
	<?php
	$top_categories = get_top_categories();
	$i = 0;
	foreach ($top_categories as $entry){
		if ($i==6) continue;
		echo '<div class="back category_item"><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$entry['categories_id']).'">';
		echo '<div class="category_item-title">'.$entry['categories_name'].'</div>';
		echo '<img src="'.DIR_WS_IMAGES.$entry['categories_image'].'" alt="'.$entry['categories_name'].'" width="300px" height="300px" />';
		echo '</a></div>';
		$i++;
	}                   
     ?>
	</div>
	<div class="besterSellerWarpper">
	<?php 
	$column_box_default='tpl_box_default_left.php';
	require DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/best_sellers.php';
	?>
	</div>
<br class="clearBoth" />	
<?php 
require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php');
require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php');
?>	
</div>
<script type="text/javascript">
new srcMarquee("ol_best_sellers",0,5,300,880,30,2000,2000,300);
</script>