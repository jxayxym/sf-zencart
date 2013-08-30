<?php
if (isset($_GET['type']) && $_GET['type'] == 'ec') {
?>
<html>
Processing...
</html>
<?php 
}else{
	$source_site = parse_url($_SESSION['http_referer']);
	if (!empty($_POST)){
		echo '<form name="form1" method="post" action="http://'.$source_site.'/ipn_main_handler.php" target="_parent" style="display:none">';
		foreach ($_POST as $k=>$v){
			echo '<input type="text" name="'.$k.'" value="'.$v.'">';		
		}
		echo '<script type="text/javascript">form1.submit();</script>';
		echo '</form>';
	}
}