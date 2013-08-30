<?php
class db{
	private $_link;
	private $_hostname;
	private $_username;
	private $_password;
	private $_database;
	private $_db_chartset;
	
	public function __construct($hostname,$username,$password,$database,$db_chartset){
		if ($this->_link = @mysql_connect($hostname,$username,$password)){
			@mysql_query("SET NAMES '" . $db_chartset . "'", $this->link);
			@mysql_select_db($database,$this->_link);
		}
	}
	
	public function execute($sql){
		if (!$this->_link){
			$n = 0;//尝试重新链接10次
			while (!$this->_link && $n<10){
				$this->_link = @mysql_connect($this->_hostname,$this->_username,$this->_password);
				++$n;
			}
			if($this->_link){
				@mysql_query("SET NAMES '" . $this->_db_chartset . "'", $this->link);
				@mysql_select_db($this->_database,$this->_link);
			}
		}
		if ($this->_link){
			$result = mysql_query($sql,$this->_link);
			if (is_resource($result)){
				$query_result = new queryResult($result);
				return $query_result;
			}elseif (is_bool($result)){
				return $result;
			}
		}else 
			return false;
	}
}

class queryResult {
	public $resource;
	public $fields;
	public $EOF = true;
	
	function __construct($resource){
		$row = @mysql_fetch_assoc($resource);
		if (!$row) {
			$this->EOF = true;
		}else{
		    while (list($key, $value) = each($row)) {
           		$this->fields[$key] = $value;
        	}
        	$this->EOF = false;
		}
	}
	
	public function MoveNext(){
		$row = @mysql_fetch_assoc($this->resource);
		if (!$row) {
			$this->EOF = true;
		} else {
			while (list($key, $value) = each($row)) {
				$this->fields[$key] = $value;
			}
		}
	}
	
	function RecordCount() {
		return @mysql_num_rows($this->resource);
	}	
	
}