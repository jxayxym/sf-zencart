<?php
/**
 * ot_coupon order-total module
 *
 * @package orderTotal
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ot_coupon.php 19063 2011-07-08 20:57:09Z wilt $
 */
/**
 * Order Total class  to handle discount coupons
 *
 */
class ot_western_union_discount {
  /**
   * coupon title
   *
   * @var unknown_type
   */
  var $title;
  /**
   * Output used on checkout pages
   *
   * @var unknown_type
   */
  var $output;
  /**
   * Enter description here...
   *
   * @return ot_coupon
   */
  function ot_western_union_discount() {
    $this->code = 'ot_western_union_discount';
    $this->header = 'header';
    $this->title = 'Western Union Discount';
    $this->description = 'if the payment is Western Union,get a specified discount';
    $this->user_prompt = '';
    $this->sort_order = MODULE_ORDER_TOTAL_WESTERN_UNION_SORT_ORDER;
    $this->include_shipping = MODULE_ORDER_TOTAL_WESTERN_UNION_INC_SHIPPING;
    $this->include_tax = MODULE_ORDER_TOTAL_WESTERN_UNION_INC_TAX;
    $this->calculate_tax = MODULE_ORDER_TOTAL_WESTERN_UNION_CALC_TAX;
    $this->tax_class  = MODULE_ORDER_TOTAL_WESTERN_UNION_TAX_CLASS;
    $this->credit_class = false;
    $this->output = array();
    if (IS_ADMIN_FLAG === true) {
      if ($this->include_tax == 'true' && $this->calculate_tax != "None") {
        $this->title .= '<span class="alert">123</span>';
      }
    }
  }
  /**
   * Method used to produce final figures for deductions. This information is used to produce the output<br>
   * shown on the checkout pages
   *
   */
    function process() {
    global $order, $currencies;
    if ($_SESSION['payment']=='westernunion') {
      $deduction_amount = $this->calculate_deductions($this->get_order_total());
      $this->deduction = $deduction_amount['total'];
      if ($deduction_amount['total'] > 0) {
        $order->info['total'] = $order->info['total'] - $deduction_amount['total'];
        if ($order->info['total'] < 0) $order->info['total'] = 0;
        // prepare order-total output for display and storing to invoice
        $this->output[] = array('title' => $this->title . ':',
        'text' => '-' . $currencies->format($deduction_amount['total']),
        'value' => $deduction_amount['total']);
      }
    }
  }
  /**
   * Enter description here...
   *
   * @return unknown
   */
  function selection_test() {
    return false;
  }
  /**
   * Enter description here...
   *
   */
  function clear_posts() {
	    return false;
  }
  /**
   * 计算可扣除的费用
   *
   * @param unknown_type $order_total
   * @return unknown
   */
  function pre_confirmation_check($order_total) {
    global $order;
    $deductions_amount = $this->calculate_deductions($order_total);

    $order->info['total'] = $order->info['total'] - $deductions_amount['total'];

    return $deductions_amount['total'];
  }
  /**
   * 收集POST数据
   *
   */
  function collect_posts() {
  	return false;
  }
  
  function calculate_deductions($order_total) {
  	$conifgure_deduction = MODULE_ORDER_TOTAL_WESTERN_UNION_FAVORABLE_AMOUNT;
  	if (preg_match('/^(\d{1,2})%$/',$conifgure_deduction,$match)){
  		$deduction =  $order_total*$match[1]/100;
  	}elseif (preg_match('/^\d+$/',$conifgure_deduction)){
  		$deduction = (int)$conifgure_deduction;
  	}else{
  		$deduction = 0;
  	}
  	return array(
  				'total'=>$deduction,
  				'tax'=>0
  			);
  }
  
  /**
   * Recalculates base order-total amount for use in deduction calculations
   */
  function get_order_total() {
    global $order;
    $order_total = $order->info['total'];
    // if we are not supposed to include tax in credit calculations, subtract it out
    if ($this->include_tax != 'true') $order_total -= $order->info['tax'];
    // if we are not supposed to include shipping amount in credit calcs, subtract it out
    if ($this->include_shipping != 'true') $order_total -= $order->info['shipping_cost'];
    $order_total = $order->info['total'];
    return $order_total;
  }
  /**
   * 检查模块是否安装
   *
   * @return unknown
   */
  function check() {
    global $db;
    if (!isset($this->check)) {
      $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_WESTERN_UNION_STATUS'");
      $this->check = $check_query->RecordCount();
    }

    return $this->check;
  }
  /**
   * Enter description here...
   *
   * @return unknown
   */
  function keys() {
    return array(
    		'MODULE_ORDER_TOTAL_WESTERN_UNION_STATUS',
    		'MODULE_ORDER_TOTAL_WESTERN_UNION_FAVORABLE_AMOUNT', 
    		'MODULE_ORDER_TOTAL_WESTERN_UNION_SORT_ORDER', 
    		);
  }
  /**
   * 安装模块
   *
   */
  function install() {
    global $db;
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('This module is installed', 'MODULE_ORDER_TOTAL_WESTERN_UNION_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_WESTERN_UNION_SORT_ORDER', '667', 'Sort order of display.', '6', '2', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Favorble Amount', 'MODULE_ORDER_TOTAL_WESTERN_UNION_FAVORABLE_AMOUNT', '0', 'The amount of the favorable,either fixed or add a % on the end for a percentage discount. ', '6', '2', now())");
  }
  /**
   * 卸载模块
   *
   */
  function remove() {
    global $db;
    $keys = '';
    $keys_array = $this->keys();
    for ($i=0; $i<sizeof($keys_array); $i++) {
      $keys .= "'" . $keys_array[$i] . "',";
    }
    $keys = substr($keys, 0, -1);

    $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
  }
}
