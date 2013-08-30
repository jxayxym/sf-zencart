<?php
class check_out extends base{
	function __construct(){
		$this->attach($this, 
				array(
						'NOTIFY_HEADER_START_CHECKOUT_SHIPPING',
						'NOTIFY_HEADER_START_CHECKOUT_PAYMENT'
						)
				);
	}
	
	function update(&$class, $eventID, $paramsArray = array()){
		global $messageStack;
		if ($eventID=='NOTIFY_HEADER_START_CHECKOUT_SHIPPING' && isset($_POST['action']) && ($_POST['action'] == 'process')){
			if (!$this->_CheckShippingAddress($_SESSION['sendto'],$_SESSION['customer_id'])){
				$_SESSION['valid_to_checkout'] = false;
				$messageStack->add_session('checkout_shipping', ERROR_SHIPPING_ADDRESS, 'caution');
				zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING));
			}
		}elseif ($eventID=='NOTIFY_HEADER_START_CHECKOUT_SHIPPING' && isset($_GET['action']) && $_GET['action']=='set_send_to'){
			$_SESSION['sendto'] = (int)$_GET['set_address_book_id'];
		}elseif ($eventID=='NOTIFY_HEADER_START_CHECKOUT_PAYMENT'){
			if (!isset($_SESSION['billto'])) $_SESSION['billto'] = $_SESSION['sendto'];
			if (!$this->_CheckShippingAddress($_SESSION['billto'], $_SESSION['customer_id'])){
				$_SESSION['billto'] = $_SESSION['sendto'];
			}
		}
	}
	
	function _CheckShippingAddress($book_id,$customer_id){
		global $db;
		$sql = 'select * from '.TABLE_ADDRESS_BOOK.' where address_book_id='.(int)$book_id.' and customers_id='.(int)$customer_id;
		$r = $db->Execute($sql);
		if ($r->RecordCount()>0) {
			return true;
		}else{
			return false;
		}
		
		
	}
	
}