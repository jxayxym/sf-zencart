<?php
/**
 * Module Template:
 * Loaded by product-type template to display additional product images.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_additional_images.php 3215 2006-03-20 06:05:55Z birdbrain $
 */

  require(DIR_WS_MODULES . zen_get_module_directory('additional_images.php'));
 ?>
 <?php
 if ($flag_show_product_info_additional_images != 0 && $num_images > 0) {
  ?>
<div id="productAdditionalImages" class="l-s_n">
<div id="additionalImagesUp">UP</div>
<div id="additionThumbnail">
<?php 
foreach($list_box_contents as $rows){
	foreach($rows as $col){
?>
	<div class="additionalImages"><?php echo $col['text'];?></div>
<?php		
	}
}
?>
</div>
<div id="additionalImagesDown">DOWN</div>
<br class="clearBoth" />
</div>
<?php 
  }
?>