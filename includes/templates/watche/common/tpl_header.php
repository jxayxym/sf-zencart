<?php
  // Display all header alerts via messageStack:
  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
  echo htmlspecialchars(urldecode($_GET['error_message']), ENT_COMPAT, CHARSET, TRUE);
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo htmlspecialchars($_GET['info_message'], ENT_COMPAT, CHARSET, TRUE);
} else {

}
?>


<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>

<div id="headerWrapper">
<!--bof-navigation display-->
<div id="navMainWrapper">
	<div id="navMain">
		<div id="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</a>'; ?></div>
		<div id="tagline"><?php echo HEADER_SALES_TEXT?></div>
		<div id="navMainSearch"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
		<div id="navCurrencyWrapper" class="dropdown">
			<span class="current_currency"><img src="<?php echo DIR_WS_IMAGES.'flags/'.$_SESSION['currency'].'.png'?>" alt="<?php echo $_SESSION['currency']?>" width="20px" height="15px"><?php echo '&nbsp;&nbsp;'.$currencies->currencies[$_SESSION['currency']]['symbol_left'].$_SESSION['currency'].'▼' ?></span>
			<div class="currencies_list">
			<ul>
			<?php 
			$parameters = zen_get_all_get_params(array('info', 'x', 'y'));
			while (list($key, $value) = each($currencies->currencies)) {
				if ($key==$_SESSION['currency']) continue;
				echo '<li><a href="'.zen_href_link($_GET['main_page'],'currency='.$key.'&'.$parameters).'"><img src="'.DIR_WS_IMAGES.'flags/'.$key.'.png" alt="'.$_SESSION['currency'].'" width="20px" height="15px" />&nbsp;&nbsp;'.$value['symbol_left'].$key.'</a></li>';
			}
			?>
			</ul>
			</div>	
		</div>
		<div id="navMybag">
		<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>" ><?php echo HEADER_TITLE_MY_BAG?></a>:<span class="items_in_bag"><?php echo '('.$_SESSION['cart']->count_contents().')'; ?></span>
		</div>
		<?php 
		if ($_SESSION['customer_id']=='') {
		?>
		<div id="navLoginWrapper"><a href="<?php echo zen_href_link(FILENAME_LOGIN)?>"><?php echo HEADER_TITLE_LOGIN ?></a></div>
		<?php
		}else{
		?>
		<div id="navAccountWrapper"><a class="navAccount" href="<?php echo zen_href_link(FILENAME_ACCOUNT)?>"><?php echo HEADER_TITLE_MY_ACCOUNT.'▼' ?></a>
		<div class="account_operate">
		<ul>
			<li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT)?>"><?php echo HEADER_TITLE_MY_ACCOUNT?></a></li>		
			<li><a href="<?php echo zen_href_link(FILENAME_LOGOFF)?>"><?php echo HEADER_TITLE_LOGOFF?></a></li>
		</ul>
		</div>
		</div>
		<?php	
		}
		?>
		<br class="clearBoth" />
	</div>
</div>
<!--eof-navigation display-->

<!--bof-optional categories tabs navigation display-->
<?php require($template->get_template_dir('tpl_modules_navigation_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_navigation_tabs.php'); ?>
<!--eof-optional categories tabs navigation display-->

<!--bof-header ezpage links-->
<?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
<?php require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
<?php } ?>
<!--eof-header ezpage links-->

</div>
<?php } ?>