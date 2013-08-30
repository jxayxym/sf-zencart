<?php
function zen_get_address_book_telephone($book_id){
	global $db;
	$sql = 'select entry_telephone from '.TABLE_EXT_ADDRESS_BOOK.' where address_book_id='.$book_id;
	$r = $db->Execute($sql);
	return $r->fields['entry_telephone'];
}

function sf_get_customers_address_book($customer_id){
	global $db;
	
	$customer_address_book_count_query = "SELECT c.*, ab.* from " .
			TABLE_CUSTOMERS . " c join " . TABLE_ADDRESS_BOOK . " ab on c.customers_id = ab.customers_id
			join ".TABLE_EXT_ADDRESS_BOOK." eab on eab.address_book_id = ab.address_book_id WHERE c.customers_id = '" . (int)$customer_id . "'";
	
	$customer_address_book_count = $db->Execute($customer_address_book_count_query);
	return $customer_address_book_count;
	
}