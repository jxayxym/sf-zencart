<?php
$account_management_list = array(
'Order'=>array(
			array('text'=>'View Order','link'=>zen_href_link(FILENAME_ACCOUNT_HISTORY)),
		),
'Coupons'=>array(
			array('text'=>'My Coupons','link'=>zen_href_link(FILENAME_ACCOUNT_COUPONS)),
		),		
'Settings'=>array(
			array('text'=>'Address Management','link'=>zen_href_link(FILENAME_ADDRESS_BOOK)),
			array('text'=>'Change Password','link'=>zen_href_link(FILENAME_ACCOUNT_PASSWORD)),
		array('text'=>'Profile Management','link'=>zen_href_link(FILENAME_ACCOUNT_EDIT)),
		),				
);


require $template->get_template_dir('tpl_account_management.php',DIR_WS_TEMPLATE,$current_page_base,'sideboxes').'/tpl_account_management.php';

?>
<div>
	<h3><?php echo $title;?></h3>
	<?php echo $content;?>
</div>