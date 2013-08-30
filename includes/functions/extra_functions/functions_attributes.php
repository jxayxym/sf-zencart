<?php
function getOptionValues($options_name){
    global $db;
    $sql = "select * from ".TABLE_PRODUCTS_OPTIONS." po join ".TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS." pov2po on po.products_options_id=pov2po.products_options_id ".
            "join ".TABLE_PRODUCTS_OPTIONS_VALUES." pov on pov.products_options_values_id=pov2po.products_options_values_id ".
            "where po.products_options_name='".addslashes($options_name)."' and po.language_id=".(int)$_SESSION['languages_id'];
    $r = $db->Execute($sql);
    $options = array();
    while (!$r->EOF){
        $options[$r->fields['products_options_values_id']] = array(
            'products_options_name'=>$r->fields['products_options_name'],
            'products_options_values_name'=>$r->fields['products_options_values_name'],
            'products_options_values_id'=>$r->fields['products_options_values_id'],
            'products_options_id'=>$r->fields['products_options_id'],
        );
        $r->MoveNext();
    }
    return $options;
}
function get_option_name($str_opID,$separator='&'){
    global $db;
    $op_array = explode('_', $str_opID);
    $sql = "SELECT GROUP_CONCAT(`products_options_values_name` ORDER BY FIND_IN_SET(`products_options_values_name`,'".implode(',', $op_array)."') SEPARATOR '".$separator."') AS s
     FROM ".TABLE_PRODUCTS_OPTIONS_VALUES." WHERE products_options_values_id IN(".implode(',', $op_array).") AND language_id=".(int)$_SESSION['languages_id'];
    $result = $db->Execute($sql);
    $return = $result->fields['s'];
    return $return;
}	
?>
