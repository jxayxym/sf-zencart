<?php
  class ShengfuPaypal extends base {
    var $code, $title, $description, $enabled;

// class constructor
    function ShengfuPaypal () {
      global $order,$zco_notifier;
      $this->code = 'ShengfuPaypal';
      $this->title = 'Shengfu-Paypal Order';//need define
      $this->description = 'This is a payment specially design for shengfu.net because he can\'t use paypal aboveboard!';//need define
      $this->sort_order = MODULE_PAYMENT_SHENGFUPAYPAL_SORT_ORDER;//need define
      $this->enabled = ((MODULE_PAYMENT_SHENGFUPAYPAL_STATUS == 'True') ? true : false);
			
	 if ((int)MODULE_PAYMENT_SHENGFUPAYPAL_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_SHENGFUPAYPAL_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
      
      $this->email_footer = 'Please sent your money to this account:<font style="font-weight:bold;">'.MODULE_PAYMENT_SHENGFUPAYPAL_ACCOUNT.'</font>,and Please give me a reply after your payment';//need define
//	  $zco_notifier->attach($this, array('NOTIFY_HEADER_END_CHECKOUT_CONFIRMATION'));
    }
    

   
// class methods

function update_status() {
      global $order, $db;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_SHENGFUPAYPAL_ZONE > 0) ) {
        $check_flag = false;
        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_SHENGFUPAYPAL_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while (!$check->EOF) {
          if ($check->fields['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
          $check->MoveNext();
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }
    
    
    function javascript_validation() {
      return false;
    }

   function selection() {
     return array('id' => $this->code,
                   'module' => TEXT_SHENGFUPAYPAL_DESCRIPTION,
                   'icon' => '',
                   );
   }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return array('title' => '');
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      global $messageStack;
	  $msg = '<p>Dear customer</p><p>Please sent your money to this account: <font style="font-size:16px;font-weight:bold;background:yellow;">'.MODULE_PAYMENT_SHENGFUPAYPAL_ACCOUNT."</font>.And Please give me a reply after your payment.</p><p> Thank you very much.</p>";	  
      $messageStack->add_session('checkout_sucess',$msg,'success');	
      return true;
    }

    function get_error() {
      return false;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SHENGFUPAYPAL_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db, $language;
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable ShengfuPaypal Order Module', 'MODULE_PAYMENT_SHENGFUPAYPAL_STATUS', 'True', 'Do you want to accept ShengfuPaypal Order payments', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_SHENGFUPAYPAL_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('paypal account', 'MODULE_PAYMENT_SHENGFUPAYPAL_ACCOUNT', '', 'after customer confirm order,the account will display', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display', 'MODULE_PAYMENT_SHENGFUPAYPAL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");    
    }

    function remove() {
    	global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_SHENGFUPAYPAL_STATUS','MODULE_PAYMENT_SHENGFUPAYPAL_ACCOUNT' ,'MODULE_PAYMENT_SHENGFUPAYPAL_SORT_ORDER','MODULE_PAYMENT_SHENGFUPAYPAL_ORDER_STATUS_ID');
    }
    
  	function update(&$class, $eventID, $paramsArray) {
//  		global $messageStack;
//  		if ($eventID=='NOTIFY_HEADER_END_CHECKOUT_CONFIRMATION'){
//  			$messageStack->add('checkout_confirmation','<font color="red">Dear customer,Our store can\'t support paypal/visa payment the moment, But if you really want to pay with paypal, You can contact us or leave a message, Our customer service member will contact you as soon as possible. Thanks.</font>','caution');
//  		}
  	}
  }
?>
