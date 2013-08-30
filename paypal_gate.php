<?php
require('includes/application_top.php');

if (!empty($_POST)){
	if ($_POST['process_state']=='1'){
		//对订单进行保存
		require(DIR_WS_MODULES . zen_get_module_directory('checkout_process.php'));
		  $payment_modules->after_process();
		  $_SESSION['cart']->reset(true);
		  $form_action_url = $$_SESSION['payment']->form_payagent_url;
		  
		  unset($_SESSION['sendto']);
		  unset($_SESSION['billto']);
		  unset($_SESSION['shipping']);
		  unset($_SESSION['payment']);
		  unset($_SESSION['comments']);
		
		$_POST['process_state'] = 2;
		echo '<form name="form1" method="post" action="'.$form_action_url.'">';
		foreach ($_POST as $k=>$v){
			if ($k=='return' || $k=='cancel_return' || $k=='shopping_url' || $k=='notify_url') continue;
			echo '<input type="hidden" name="'.$k.'" value="'.$v.'">';		
		}
		echo '</form>';
		echo '<script type="text/javascript">form1.submit();</script>';
		$order_total_modules->clear_posts();//ICW ADDED FOR CREDIT CLASS SYSTEM
		
	}elseif ($_POST['process_state']=='2'){
		//保存好代理者URL
		$where = $_POST['where'];
		$db->Execute('INSERT INTO `sf_ext_paypalagent` (`customer_url`, `date_time`) VALUES (\''.addslashes($where).'\',now())');
		unset($_POST['where']);
		echo '<form name="form1" method="post" action="http://www.paypal.com/cgi-bin/webscr" target="_parent">';
		foreach ($_POST as $k=>$v){
			if ($k=='return' || $k=='cancel_return' || $k=='shopping_url' || $k=='notify_url') continue;
			echo '<input type="hidden" name="'.$k.'" value="'.$v.'">';
		}
		echo '</form>';
		echo '<script type="text/javascript">form1.submit();</script>';
	}else{
		zen_href_link($_POST['where']);
	}
}

require(DIR_WS_INCLUDES . 'application_bottom.php');

/*
 SELECT * FROM `sf_products` WHERE  `products_id` in (select `products_id` from sf_products_description where products_name like '%allure%' or `products_description` like '%allure%')
update `sf_products` set `products_status`=0 where `products_id` in(select `products_id` from sf_products_description where products_name like '%allure%' or `products_description` like '%allure%')
 * */
?>


