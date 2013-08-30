<div class="centerColumn" id="indexDefault">
<div id="indexDefaultMainContent" class="content"><?php require($define_page); ?></div>
<ul class="l-s_n m0">
<?php 
$top_categories = get_top_categories();
$top_num = 0;
foreach ($top_categories as $entry){
	$top_num++;
?>
<li class="indexCategoryItem <?php if ($top_num%4==0) echo 'last'?> back">
	<div class="t-a_c"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$entry['categories_id'])?>"><img src="<?php echo DIR_WS_IMAGES.$entry['categories_image']?>" width="225px" alt="<?php echo $entry['categories_name']?>" /></a></div>
	<div class="t-a_c"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$entry['categories_id'])?>" class="f-w_b"><?php echo $entry['categories_name']?></a></div>
	<?php 
	$children_cateogries = get_children_categories($entry['categories_id']);
	if (zen_not_null($children_cateogries)) {
		$children_num = 4;
	?>
		<ul class="l-s_n m0">
	<?php
		foreach ($children_cateogries as $children_entry){
			if ($children_num==0) {
				echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$entry['categories_id']).'">View more>></a></li>';
				break;
			}
	?>
		<li><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$children_entry['categories_id'])?>"><?php echo $children_entry['categories_name']?></a></li>
	<?php	
			$children_num--;
		}
	?>
		</ul>
	<?php	
	}
	?>
</li>
<?php
	if ($top_num%4==0) {
		echo '<div class="clearBoth"></div>';
	}
	if ($top_num==8) {
		break;
	}
}
?>
</ul>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
</div>