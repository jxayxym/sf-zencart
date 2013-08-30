<?php
class address_book extends base{
	function __construct(){
		$this->attach($this, 
				array(
						'NOTIFY_MODULE_ADDRESS_BOOK_ADDED_ADDRESS_BOOK_RECORD',
						'NOTIFY_MODULE_ADDRESS_BOOK_UPDATED_ADDRESS_BOOK_RECORD',
						)
				);
	}
	
	function update(&$class, $eventID, $paramsArray = array()){
		global $db;
		if ($eventID=='NOTIFY_MODULE_ADDRESS_BOOK_ADDED_ADDRESS_BOOK_RECORD' ||
			$eventID=='NOTIFY_MODULE_ADDRESS_BOOK_UPDATED_ADDRESS_BOOK_RECORD'){
			
			$address_id = $eventID=='NOTIFY_MODULE_ADDRESS_BOOK_ADDED_ADDRESS_BOOK_RECORD'?$paramsArray['address_id']:$paramsArray['address_book_id'];
			$query_sql = 'select * from '.TABLE_EXT_ADDRESS_BOOK.' where address_book_id='.$address_id;

			$r = $db->Execute($query_sql);
			$telephone = zen_db_prepare_input($_POST['telephone']);
			if ($r->RecordCount()>0){
				$db->perform(TABLE_EXT_ADDRESS_BOOK, 
						array(
							array('fieldName'=>'entry_telephone','value'=>$telephone,'type'=>'string'),
						),						
						'update', 'address_book_id='.$address_id);
			}else{
				$db->perform(TABLE_EXT_ADDRESS_BOOK, 
						array(
							array('fieldName'=>'address_book_id','value'=>$address_id,'type'=>'integer'),
							array('fieldName'=>'entry_telephone','value'=>$telephone,'type'=>'string'),
						)
				);
			}
			$sql = 'select * from '.TABLE_ADDRESS_BOOK.' where customers_id='.(int)$_SESSION['customer_id'];
			$r = $db->Execute($sql);
			if ($r->RecordCount()==1){
				$db->perform(TABLE_CUSTOMERS,
						array(
								array('fieldName'=>'customers_gender','value'=>$r->fields['entry_gender'],'type'=>'string'),
								array('fieldName'=>'customers_firstname','value'=>$r->fields['entry_firstname'],'type'=>'string'),
								array('fieldName'=>'customers_lastname','value'=>$r->fields['entry_lastname'],'type'=>'string'),
								array('fieldName'=>'customers_default_address_id','value'=>$address_id,'type'=>'integer'),
								array('fieldName'=>'customers_telephone','value'=>$telephone,'type'=>'string'),
						),
						'update',
						'customers_id='.(int)$_SESSION['customer_id']
				);
				$_SESSION['customer_default_address_id'] = $address_id;
			}
		}
	}
	
}