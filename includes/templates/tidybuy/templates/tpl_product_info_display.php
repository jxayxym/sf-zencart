<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 19690 2011-10-04 16:41:45Z drbyte $
 */
 //require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
?>
<div class="centerColumn" id="productGeneral">
<div class="page_title"><?php echo zen_get_categories_name_from_product((int)$_GET['products_id'])?></div>
<div itemscope itemtype="http://schema.org/Product">
<!--bof Form start-->
<?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
<!--eof Form start-->

<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>

<!--bof Category Icon -->
<?php if (false && $module_show_categories != 0) {?>
<?php
/**
 * display the category icons
 */
require($template->get_template_dir('/tpl_modules_category_icon_display.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_icon_display.php'); ?>
<?php } ?>
<!--eof Category Icon -->

<!--bof Prev/Next top position -->
<?php if ((PRODUCT_INFO_PREVIOUS_NEXT == 1 or PRODUCT_INFO_PREVIOUS_NEXT == 3)) { ?>
<?php
/**
 * display the product previous/next helper
 */
require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
<?php } ?>
<!--eof Prev/Next top position-->

<div>
<div id="product_info_images" class="centeredContent">
<div class="back additionalImagesWrapper">
<!--bof Additional Product Images -->
<?php
/**
 * display the products additional images
 */
  require($template->get_template_dir('/tpl_modules_additional_images.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images.php'); ?>
<!--eof Additional Product Images -->
  <br class="clearBoth" />
</div>
<!--bof Main Product Image -->
<?php
  if (zen_not_null($products_image)) {
  ?>
<?php
/**
 * display the main product image
 */
   require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?>
<?php
  }
?>
<!--eof Main Product Image-->
</div>

<div id="product_info_detail"  class="">
	<!--bof Product Name-->
	<h1 id="productName" class="productGeneral" itemprop="name"><?php echo $products_name; ?></h1>
	<?php require DIR_WS_MODULES.zen_get_module_directory('addthis.php')?>
	<!--eof Product Name-->
	<br class="clearBoth" />
	<!--bof Product Price block -->
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<h2 id="productPrices" class="productGeneral" itemprop="price">
<?php
// base price
  if ($show_onetime_charges_description == 'true') {
    $one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
  } else {
    $one_time = '';
  }
  echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$_GET['products_id']);
?></h2></div>
	<!--eof Product Price block -->

	<!--bof free ship icon  -->
	<?php if(zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) { ?>
	<div id="freeShippingIcon"><?php echo TEXT_PRODUCT_FREE_SHIPPING_ICON; ?></div>
	<?php } ?>
	<!--eof free ship icon  -->
	<br class="clearBoth" />

	<div>
		<div>
			<!--bof Product details list  -->
			<?php if ( (($flag_show_product_info_model == 1 and $products_model != '') or ($flag_show_product_info_weight == 1 and $products_weight !=0) or ($flag_show_product_info_quantity == 1) or ($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name))) ) { ?>
			<ul id="productDetailsList" class="floatingBox back">
			  <?php echo (($flag_show_product_info_model == 1 and $products_model !='') ? '<li>' . TEXT_PRODUCT_MODEL . $products_model . '</li>' : '') . "\n"; ?>
			  <?php echo (($flag_show_product_info_weight == 1 and $products_weight !=0) ? '<li>' . TEXT_PRODUCT_WEIGHT .  $products_weight . TEXT_PRODUCT_WEIGHT_UNIT . '</li>'  : '') . "\n"; ?>
			  <?php echo (($flag_show_product_info_quantity == 1) ? '<li>' . $products_quantity . '<link itemprop="availability" href="http://schema.org/InStock" /> In stock</li>'  : '') . "\n"; ?>
			  <?php echo (($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name)) ? '<li>' . TEXT_PRODUCT_MANUFACTURER . $manufacturers_name . '</li>' : '') . "\n"; ?>
			</ul>
			<br class="clearBoth" />
			<?php
			  }
			?>
			<!--eof Product details list -->
			<!--bof Reviews button and count-->
			<?php
			  if ($flag_show_product_info_reviews == 1) {
				// if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
				if ($reviews->fields['count'] > 0 ) { ?>
				<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
					<div id="productReviewLink" class="back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_REVIEWS, BUTTON_REVIEWS_ALT) . '</a>'; ?></div>
					<p>Rated <span itemprop="ratingValue"><?php echo round($total_rating/$reviews->fields['count'],1) ?></span>/5 based on <span itemprop="reviewCount"><?php echo $reviews->fields['count']?></span> customer reviews</p>
				</div>	
			<?php } else { ?>
			<div id="productReviewLink" class="back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array())) . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?></div>
			<p>There is not any reivews.</p>
			<br class="clearBoth" />
			<?php
			  }
			}
			?>
			<!--eof Reviews button and count -->	   
			<br class="clearBoth" />
			<div class="product_info_cart">
			<!--bof Attributes Module -->
			<?php
			  if ($pr_attr->fields['total'] > 0) {
			?>
			<?php
			/**
			 * display the product atributes
			 */
			  require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); ?>
			<?php
			  }
			?>
			<!--eof Attributes Module -->	
			
			<!--bof Add to Cart Box -->
			<?php
			if (CUSTOMERS_APPROVAL == 3 and TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
			  // do nothing
			} else {
			?>
			<?php
			    $display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
			    if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
			    	// hide the quantity box and default to 1
			    	$input_qty = '<label class="optionName back">&nbsp;&nbsp;Qty</label><input type="hidden" name="cart_quantity" value="1" />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']);
			    } else {
			    	// show the quantity box
			    	$input_qty = '<label class="optionName back">&nbsp;&nbsp;Qty</label><input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" style="width:50px;" />' . zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . zen_draw_hidden_field('products_id', (int)$_GET['products_id']);
			    }
			    $add_to_cart_button = zen_draw_input_field('addToCart','','value="" class="sutmit_add_to_cart"','submit');
			    $display_button = zen_get_buy_now_button($_GET['products_id'], $add_to_cart_button);
			  ?>
			  <?php if ($display_qty != '' or $display_button != '') { ?>
			    <?php
			      echo '<div class="addToCartQty">&nbsp;&nbsp;'.$input_qty.'</div>';
			      echo '<div class="forward">'.$display_button.'</div>';
			            ?>
			  <?php } // display qty and button ?>
			<?php } // CUSTOMERS_APPROVAL == 3 ?>
			<!--eof Add to Cart Box-->	 
			<br class="clearBoth" />
			</div>
			<!--bof Quantity Discounts table -->
			<?php
			  if ($products_discount_type != 0) { ?>
			<?php
			/**
			 * display the products quantity discount
			 */
			 require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); ?>
			<?php
			  }
			?>
			<!--eof Quantity Discounts table -->
			
		</div>
		<br class="clearBoth" />
	</div>
