<?php
class LoginWith extends base{
	function LoginWith(){
		global $zco_notifier, $messageStack;
		$zco_notifier->attach($this, array('NOTIFY_LOGIN_WITH_GOOGLE_SUCCESS','NOTIFY_LOGIN_WITH_FACEBOOK_SUCCESS','NOTIFY_LOGIN_WITH_HOTMAIL_SUCCESS'));
		if ($_SESSION['customer_id']!='' && !$this->_isHaveEmail($_SESSION['customer_id'])){
			$messageStack->add('header','Your account have no email,please add it immediately!<a href="'.zen_href_link(FILENAME_ACCOUNT_EDIT).'" style="font-size:18px;">Go,Now!</a>','caution');
		}
	}
	
	function update(&$class, $eventID, $paramsArray){
		if ($eventID=='NOTIFY_LOGIN_WITH_GOOGLE_SUCCESS'){
			$this->_login_with_google($paramsArray);
		}elseif ($eventID=='NOTIFY_LOGIN_WITH_FACEBOOK_SUCCESS'){
			$this->_login_with_facebook($paramsArray);
		}elseif ($eventID=='NOTIFY_LOGIN_WITH_HOTMAIL_SUCCESS'){
			$this->_login_with_hotmail($paramsArray);
		}
	}
	
	function _login_with_google($info){
		global $db;
		$login_type = 'google';
		$where = array(
			'login_with_type'=>array(
				'fieldName'=>'login_with_type',
				'value'=>$login_type,
				'type'=>'string'
			),
			'login_with_id'=>array(
				'fieldName'=>'login_with_id',
				'value'=>$info['id'],
				'type'=>'string'
			)
		);
		if (!$this->_exist($where)){
			$customer_data = array();
			$social_account_data = array();
			$customers_gender = $info['gender']=='male'?'m':'f';
			$customer_data['customers_email_address'] = array('fieldName'=>'customers_email_address','value'=>$info['email'],'type'=>'string');
			$customer_data['customers_firstname'] = array('fieldName'=>'customers_firstname','value'=>$info['given_name'],'type'=>'string');
			$customer_data['customers_lastname'] = array('fieldName'=>'customers_lastname','value'=>$info['family_name'],'type'=>'string');
			$customer_data['customers_gender'] = array('fieldName'=>'customers_gender','value'=>$customers_gender,'type'=>'string');

			$social_account_data = array(
				'login_with_type'=>array('fieldName'=>'login_with_type','value'=>$login_type,'type'=>'string'),
				'login_with_id'=>array('fieldName'=>'login_with_id','value'=>$info['id'],'type'=>'string'),
			);
			$this->_register($customer_data, $social_account_data);
		}
		$this->_login($where);
	}
	
	function _login_with_hotmail($info){
		global $db;
		$login_type = 'hotmail';
		$where = array(
			'login_with_type'=>array(
					'fieldName'=>'login_with_type',
					'value'=>$login_type,
					'type'=>'string'
			),
			'login_with_id'=>array(
					'fieldName'=>'login_with_id',
					'value'=>$info['id'],
					'type'=>'string'
			)
		);
		if (!$this->_exist($where)){
			$customer_data = array();
			$social_account_data = array();
			$customers_gender = $info['gender']=='male'?'m':'f';
			$customer_data['customers_email_address'] = array('fieldName'=>'customers_email_address','value'=>$info['emails']['account'],'type'=>'string');
			$customer_data['customers_firstname'] = array('fieldName'=>'customers_firstname','value'=>$info['first_name'],'type'=>'string');
			$customer_data['customers_lastname'] = array('fieldName'=>'customers_lastname','value'=>$info['last_name'],'type'=>'string');
			$customer_data['customers_gender'] = array('fieldName'=>'customers_gender','value'=>$customers_gender,'type'=>'string');
	
			$social_account_data = array(
					'login_with_type'=>array('fieldName'=>'login_with_type','value'=>$login_type,'type'=>'string'),
					'login_with_id'=>array('fieldName'=>'login_with_id','value'=>$info['id'],'type'=>'string'),
			);
			$this->_register($customer_data, $social_account_data);
		}
		$this->_login($where);
	}
		
