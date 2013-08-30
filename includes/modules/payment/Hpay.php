<?php
/**
*update date 2013.2.5
**/
date_default_timezone_set('PRC');
class Hpay{
	var $code, $title, $description, $enabled,$sort_order,$order_id;
	var $order_pending_status = 1;
	var $order_status = DEFAULT_ORDERS_STATUS_ID;
	function Hpay() {
		global $order;
		$this->code="Hpay";
		$this->title=MODULE_PAYMENT_HPAY_TEXT_ADMIN_TITLE;
		$this->description=MODULE_PAYMENT_HPAY_TEXT_DESCRIPTION;
		$this->sort_order=MODULE_PAYMENT_HPAY_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_HPAY_STATUS == 'True') ? true : false);
		if ((int)MODULE_PAYMENT_HPAY_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_HPAY_ORDER_STATUS_ID;
		}
		if(is_object($order)) {
			$this->update_status();
		}
		if(MODULE_PAYMENT_HPAY_HANDLER == 'Live') {
			$this->form_action_url='https://pay.91HPAY.com/Payment/PayPage.aspx';
			if (MODULE_PAYMENT_HPAY_URL != '') {
				$this->form_action_url=MODULE_PAYMENT_HPAY_URL;
			}
		} elseif (MODULE_PAYMENT_HPAY_HANDLER == 'Test') {
			$this->form_action_url='http://pay.91hpay.net/Payment/PayPage.aspx';
		}

	}
	function update_status() {
		global $db,$order;
		if(($this->enabled==true)&&((int)MODULE_PAYMENT_HPAY_ZONE > 0)) {
			$check_flag=false;
			$check_query=$db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_HPAY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
			while(!$check_query->EOF) {
				if($check_query->fields['zone_id'] < 1) {
					$check_flag=true;
					break;
				} elseif ($check_query->fields['zone_id'] == $order->billing['zone_id']) {
					$check_flag=true;
					break;
				}
				$check_query->MoveNext();
			}
			if($check_flag==false) {
				$this->enabled=false;
			}
		}
	}
	function javascript_validation() {
		return false;
	}
	function selection() {
		return array(
        'id' => $this->code,
        'module'=> MODULE_PAYMENT_HPAY_TEXT_CATALOG_LOGO,
        'icon' => MODULE_PAYMENT_HPAY_TEXT_CATALOG_LOGO
		);
	}
	function pre_confirmation_check() {
		return false;
	}
	function confirmation() {
		return true;
	}
	function process_button(){
		global $db, $order, $currencies;
		require_once(DIR_WS_CLASSES . 'order.php');
		//force zen cart to load existing order without creating dumplicate order
		if(isset($_SESSION['order_id']) && ($_SESSION['cart']->cartID == $_SESSION['old_cart_id']) && ($_SESSION['old_cur'] == $_SESSION['currency'])) 
		{
			$order_id = $_SESSION['order_id'];
		} else {
			if ( isset($_SESSION['order_id'])) {
				$order_id = $_SESSION['order_id'];
				//$db->Execute('delete from ' . TABLE_ORDERS . ' where orders_id = "' . (int)$order_id . '"');
				//$db->Execute('delete from ' . TABLE_ORDERS_TOTAL . ' where orders_id = "' . (int)$order_id . '"');
				//$db->Execute('delete from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '"');
				//$db->Execute('delete from ' . TABLE_ORDERS_PRODUCTS . ' where orders_id = "' . (int)$order_id . '"');
				//$db->Execute('delete from ' . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . ' where orders_id = "' . (int)$order_id . '"');
				//$db->Execute('delete from ' . TABLE_ORDERS_PRODUCTS_DOWNLOAD . ' where orders_id = "' . (int)$order_id . '"');
			}
			$order = new order();
			$order->info['order_status'] = $this->order_status;//init status,pending
			require_once(DIR_WS_CLASSES . 'order_total.php');
			$order_total_modules = new order_total();
			$order_totals = $order_total_modules->process();
			$order_id = $order->create($order_totals);
			$order->create_add_products($order_id, 2);
			$_SESSION['order_id'] = $order_id;
			$_SESSION['old_cart_id'] = $_SESSION['cart']->cartID;
			$_SESSION['old_cur'] = $_SESSION['currency'];
		}
		date_default_timezone_set(date_default_timezone_get());
		$version='1.0.0';
		$encoding='utf-8';
		$datestr=date('YmdHis');
		if (defined('MODULE_PAYMENT_HPAY_ORDER_PREFIX') ) {
			$prefix = strtolower(MODULE_PAYMENT_HPAY_ORDER_PREFIX);
		} else {
			$prefix =  strtolower(STORE_NAME);
		}
		$orderid=$prefix.$order_id;
		$currency = $_SESSION['currency'];
		$amount=zen_round($order->info['total'] * $currencies->currencies[$currency]['value'],2);
		$currencies->currencies[$currency]['value'];
		$strServerUrl = zen_href_link('Hpay_91hpay_main_handler.php', '', 'SSL',false,false,true);
		$strBrowserurl= zen_href_link('Hpay_91hpay.php', '', 'SSL',false,false,true);
		$strAccessurl = zen_href_link(FILENAME_CHECKOUT_CONFIRMATION);  //this will be fixed to adapt to fake url
		$this->write_log('BrowserURl is : '. $strBrowserurl);
		switch($_SESSION['languages_code']) {
			case 'de':
				$strlang='de-de';
				break;
			case 'fr':
				$strlang='fr-fr';
				break;
			case 'it':
				$strlang='it-it';
				break;
			case 'es':
				$strlang='es-es';
				break;
			case 'pt':
				$strlang='pt-pt';
				break;
			case 'jp':
				$strlang='ja-jp';
				break;
			default:
				$strlang='en-us';
		}
		$shipfee='0.00';
		if($order->info['shipping_cost']!=''&&$order->info['shipping_cost']!=0) {
			$shipfee=zen_round($order->info['shipping_cost'],2);//运费保留2位小数
		}
		$billaddress =  $order->billing['street_address'];
		$billcountry =  $order->billing['country']['iso_code_2'];
		$billstate = $order->billing['state'];
		$billcity =  $order->billing['city'];
		$billemail = $order->customer['email_address'];
		$billphone = $order->customer['telephone'];
		$billpost =  $order->billing['postcode'];
		
		$deliveryfirstname = $order->delivery['firstname'] != '' ? $order->delivery['firstname'] : $order->billing['firstname'];
		$deliverylastname = $order->delivery['lastname'] != '' ? $order->delivery['lastname'] : $order->billing['lastname'];
		$deliveryname =   $deliveryfirstname . $deliverylastname;
		$deliveryaddress  = $order->delivery['street_address'];
		$deliverycountry =  $order->delivery['country']['iso_code_2'];
		$deliverystate =   $order->delivery['state'];
		$deliverycity =   $order->delivery['city'];
		$deliveryemail =  $order->customer['email_address'];
		$deliveryphone =  $order->customer['telephone'];
		$deliverypost =  $order->delivery['postcode'];
		$strProduct = '';
		$strProducts = '';
	 for ($i=0; $i<sizeof($order->products)&&$i<=50; $i++) {
        $price_unit = zen_round($order->products[$i]['price'] * $currencies->currencies[$currency]['value'],2);
	    $strProducts = $strProducts . $this->utf8_htmldecode($order->products[$i]["name"]).$this->utf8_htmldecode($order->products[$i]['id']). $order->products[$i]["qty"].$price_unit;
        $strProduct = $strProduct . '<input type="hidden" name="'. productname.($i+1) .'" value="'. $this->utf8_htmldecode($order->products[$i]["name"]) .'" />'.
			                        '<input type="hidden" name="'. productsn.($i+1) .'" value="'. $this->utf8_htmldecode($order->products[$i]['id']) .'" />'.
									'<input type="hidden" name="'. quantity.($i+1) .'" value="'. $order->products[$i]["qty"] .'" />'.
									'<input type="hidden" name="'. unit.($i+1) .'" value="'. $price_unit .'" />';
    }
		$remark1 = $order_id;
		$remark2 = '';
		$remark3 = '';
		$value=$value=$version . $encoding . $strlang . MODULE_PAYMENT_HPAY_MERCHANTID .
           $orderid . $datestr . $currency . $amount . 'ic' . $strServerUrl . 
           $strBrowserurl . $strAccessurl . $remark1 . $remark2 . $remark3 . $strProducts .
           $shipfee . $billaddress . $billcountry . $billstate . $billcity . 
           $billemail . $billphone . $billpost . 
           $deliveryname . $deliveryaddress . $deliverycountry .
           $deliverystate . $deliverycity . $deliveryemail . $deliveryphone . $deliverypost;
		$value = MODULE_PAYMENT_HPAY_HASHKEY . $value;
		$signature = md5($value);
		$this->write_log('Md5 source string is ' . $value);
		$process_button_string = '<input type="hidden" name="version" value="' .$this->utf8_htmldecode($version). '" />'.  
		                     '<input type="hidden" name="encoding" value="' .$this->utf8_htmldecode($encoding). '" />'.
	                         '<input type="hidden" name="language" value="' .$this->utf8_htmldecode($strlang). '" />'.
							 '<input type="hidden" name="merchantid" value="' .MODULE_PAYMENT_HPAY_MERCHANTID. '" />'.
							 '<input type="hidden" name="orderid" value="' .$this->utf8_htmldecode($orderid). '" />'.
							 '<input type="hidden" name="orderdate" value="' .$this->utf8_htmldecode($datestr). '" />'.
							 '<input type="hidden" name="currency" value="' .$this->utf8_htmldecode($currency). '" />'.
							 '<input type="hidden" name="orderamount" value="' .$this->utf8_htmldecode($amount). '" />'.
							 '<input type="hidden" name="transtype" value="' .$this->utf8_htmldecode(ic). '" />'.
							 '<input type="hidden" name="callbackurl" value="' .$this->utf8_htmldecode($strServerUrl). '" />'.
							 '<input type="hidden" name="browserbackurl" value="' .$this->utf8_htmldecode($strBrowserurl). '" />'.
							 '<input type="hidden" name="accessurl" value="' .$this->utf8_htmldecode($strAccessurl). '" />'.
							 '<input type="hidden" name="remark1" value="' .$this->utf8_htmldecode($remark1). '" />'.
							 '<input type="hidden" name="remark2" value="' .$this->utf8_htmldecode($remark2). '" />'.
							 '<input type="hidden" name="remark3" value="' .$this->utf8_htmldecode($remark3). '" />'. $strProduct .
							 '<input type="hidden" name="shippingfee" value="' .$this->utf8_htmldecode($shipfee). '" />'.
							 '<input type="hidden" name="billaddress" value="' .$this->utf8_htmldecode($billaddress). '" />'.
							 '<input type="hidden" name="billcountry" value="' .$this->utf8_htmldecode($billcountry). '" />'.
							 '<input type="hidden" name="billprovince" value="' .$this->utf8_htmldecode($billstate). '" />'.
							 '<input type="hidden" name="billcity" value="' .$this->utf8_htmldecode($billcity). '" />'.
							 '<input type="hidden" name="billemail" value="' .$this->utf8_htmldecode($billemail). '" />'.
							 '<input type="hidden" name="billphone" value="' .$this->utf8_htmldecode($billphone). '" />'.
							 '<input type="hidden" name="billpost" value="' .$this->utf8_htmldecode($billpost). '" />'.
							 '<input type="hidden" name="deliveryname" value="' .$this->utf8_htmldecode($deliveryname). '" />'.
							 '<input type="hidden" name="deliveryaddress" value="' .$this->utf8_htmldecode($deliveryaddress). '" />'.
							 '<input type="hidden" name="deliverycountry" value="' .$this->utf8_htmldecode($deliverycountry). '" />'.
							 '<input type="hidden" name="deliveryprovince" value="' .$this->utf8_htmldecode($deliverystate). '" />'.
							 '<input type="hidden" name="deliverycity" value="' .$this->utf8_htmldecode($deliverycity). '" />'.
							 '<input type="hidden" name="deliveryemail" value="' .$this->utf8_htmldecode($deliveryemail). '" />'.
							 '<input type="hidden" name="deliveryphone" value="' .$this->utf8_htmldecode($deliveryphone). '" />'.
							 '<input type="hidden" name="deliverypost" value="' .$this->utf8_htmldecode($deliverypost). '" />'.
							 '<input type="hidden" name="signature" value="' .$this->utf8_htmldecode($signature). '" />';
                             $this->write_log('Request form to HPAY is :' . $process_button_string);
                             //unset($_SESSION['order_id']);
	                          return $process_button_string;
							}
	function before_process() {
		die();

	}
	function after_process() {
		$this->write_log('Begin do after_process()');
		global $insert_id, $db;
		$sql_data_array = array(
        'orders_id' => (int)$insert_id,
        'orders_status_id' => $this->status,
        'date_added' => 'now()',
        'comments' => 'HPAY OrderID:'. $this->HPAYid. ' - PayCurrency: '. $this->paycurrency . ' - PayAmount: ' . $this->payamount
		);
		zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
		$_SESSION['order_created'] = '';
		return true;
	}
	function output_error() {
		return false;
	}
	function check() {
		global $db;
		if(!isset($this->_check))
		{
			$check_query=$db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_HPAY_STATUS'");
			$this->_check=$check_query->RecordCount();
		}
		return $this->_check;
	}
	function install() {
		global $db, $language, $module_type;
		if (!defined('MODULE_PAYMENT_HPAY_TEXT_CONFIG_1_1')) {
			$lang_file = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $this->code . '.php';
			if ( file_exists($lang_file)) {
				include($lang_file);
			} else { //load default lang file
				include(DIR_FS_CATALOG_LANGUAGES . 'english' . '/modules/' . $module_type . '/' . $this->code . '.php');
			}
		}
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_HPAY_STATUS', 'True', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_1_2 . "', '9', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_2_1 . "', 'MODULE_PAYMENT_HPAY_MERCHANTID', '', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_2_2 . "', '9', '2', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_3_1 . "', 'MODULE_PAYMENT_HPAY_HASHKEY', '', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_3_2 . "', '9', '3', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_4_1 . "', 'MODULE_PAYMENT_HPAY_ZONE', '0', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_4_2 . "', '9', '4', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_5_1 . "', 'MODULE_PAYMENT_HPAY_PROCESSING_STATUS_ID', '2', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_5_2 . "', '9', '5', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_6_1 . "', 'MODULE_PAYMENT_HPAY_ORDER_STATUS_ID', '1', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_6_2 . "', '9', '6', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_7_1 . "', 'MODULE_PAYMENT_HPAY_SORT_ORDER', '0', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_7_2 . "', '9', '7', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_8_1 . "', 'MODULE_PAYMENT_HPAY_HANDLER', 'Live', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_8_2 . "', '9', '8', 'zen_cfg_select_option(array(\'Live\', \'Test\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_9_1 . "', 'MODULE_PAYMENT_HPAY_DEBUG', 'False', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_9_2 . "', '9', '9', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_10_1 . "', 'MODULE_PAYMENT_HPAY_ORDER_PREFIX', '', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_10_2 . "', '9', '10',  now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_12_1 . "', 'MODULE_PAYMENT_HPAY_URL', 'https://pay.91HPAY.com/Payment/PayPage.aspx', '" . MODULE_PAYMENT_HPAY_TEXT_CONFIG_12_2 . "', '9', '12', now())");
	}
	function keys() {
		return array(
        'MODULE_PAYMENT_HPAY_STATUS',
        'MODULE_PAYMENT_HPAY_MERCHANTID',
        'MODULE_PAYMENT_HPAY_HASHKEY',
        'MODULE_PAYMENT_HPAY_ZONE',
        'MODULE_PAYMENT_HPAY_PROCESSING_STATUS_ID',
        'MODULE_PAYMENT_HPAY_ORDER_STATUS_ID',
        'MODULE_PAYMENT_HPAY_SORT_ORDER',
        'MODULE_PAYMENT_HPAY_HANDLER',
        'MODULE_PAYMENT_HPAY_DEBUG',
        'MODULE_PAYMENT_HPAY_ORDER_PREFIX',
        'MODULE_PAYMENT_HPAY_URL'
        );
	}
	function remove() {
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE  'MODULE_PAYMENT_HPAY%'");
		$db->Execute("DROP TABLE IF EXISTS HPAY");
		$db->Execute("DROP TABLE IF EXISTS HPAY_session");
	}
	function write_log($msg) {
		if(MODULE_PAYMENT_HPAY_DEBUG==true) {
			error_log(date("[Y-m-d H:i:s]")."\t" .$msg ."\r\n", 3, './logs/HPAY'.date("Y-m-d").'.log');
		}
		return true;
	}
function utf8_htmldecode($str){
	 $str=str_replace("&","&amp;",$str);
	 $str=str_replace("\"","&quot;",$str);
	 $str=str_replace("<","&lt;",$str);
	 $str=str_replace(">","&gt;",$str);
	 $str=str_replace("'","&#39;",$str);
	 return $str;
}
function filter_code($str){
   //$str=mb_convert_encoding ( $str,"UTF-8","UTF-8"); //该方法需要确认php中php.ini里将; extension=php_mbstring.dll 前面的 ; 去掉
   if($str==null||$str==""){
	   return "";
	   }
   else{
	$str=str_split($str);
   for($ii=0;$ii<count($str);$ii++){ 
	  if(ord($str[$ii])<32 || ord($str[$ii])>127){
		  $str[$ii]='*';
	  }
	  }
   }
   $str=implode('',$str);
   return $str;
}
	
	//end of class
}
?>
