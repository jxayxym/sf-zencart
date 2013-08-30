<?php
class ReturnMoneyConfigure{
	function ReturnMoneyConfigure(){
		
	}
	
	static function getConfigure(){
		global $db;
		$sql = 'select * from '.TABLE_FANLI_GUIZE_CONFIGURE.' Limit 0,1';
		$r = $db->Execute($sql);
		$configure = array(
			'jinqian'=>$r->fields['jinqian'],
			'fanli_tianshu'=>$r->fields['fanli_tianshu'],
			'fanli_zhouqi'=>$r->fields['fanli_zhouqi'],
			'min_withdraw'=>$r->fields['min_withdraw'],
		);
		return $configure;
	}
	
	//取得等级对应的返利金额
	static function getRebateByLevel($dengji_id){
		global $db;
		$sql = 'select * from '.TABLE_FANLI_DENGJI.' where fanli_dengji_id='.$dengji_id.' Limit 0,1';		
		$r = $db->Execute($sql);
		return $r->fields['jinqian'];
	}
	
}