	function _login_with_facebook($info){
		global $db;
		$login_type = 'facebook';
		$where = array(
			'login_with_type'=>array(
				'fieldName'=>'login_with_type',
				'value'=>$login_type,
				'type'=>'string'
			),
			'login_with_id'=>array(
				'fieldName'=>'login_with_id',
				'value'=>$info['id'],
				'type'=>'string'
			)
		);

		if (!$this->_exist($where)){
			$customer_data = array();
			$social_account_data = array();
			
			$customers_gender = $info['gender']=='male'?'m':'f';
			$customer_data['customers_firstname'] = array('fieldName'=>'customers_firstname','value'=>$info['first_name'],'type'=>'string');
			$customer_data['customers_lastname'] = array('fieldName'=>'customers_lastname','value'=>$info['last_name'],'type'=>'string');
			$customer_data['customers_gender'] = array('fieldName'=>'customers_gender','value'=>$customers_gender,'type'=>'string');
	
			$social_account_data = array(
				'login_with_type'=>array('fieldName'=>'login_with_type','value'=>$login_type,'type'=>'string'),
				'login_with_id'=>array('fieldName'=>'login_with_id','value'=>$info['id'],'type'=>'string'),
			);
			$this->_register($customer_data, $social_account_data);
		}
		$this->_login($where);
	}
	
	private function _register($customer_data,$social_account_data){
		global $db;
		$db->perform(TABLE_CUSTOMERS,$customer_data);
		$customers_id = $db->insert_ID();
		$social_account_data['customers_id'] = array('fieldName'=>'customers_id','value'=>$customers_id,'type'=>'integer');
		$db->perform(TABLE_CUSTOMERS_LOGIN_WITH,$social_account_data);
		
	}
	private function _login($where){
		global $db;
		$fields = array();
		foreach ($where as $field=>$entry){
			$fields[] = $field.'='.$db->getBindVarValue($entry['value'],$entry['type']);
		}
		$sql = 'select customers_id from '.TABLE_CUSTOMERS_LOGIN_WITH .' where '.implode(' and ', $fields);
		
		$r = $db->Execute($sql);
				
	    $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
	                                    customers_email_address, customers_default_address_id,
	                                    customers_authorization, customers_referral
	                           FROM " . TABLE_CUSTOMERS . "
	                           WHERE customers_id=".$r->fields['customers_id'];
	    $check_customer = $db->Execute($check_customer_query);
	    
        $check_country_query = "SELECT entry_country_id, entry_zone_id
                              FROM " . TABLE_ADDRESS_BOOK . "
                              WHERE customers_id = :customersID
                              AND address_book_id = :addressBookID";
        
        $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields['customers_id'], 'integer');
        $check_country_query = $db->bindVars($check_country_query, ':addressBookID', $check_customer->fields['customers_default_address_id'], 'integer');
        $check_country = $db->Execute($check_country_query);
        
        $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
        $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
        $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
        $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
        $_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
        $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
        $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];

        $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
              SET customers_info_date_of_last_logon = now(),
                  customers_info_number_of_logons = customers_info_number_of_logons+1
              WHERE customers_info_id = :customersID";

        $sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
        $db->Execute($sql);        
	}
	
	private function _exist($where){
		global $db;
		if (is_array($where)){
			$fields = array();
			foreach ($where as $field=>$entry){
				$fields[] = $field.'='.$db->getBindVarValue($entry['value'],$entry['type']);
			}
			$sql = 'select count(*) as count from '. TABLE_CUSTOMERS_LOGIN_WITH .' where '.implode(' and ', $fields);
//			echo $sql,'<br />';
			$r_count = $db->Execute($sql);
			return $r_count->fields['count']>0?true:false;
		}else {
			return false;
		}
	}
	
	private function _isHaveEmail($cusotmers_id){
		global $db;
		$sql = "SELECT * FROM " . TABLE_CUSTOMERS . "
	                           WHERE customers_id=".(int)$cusotmers_id.' AND customers_email_address!=\'\'';
		$r = $db->Execute($sql);
		if ($r->RecordCount()>0)
			return true;
		else
			return false;
			
		
	}
}