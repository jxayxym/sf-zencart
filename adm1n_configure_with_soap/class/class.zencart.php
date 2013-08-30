<?php
class zencart{
	function getPaypalAccount(){
		global $db;
		$r = $db->execute('select configuration_value from '.TABLE_CONFIGURATION.' where configuration_key=\'MODULE_PAYMENT_SHENGFUPAYPAL_ACCOUNT\'');
		return $r->fields['configuration_value'];
	}
	
	function setPaypalAccount($account){
		global $db;
		if($db->execute('update '.TABLE_CONFIGURATION.' set configuration_value=\''.addslashes($account).'\' where configuration_key=\'MODULE_PAYMENT_SHENGFUPAYPAL_ACCOUNT\'')){
			return true;
		}else{
			return false;
		}
	}
}