<?php
//$autoLoadConfig[0][] = array('autoType'=>'class',
//							 'classPath'=>DIR_FS_CATALOG.DIR_WS_CLASSES,	
//                             'loadFile'=>'class.fanli.guize_dengji.php');
//$autoLoadConfig[0][] = array('autoType'=>'class',
//							 'classPath'=>DIR_FS_CATALOG.DIR_WS_CLASSES,	
//                             'loadFile'=>'class.fanli.guize_jifen.php');
//$autoLoadConfig[0][] = array('autoType'=>'class',
//							 'classPath'=>DIR_FS_CATALOG.DIR_WS_CLASSES,	
//                             'loadFile'=>'class.fanli.customers_dengji.php');

//$autoLoadConfig[180][] = array('autoType'=>'classInstantiate',
//                               'className'=>'guize_dengji',
//                               'objectName'=>'guize_dengji');
//
//$autoLoadConfig[180][] = array('autoType'=>'classInstantiate',
//                               'className'=>'customers_dengji',
//                               'objectName'=>'customers_dengji');

/*******************************************************/
$autoLoadConfig[0][] = array('autoType'=>'class',
                             'loadFile'=>'class.ReturnMoneyOrder.php');
$autoLoadConfig[0][] = array('autoType'=>'class',
                             'loadFile'=>'class.ReturnMoneyCredits.php');
$autoLoadConfig[0][] = array('autoType'=>'class',
                             'loadFile'=>'class.ReturnMoneyCustomer.php');
$autoLoadConfig[0][] = array('autoType'=>'class',
                             'loadFile'=>'class.ReturnMoneyConfigure.php');
