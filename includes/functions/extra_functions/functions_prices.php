<?php
/*
 * $type 1-以百分比方式显示,2-直接显示节省的金钱
 */
function zen_get_products_save($products_id,$type,$show_sale_discount_decimals=0) {
	global $db, $currencies;
    // $new_fields = ', product_is_free, product_is_call, product_is_showroom_only';
    $product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");

    $show_display_price = '';
    $display_normal_price = zen_get_products_base_price($products_id);
    $display_special_price = zen_get_products_special_price($products_id, true);
    $display_sale_price = zen_get_products_special_price($products_id, false);

    $show_sale_discount = '';
	if ($display_sale_price) {
		if ($type==1){
			if ($display_normal_price != 0) {
            	$show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS);
			} else {
				$show_discount_amount = '';
			}
			$show_sale_discount = $show_discount_amount;
		}else{
      	  	$show_sale_discount = $currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id']));
		}
	} elseif ($display_special_price) {
        if ($type == 1) {
			if ($display_normal_price != 0) {
            	$show_discount_amount = number_format(100 - (($display_special_price / $display_normal_price) * 100),$show_sale_discount_decimals);
			}else{
				$show_discount_amount = '';
			}
			$show_sale_discount = $show_discount_amount;
        } else {
          	$show_sale_discount = $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id']));
        }
	}
	
	return $show_sale_discount;
}
