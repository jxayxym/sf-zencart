<?php
class ReturnMoneyCustomer{
	var $customers_id = '';
	var $consumption = '';
	var $rebate_points ='';
	var $credits ='';
	var $level = '';
	
	function ReturnMoneyCustomer($customers_id){
		$this->customers_id = $customers_id;
		$this->consumption = $this->getConsumption();
		$this->rebate_points = $this->getRebatePoints();
		$this->credits = $this->getCredits();
		$this->level = $this->getLevel();
		if ($check = $this->_checkRebatePoints()){
			$this->_setRebatePoins($check);
		}
		$this->_checkReturnMoney();
		
		
	}
	//获得等级
	function getLevel(){
		global $db;
		if ($this->credits=='')
			$credits = $this->getCredits();
		else 
			$credits = $this->credits;
		$sql = 'select * from '.TABLE_FANLI_DENGJI.' where jifen<'.(int)$credits.' order by jifen DESC Limit 0,1';
		$r = $db->Execute($sql);
		$dengji_mingcheng = array('dengji_id'=>$r->fields['fanli_dengji_id'],'dengji_mingcheng'=>$r->fields['dengji_mingcheng']);
		return $dengji_mingcheng;
	}
	//获得总积分值
	function getCredits(){
		global $db;
		if (empty($this->customers_id))
			return false;
		$sql = 'select o.payment_module_code,o2p.products_price,o2p.products_quantity,o.currency_value,o.orders_status from ' .
				TABLE_ORDERS . ' o join ' . TABLE_ORDERS_PRODUCTS . ' o2p on o.orders_id=o2p.orders_id ' .
			    'where o.customers_id='.(int)$this->customers_id.' and o.orders_status=3';
		$r = $db->Execute($sql);
		$credits = 0;
		while (!$r->EOF){
			$credits_convert_rate = ReturnMoneyCredits::getCreditsConvertRate($r->fields['payment_module_code']);//积分转换率
			$price_usd = $r->fields['products_price']/$r->fields['currency_value'];//货币值转化成美元
			$credits += ($price_usd*$credits_convert_rate)*$r->fields['products_quantity'];
			
			$r->MoveNext();
		}
		return round($credits,0);
	}
	//总消费
	function getConsumption(){
		global $db;
		if (empty($this->customers_id))
			return false;	
		$sql = 'select o.payment_module_code,o2p.products_price,o2p.products_quantity,o.currency_value,o.orders_status from ' .
				TABLE_ORDERS . ' o join ' . TABLE_ORDERS_PRODUCTS . ' o2p on o.orders_id=o2p.orders_id ' .
			    'where o.customers_id='.(int)$this->customers_id.' and o.orders_status=3';
		$r = $db->Execute($sql);
		$total = 0;
		while (!$r->EOF){
			$total += ($r->fields['products_price']/$r->fields['currency_value'])*$r->fields['products_quantity'];;//货币值转化成美元
			
			$r->MoveNext();
		}		
		return round($total,0);
	}
	//总共提现多少
	function getTotalWithdrawed(){
		global $db;
		$sql = 'select sum(jinqian) as sum from '.TABLE_FANLI_TIXIAN .' where customers_id='.(int)$this->customers_id.' and status>=100';
		$r = $db->Execute($sql);
		return $r->fields['sum'];
	}
	//返利点
	function getRebatePoints(){
		$total_consumption = $this->getConsumption();//总消费
		$fanli_configure = ReturnMoneyConfigure::getConfigure();
		$rebate_points = floor($total_consumption/$fanli_configure['jinqian']);
		return $rebate_points;
	}
	//获得总返利金额
	function getTotalRebate(){
		global $db;
		$sql = 'select *  from '.TABLE_FANLI_CUSTOMERS_FANLIDIAN.' cf join '.TABLE_FANLI_CUSTOMERS_FANLIDIAN_FANLI.' cff '.
			   'on cf.fanlidian_id=cff.fanlidian_id where cf.customers_id='.(int)$this->customers_id;
		$r = $db->Execute($sql);
		$total = 0;
		while (!$r->EOF){
			$configure = unserialize($r->fields['fanli_configure']);
			$fanli_end = date('Y-m-d',strtotime($r->fields['add_date'])+$configure['fanli_tianshu']*24*60*60);//返利结束日期
			
			if ($r->fields['fanli_date']<=$fanli_end&&$r->fields['fanli_date']>$r->fields['add_date'])
				$total += $r->fields['jinqian'];
			$r->MoveNext();	
		}
		return $total;
	}
	
	//获得一个返利点
	private function _setRebatePoins($points=0){
		global $db;
		$fanli_configure = serialize(ReturnMoneyConfigure::getConfigure());//序列化配置
		for ($i=0;$i<$points;$i++){
			$sql = 'insert into ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN . ' values (NULL,'.$this->customers_id.',\''.date('Y-m-d').'\',\''.addslashes($fanli_configure).'\',0)';
			$db->Execute($sql);
		}	
	}
	//检测返利点记录时否有错
	private function _checkRebatePoints(){
		global $db;
		$sql = 'select * from ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN . ' where customers_id='.(int)$this->customers_id;
		$r = $db->Execute($sql);
		if ($r->RecordCount()<$this->rebate_points)
			return $this->rebate_points-$r->RecordCount();
		else 
			return 0;	
	}
	//检测返利记录,是否没天都有返利
	private function _checkReturnMoney(){
		global $db;
		$sql = 'select * from ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN . ' where customers_id='.(int)$this->customers_id;
		$r1 = $db->Execute($sql);
		while (!$r1->EOF){
			$configure = unserialize($r1->fields['fanli_configure']);
			$fanli_tianshu = $configure['fanli_tianshu'];//应该返利的天数
			$fanli_start = $r1->fields['add_date'];
			
			$yifanli_tianshu = floor((time()-strtotime($fanli_start))/(24*60*60));//实际应返天数
			$yifanli_tianshu = $yifanli_tianshu<0?0:$yifanli_tianshu;//实际应返天数
			$yifanli_tianshu = $yifanli_tianshu>$fanli_tianshu?$fanli_tianshu:$yifanli_tianshu;
			
			$fanlidian_id = $r1->fields['fanlidian_id'];
			
			$sql = 'select * from ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN_FANLI .' where fanlidian_id=' . (int)$fanlidian_id;
			$r2 = $db->Execute($sql);
			
			if ($r2->RecordCount()!=$yifanli_tianshu){
				for ($i=1;$i<=$yifanli_tianshu;$i++){
					$date = date('Y-m-d',strtotime($fanli_start)+$i*24*60*60);
					$sql = 'select * from ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN_FANLI . ' where fanlidian_id=' .$fanlidian_id .' and fanli_date=\''.$date.'\'';
					
					$r3 = $db->Execute($sql);
					if ($r3->RecordCount()==0){
						$jinqian = ReturnMoneyConfigure::getRebateByLevel($this->level['dengji_id']);
						
						$sql = 'insert into ' . TABLE_FANLI_CUSTOMERS_FANLIDIAN_FANLI . ' values ('.$fanlidian_id.',\''.$date.'\','.$jinqian.',\''.date('Y-m-d H:i:s').'\')';
						$db->Execute($sql);
					}
				}
			}
			$r1->MoveNext();
		}
	}
}