</div>
</div>
<div class="clearBoth">
	<div class="multiLabelMenu">
		<div class="multiLabelMenu-nav">
			<div class="multiLabelMenu-nav-tab tab_selected" rel="content_description">Detail</div>
		</div>
		<div id="content_description" class="multiLabelMenu-concent content_selected">
			<!--bof Product description -->
			<?php if ($products_description != '') { ?>
			<div id="productDescription" class="productGeneral biggerText" itemprop="description"><?php echo stripslashes($products_description); ?><br class="clearBoth" /></div>
			<?php } ?>
			<!--eof Product description -->
		</div>
	</div>	
</div>	
<!--bof Prev/Next bottom position -->
<?php //require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
<!--eof Prev/Next bottom position -->
	

<!--bof Product date added/available-->
<?php
  if ($products_date_available > date('Y-m-d H:i:s')) {
    if ($flag_show_product_info_date_available == 1) {
?>
  <p id="productDateAvailable" class="productGeneral centeredContent"><?php echo sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)); ?></p>
<?php
    }
  } else {
    if ($flag_show_product_info_date_added == 1) {
?>
      <p id="productDateAdded" class="productGeneral centeredContent"><?php echo sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)); ?></p>
<?php
    } // $flag_show_product_info_date_added
  }
?>
<!--eof Product date added/available -->

<!--bof Product URL -->
<?php
  if (zen_not_null($products_url)) {
    if ($flag_show_product_info_url == 1) {
?>
    <p id="productInfoLink" class="productGeneral centeredContent"><?php echo sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($products_url), 'NONSSL', true, false)); ?></p>
<?php
    } // $flag_show_product_info_url
  }
?>
<!--eof Product URL -->
<br class="clearBoth" />
<!--bof also purchased products module-->
<?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
<!--eof also purchased products module-->

<!--bof Form close-->
</form>
<div>
<?php
if(!empty($reviewsArray)){
?>
<h2>Reviews:</h2>
<?php
    foreach ($reviewsArray as $reviews) {
	?>

<div itemprop="review" itemscope itemtype="http://schema.org/Review">
<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . (int)$_GET['products_id'] . '&reviews_id=' . $reviews['id']) . '">' . zen_image_button(BUTTON_IMAGE_READ_REVIEWS , BUTTON_READ_REVIEWS_ALT) . '</a>'; ?></div>

<div class="productReviewsDefaultReviewer bold"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, '<meta itemprop="datePublished" content="'.$reviews['dateAdded'].'">'.zen_date_short($reviews['dateAdded'])); ?>&nbsp;<span itemprop="author"><?php echo sprintf(TEXT_REVIEW_BY, zen_output_string_protected($reviews['customersName'])); ?></span></div>

<div class="rating"  itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><meta itemprop="worstRating" content = "1"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews['reviewsRating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviewsRating'])), '<span itemprop="ratingValue">', $reviews['reviewsRating'],'</span>/<span itemprop="bestRating">5</span>'; ?></div>

<div class="productReviewsDefaultProductMainContent content"><span itemprop="description"><?php echo zen_break_string(zen_output_string_protected(stripslashes($reviews['reviewsText'])), 60, '-<br />') . ((strlen($reviews['reviewsText']) >= 100) ? '...' : ''); ?></span></div>
<hr />
</div>
<br class="clearBoth" />
<?php
    }
}	
?>
</div>
</div>
<!--bof Form close-->
</div>