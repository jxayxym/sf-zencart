<?php
$autoLoadConfig[0][] = array('autoType'=>'class',
                            'classPath'=>DIR_FS_CATALOG.DIR_WS_MODULES.'LoginWithSocialAccount/',									
                             'loadFile'=>'class.LoginWith.php');
$autoLoadConfig[180][] = array('autoType'=>'classInstantiate',
                               'className'=>'LoginWith',
                               'objectName'=>'login_with');
