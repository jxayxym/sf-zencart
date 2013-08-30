<?php
class ReturnMoneyOrder{
	function ReturnMoneyOrder(){
	
	}
	
	static function getCredits($orders_id=''){
		global $db;
		$sql = 'select o.customers_id,o.payment_module_code,sum(products_price) as total_products_price,o.currency_value,o.orders_status from '.TABLE_ORDERS.' o join '.TABLE_ORDERS_PRODUCTS.' o2p on o.orders_id=o2p.orders_id '.
			   'where o.orders_id='.(int)$orders_id;
		$r = $db->Execute($sql);
		if ($r->fields['orders_status']==3){
			$total_products_price = round($r->fields['total_products_price']/$r->fields['currency_value'],0);//商品总价
			$sql = 'select * from '.TABLE_FANLI_GUIZE_JIFEN.' where zhifufangshi=\'不限\' or zhifufangshi=\''.$r->fields['payment_module_code'].'\'';
			$r = $db->Execute($sql);
			if ($r->RecordCount()){
				$jifen = round(($total_products_price/$r->fields['jinqian'])*$r->fields['jifen'],0);
				return $jifen;
			}else{
				return 0;
			}			
		}else
			return 0;
	}
	
}