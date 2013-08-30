<?php
class IpBlocker{
	var $ip;
	
	function __construct(){
		$this->ip = $this->_ipStrToInt($_SERVER['REMOTE_ADDR']);
	}
	function check(){
        global $spider_flag;
        return;
       	if ($this->_isReject()&&$spider_flag==false){
			header('HTTP/1.1 403 Forbidden');
            exit;
		}
	}	
	function _isReject(){
		global $db;
		if (isset($_SESSION['ip_block']) && $_SESSION['ip_block']==0)
			return false;
		elseif (isset($_SESSION['ip_block']) && $_SESSION['ip_block']==1)
			return true;
				
		if (empty($this->ip)) 
			return true;	
		$sql = "select * from ".TABLE_IP_BLOCK." where ip_from<={$this->ip} and ip_to>={$this->ip} and blocked=1";
//		echo $sql;exit;
		$r = $db->Execute($sql);
		if ($r->RecordCount()>0){
			$_SESSION['ip_block'] = 1;
			return true;
		}else{
			$_SESSION['ip_block'] = 0;
			return false;
		}
		
	}

	function _ipStrToInt($ip){
		
		if (!preg_match('/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/', $ip))
			return 0;
			
		$ip_8bin = explode('.', $ip);
		$i = 24;
		$return = 0;
		foreach ($ip_8bin as $entry){
			$return += (int)$entry*pow(2,$i);
			$i = $i-8;
		}
		return $return;	
	}
}