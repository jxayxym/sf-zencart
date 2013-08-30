<?php 
$filename_js = array('yui-min.js');
$js_dir = DIR_WS_TEMPLATE.'jscript/';
foreach ($filename_js as $entry){
	echo '<script type="text/javascript" src="'.$js_dir.$entry.'"></script>'."\n";
}
?>
