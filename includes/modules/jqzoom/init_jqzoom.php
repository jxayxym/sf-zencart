<?php
if (defined(JQZOOM_STATUS)&&JQZOOM_STATUS=='true'&&in_array($_GET['main_page'],explode(',',JQZOOM_ZOOMPAGES))){
?>
<link rel="stylesheet" href="<?php echo DIR_WS_MODULES.'jqzoom/css/jquery.jqzoom.css'?>" type="text/css" />
<script type="text/javascript" src="<?php echo DIR_WS_MODULES.'jqzoom/jscript/jquery.jqzoom-core.js'?>"></script>
<?php
	if (file_exists(DIR_WS_MODULES.'jqzoom/'.$_GET['main_page'].'.php')){
		require DIR_WS_MODULES.'jqzoom/'.$_GET['main_page'].'.php';
	}
	require DIR_WS_MODULES.'jqzoom/jscript_jqzoom.php';	
}