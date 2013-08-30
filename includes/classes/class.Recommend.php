<?php
//会员推荐系统类
class Recommend extends base{
	function Recommend(){
		global $zco_notifier,$db;
		if ($_GET['recommend_id']!=''&&((int)$_GET['recommend_id'])!=$_SESSION['customer_id']){
			if ($this->_validateCustomerExist($_GET['recommend_id'])){
				$_SESSION['recommend_id'] = (int)$_GET['recommend_id'];
				unset($_GET['recommend_id']);
			}	
		}
		$zco_notifier->attach($this, array('NOTIFY_HEADER_START_CREATE_ACCOUNT_SUCCESS'));
	}
	
  	function update(&$class, $eventID, $paramsArray) {
  		global $db;
  		if ($eventID=='NOTIFY_HEADER_START_CREATE_ACCOUNT_SUCCESS'){
  			if ($this->_validateCustomerExist($_SESSION['customer_id']) && $this->_validateCustomerExist($_SESSION['recommend_id']) && !$this->_haveRecommend($_SESSION['customer_id']) ){
  				$sql = 'insert into ' . TABLE_RECOMMEND . ' values('.$_SESSION['customer_id'].','.$_SESSION['recommend_id'].')';
  				$db->Execute($sql);
  			}
  		}
  	}
  	//判断ID是否已存在有推荐人	
  	private function _haveRecommend($customer_id){
  		global $db;
  		$sql = 'select * from ' . TABLE_RECOMMEND .' where customers_id='.(int)$customer_id;
  		$r = $db->Execute($sql);
  		return $r->RecordCount()>0?true:false;  		
  	}
  	private function _validateCustomerExist($customer_id=0){
  		global $db;
  		$sql = 'select * from ' . TABLE_CUSTOMERS .' where customers_id='.(int)$customer_id;
  		$r = $db->Execute($sql);
  		return $r->RecordCount()>0?true:false;
  	}
}