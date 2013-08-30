<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$dir = dirname(str_replace(DIR_FS_CATALOG, '', str_replace(DIRECTORY_SEPARATOR, '/', __FILE__)));


$google_account_login_url = GOOGLE_ACCOUNT_LOGIN_URI;
$click_google = "window.open('$google_account_login_url','popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150');";

$facebook_account_login_url = FACEBOOK_ACCOUNT_LOGIN_URI;
$click_facebook = "window.open('$facebook_account_login_url','popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150');";

$hotmail_account_login_url = HOTMAIL_ACCOUNT_LOGIN_URI;
$click_hotmail = "window.open('$hotmail_account_login_url','popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150');";

$twitter_account_login_url = TWITTER_ACCOUNT_LOGIN_URI;
$click_twitter = "window.open('$twitter_account_login_url','popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150');";

//$yahoo_account_login_url = YAHOO_ACCOUNT_LOGIN_URI;
//$click_yahoo = "window.open('$yahoo_account_login_url','popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150');";
?>
<ul class="social_accounts">
	<li class="social_account_gmail"><?php echo '<a href="#" onclick="'.$click_google.' return false;">Gmail</a>';?></li>
  	<li class="social_account_facebook"><?php echo '<a href="#" onclick="'.$click_facebook.' return false;">Facebook</a>' ?></li>
  	<li class="social_account_hotmail"><?php echo '<a href="#" onclick="'.$click_hotmail.' return false;">Hotmail</a>';?></li>
<!--	<li class="social_account_twitter"><?php echo '<a href="#" onclick="'.$click_twitter.' return false;">Twitter</a>'?></li>-->
<!--	<li class="social_account_yahoo"><?php echo '<a href="#" onclick="'.$click_yahoo.' return false;">Yahoo</a>';?></li>-->
</ul>
