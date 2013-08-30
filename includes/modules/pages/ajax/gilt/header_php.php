<?php
switch ($_GET['action']){
	case 'products_list':
		include DIR_WS_MODULES .'pages/ajax/'.$template_dir.'/'.$_GET['action'].'/ajax.php';
		break;
	default:
		break;	
}
exit;