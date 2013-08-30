<?php
$autoLoadConfig[180][] = array('autoType'=>'class',
                           'loadFile'=>'class.ajax_page.php');
$autoLoadConfig[180][] = array('autoType'=>'class',
                           'loadFile'=>'observers/class.ajax_page_login.php');
$autoLoadConfig[180][] = array('autoType'=>'class',
                           'loadFile'=>'observers/class.ajax_page_product_info.php');
$autoLoadConfig[180][] = array('autoType'=>'classInstantiate',
                            'className'=>'ajax_page',
                            'objectName'=>'ajax_page');
?>
