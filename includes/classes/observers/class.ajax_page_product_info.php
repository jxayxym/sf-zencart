<?php
class ajax_page_product_info extends base{
    private $_event_result = array();
    
    function update(&$class, $eventID, $paramsArray = array()){
    	global $db;
        switch ($eventID){
            case 'NOTIFIER_CART_ADD_CART_END':
               break;
            case 'NOTIFY_HEADER_START_PRODUCT_INFO':
            	switch ($_GET['action']){
            		case 'products_preview':
            			include DIR_WS_MODULES.zen_get_module_directory('product_prev_next.php');
            			$this->_event_result['NOTIFY_HEADER_START_PRODUCT_INFO'] = array(
            						'html'=>$content_preview,
            					);
            			$this->send_json();
            			break;
            		default:
            			//do nothing
            			break;
            	}
            	break;   
        }
    }
    
    public function send_json(){
    	$result = array_pop($this->_event_result);
    	echo json_encode($result);
    	exit;
    }    
}
?>
