<?php
class ajax_page_login extends base{
    private $_event_result = array();
    function update(&$class, $eventID, $paramsArray = array()){
        switch ($eventID){
            case 'NOTIFY_HEADER_START_LOGIN':
                if(!isset($_GET['action']) && ($_GET['action'] != 'process')){
                    ob_start();
                    include DIR_WS_TEMPLATE.'templates/tpl_ajax_page_login.php';
                    array_push($this->_event_result,array('eventID'=>'NOTIFY_HEADER_START_LOGIN','result'=>ob_get_contents()));
                    ob_end_clean();
                }
                break;
            case 'NOTIFY_LOGIN_SUCCESS':
                global $messageStack,$zco_notifier,$db,$currencies,$template,$request_type;
                ob_start();
                require DIR_WS_TEMPLATE.'common/tpl_header.php';
                array_push($this->_event_result,array('eventID'=>'NOTIFY_LOGIN_SUCCESS','result'=>ob_get_contents()));
                ob_end_clean();
                $this->send_json();
                break;
            case 'NOTIFY_LOGIN_FAILURE':
                array_push($this->_event_result,array('eventID'=>'NOTIFY_LOGIN_FAILURE','result'=>'login failure!'));
                $this->send_json();
                break;
            case 'NOTIFY_HEADER_END_LOGIN':
                $this->send_json();
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
