<?php
class ReturnMoneyCredits{
	
	function ReturnMoneyCredits(){
	
	}
	// 100$/1$=X/m
	static function getCreditsConvertRate($payment_method){
		global $db;
		$sql = 'select * from '.TABLE_FANLI_GUIZE_JIFEN.' where zhifufangshi=\''.$payment_method.'\'';
		$r = $db->Execute($sql);
		if ($r->RecordCount()){
			$rate = $r->fields['jifen'];
		}else{
			$sql = 'select * from '.TABLE_FANLI_GUIZE_JIFEN.' where zhifufangshi=\'不限\'';
			$r = $db->Execute($sql);
			$rate = (!$r->EOF?$r->fields['jifen']:0);
		}
		return $rate;
	}
	
}