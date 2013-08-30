<?php
class meta_tags extends base{
    function __construct() {
        $this->attach($this,array('NOTIFY_MODULE_END_META_TAGS'));
    }
    function update(&$class, $eventID, $paramsArray = array()){
        if($eventID=='NOTIFY_MODULE_END_META_TAGS'){
             if (isset($_GET['options_values_id'])&&preg_match('/^[0-9]+(_[0-9]+)*$/', $_GET['options_values_id'])){
                $options_tag = get_option_name($_GET['options_values_id']);
                if (defined('META_TAG_TITLE')){
                    define('META_TAG_TITLE_SHOP_BY', META_TAG_TITLE.' - Shop by '.$options_tag);
                }else{
                    define('META_TAG_TITLE_SHOP_BY', 'Shop by '.$options_tag);
                }
             }
        }
    }
}
?>
