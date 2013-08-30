<?php
class ajax_page extends base{
    private $_child_ajax_page;
    
    public function __construct() {
        if(( isset($_GET['ajax_request']) && $_GET['ajax_request']=='get' ) ||
            ( isset($_POST['ajax_request']) && $_POST['ajax_request']=='post')){
            $this->attach($this, array('NOTIFY_HEADER_START_LOGIN','NOTIFY_LOGIN_BANNED','NOTIFY_LOGIN_SUCCESS','NOTIFY_LOGIN_FAILURE','NOTIFY_HEADER_END_LOGIN'));
            $this->attach($this, array('NOTIFY_HEADER_START_PRODUCT_INFO'));
        }
    }
    
    function update(&$class, $eventID, $paramsArray = array()){
        $class_name = 'ajax_page_'.trim($_GET['main_page']);
        if(class_exists($class_name)){
            if(is_null($this->_child_ajax_page))
                $this->_child_ajax_page = new $class_name();
            if(method_exists($this->_child_ajax_page,'update')){
                $this->_child_ajax_page->update($class, $eventID, $paramsArray = array());
            }else{
                exit('no update method');
            }
        }else{
            exit('not found class '.$class_name);
        }
    }
}
?>
