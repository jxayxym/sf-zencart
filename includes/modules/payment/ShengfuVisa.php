<?php
  class ShengfuVisa  extends base{
    var $code, $title, $description, $enabled;

// class constructor
    function ShengfuVisa () {
      global $order,$zco_notifier;
      $this->code = 'ShengfuVisa';
      $this->title = 'Shengfu-Visa Order';//need define
      $this->description = 'This is a payment specially design for shengfu.net because he can\'t use paypal aboveboard!';//need define
      $this->sort_order = MODULE_PAYMENT_SHENGFUVISA_SORT_ORDER;//need define
      $this->enabled = ((MODULE_PAYMENT_SHENGFUVISA_STATUS == 'True') ? true : false);
			
	 if ((int)MODULE_PAYMENT_SHENGFUVISA_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_SHENGFUVISA_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
      
      $this->email_footer = '';//need define
      
//	  $zco_notifier->attach($this, array('NOTIFY_HEADER_END_CHECKOUT_CONFIRMATION'));	
    }
    

   
// class methods

function update_status() {
      global $order, $db;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_SHENGFUVISA_ZONE > 0) ) {
        $check_flag = false;
        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_SHENGFUVISA_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
                   'module' => TEXT_SHENGFUVISA_DESCRIPTION,
                   'icon' => '<img src="'.DIR_WS_MODULES . 'payment/visa/visa.jpg'.'" alt="Checkout with Visa" title="Checkout with Visa" />',
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
	$msg = "<p>Dear customer</p><p> Dear Customer, If you want pay your order with PayPal, Please contact our service member or leave message to us.Thanks.</p><p> Thank you very much.</p>";	  
      // $msg = "<p>Dear customer</p><p> Because all the products at our store are replicas,And PayPal can't support seller use PayPal as payment method.So we can't set the PayPal directly on the site, But we have PayPal account,You still can pay your order use paypal. Our service member will contact you in email as soon as possible.Please check your email in time.</p><p> Thank you very much.</p>";
      $messageStack->add_session('checkout_sucess','<font color="red" style="background:yellow;font-size:15px;">'.$msg.'</font><div id="dialog-message" title="Sorry!" style="font-size:14px">'.$msg.'</div><script>$( "#dialog-message" ).dialog({modal: true,width: 500,height:270,buttons: {Ok:function(){$( this ).dialog( "close" );}}})</script>','caution');	
      return true;
    }

    function get_error() {
      return false;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SHENGFUVISA_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
          global $db, $language;
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable SHENGFUVISA Order Module', 'MODULE_PAYMENT_SHENGFUVISA_STATUS', 'True', 'Do you want to accept SHENGFUVISA Order payments', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());");
          $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_SHENGFUVISA_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
          $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display', 'MODULE_PAYMENT_SHENGFUVISA_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");    
    }

    function remove() {
    	global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_SHENGFUVISA_STATUS' ,'MODULE_PAYMENT_SHENGFUVISA_SORT_ORDER','MODULE_PAYMENT_SHENGFUVISA_ORDER_STATUS_ID');
    }
    
    function update(&$class, $eventID, $paramsArray) {
//  		global $messageStack;
//  		if ($eventID=='NOTIFY_HEADER_END_CHECKOUT_CONFIRMATION'){
//  			$messageStack->add('checkout_confirmation','<font color="red">Dear customer,Our store can\'t support paypal/visa payment the moment, But if you really want to pay with paypal, You can contact us or leave a message, Our customer service member will contact you as soon as possible. Thanks.</font>','caution');
//  		}
  	}    
  }
?>
