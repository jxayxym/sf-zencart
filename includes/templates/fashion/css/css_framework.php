<?php 
$filename_css = array('YUI_3.11/cssreset-min.css','YUI_3.11/cssbase-min.css','YUI_3.11/cssfonts-min.css','YUI_3.11/cssgrids-min.css');
$css_dir = DIR_WS_TEMPLATE.'css/';
foreach ($filename_css as $entry){
	echo '<link rel="stylesheet" type="text/css" href="'.$css_dir.$entry.'" />'."\n"; 	
}
?>