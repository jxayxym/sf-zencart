<div class="centerColumn" id="productGeneral">
<?php //require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>
<div id="products_info_display_left_column">
<?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>

<div class="productsInfoWrapper">
	<div class="productsImage">
	<?php  require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?>
	<?php  require($template->get_template_dir('/tpl_modules_additional_images.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images.php'); ?>
	</div>
	<div class="productsInfo">
	<h1 id="productName" class="productGeneral"><?php echo $products_name; ?></h1>
	<h2 id="productPrices" class="productGeneral"><?php  echo ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$_GET['products_id']);?></h2>
	<?php require DIR_WS_MODULES.zen_get_module_directory('addthis.php')?>
	<!-- attributes -->
	<?php if ($pr_attr->fields['total'] > 0) {require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php');}?>	
	<!--bof Add to Cart Box -->
	<?php
	$display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
		if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
			// hide the quantity box and default to 1
			$the_button = '<input type="hidden" name="cart_quantity" value="1" />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
		} else {
			// show the quantity box
			$the_button = PRODUCTS_ORDER_QTY_TEXT . '<input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" /><br />' . zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . '<br />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
		}
	$display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
	if ($display_qty != '' or $display_button != '') { 
	?>
	<div id="cartAdd">
	<?php
	echo $display_qty;
	echo $display_button;
	?>
	</div>
	<?php 
	} // display qty and button 
	?>
	<!--eof Add to Cart Box-->
	<?php require($template->get_template_dir('/tpl_modules_related_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_related_products.php'); ?>
	</div>
<br class="clearBoth" />
</div>
<div id="productDescription" class="productGeneral biggerText"><h1>Description</h1><?php echo stripslashes($products_description); ?></div>

</form>

</div>
<div id="products_info_display_right_column">
<?php
$column_box_default='tpl_box_default_right.php';
require DIR_WS_MODULES . 'sideboxes/'.$template_dir.'/recently_viewed.php';
require DIR_WS_MODULES . 'sideboxes/specials.php';
require DIR_WS_MODULES . 'sideboxes/whats_new.php';
?>
</div>
</div>