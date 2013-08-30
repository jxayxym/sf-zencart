<?php 
include 'configure.php';
include 'class/class.soap_request.php';
include 'soap_url_list.php';
set_time_limit(3600);
class AuthHeader
{
	public $username;
	public $password;

}

$soap_client = new Soap_Request('soap_server.php','');
$AuthHeader = new AuthHeader();

$AuthHeader->username = 'xym';
$AuthHeader->password = '19871020';
$Headers[] = new SoapHeader('soap_server.php', 'AuthHeader', $AuthHeader);
$soap_client->__setSoapHeaders($Headers);

?>
<!DOCTYPE html>
<html>
<head>
<title>zen cart 网站配置管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
<meta name="robots" content="noindex, nofollow" />
<script type="text/javascript" src="<?php echo HTTP_SERVER?>/includes/templates/tidybuy/jscript/jscript_jquery-1.8.2.js"></script>
</head>
<body>
<?php
if($_SERVER['REQUEST_METHOD']=="POST" && $_POST['action']=='更新'){
	if(!empty($_POST['uri'])){
		foreach($_POST['uri'] as $i=>$paypal_account){
			echo $soap_url_list[$i].'更新状态:';
			try {
			$soap_client->__setLocation('http://www.'.$soap_url_list[$i].'/adm1n_configure_with_soap/soap_server.php');
			echo $soap_client->setPaypalAccount($paypal_account)?'成功':'失败';
			}catch (SoapFault $e){
				echo $e->getMessage();
			}catch(Exception $e){
				echo $e->getMessage();
			}
			echo '<br />';
		}
	}
}
?>
<form method="post" acton="">
<table border="1" width="600px">
<caption>Paypal账号集中器</caption>
	<thead>
	<tr  height="40px"><th><input type="checkbox" name="all_checked" checked="checked"></th><th>网站</th><th>paypal账号</th></tr>
	</thead>
	<tbody>
<?php
foreach ($soap_url_list as $k=>$v){
	$soap_client->__setLocation('http://www.'.$v.'/adm1n_configure_with_soap/soap_server.php');
	echo '<tr height="35px">';
	echo '<td><input type="checkbox" name="index['.$k.']" value="'.$k.'" checked="checked" /></td>';
	echo '<td>'.$v.'</td>';
	echo '<td>';
	try {
		echo '<input type="text" name="uri['.$k.']" value="'.$soap_client->getPaypalAccount(),'" style="width:300px;" />';
	}catch(SoapFault $e){
		echo '<font color="red">'.$e->getMessage().'</font>';
// 		echo htmlspecialchars($soap_client->__getLastRequest());
	}catch(Exception $e){
		echo '<font color="red">'.$e->getMessage().'</font>';
	}
	echo '</td>';
	echo '</tr>';
}
?>	
	</tbody>
</table>

<input type="submit" name="action" value="更新">
</form>
<script type="text/javascript">
$(":checkbox").click(function(){
	var name = $(this).attr("name");
	var is_checked = $(this).attr("checked");
	if(name=="all_checked"){
		if(is_checked)
			$(":checkbox").attr("checked","true");
		else
			$(":checkbox").removeAttr("checked");
	}
	$(":checkbox").filter(function(){return $(this).attr("name")!="all_checked"; }).each(function(){
		var index_checkbox = $(this).val();
		if($(this).attr("checked")){
			$("input[name='uri["+index_checkbox+"]']").attr("disabled",false);
		}else{
			$("input[name='uri["+index_checkbox+"]']").attr("disabled",true);
		}
	});
});
</script>
</body>
</html>