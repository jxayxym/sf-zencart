<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account_success.php 4816 2006-10-23 04:08:52Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Create an Account');
define('NAVBAR_TITLE_2', 'Success');
define('HEADING_TITLE', 'Your Account Has Been Created!');
define('TEXT_ACCOUNT_CREATED', '<p>An E-mail has been sent to your e-mail address %s Our system will send you an email in five minutes,please kindly check it.</p><p>Welcome to '.preg_replace('/^http:\/\/(www\.)?/','',HTTPS_SERVER).' and the account you just set up allows you to securely store all your ordering information, We are all here to make your life easier and shopping as convenient as possible.</p>'.(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT>0?'<p>You have got 1 Gift Certificate to spend, and the Gift Certificate code is %s.The face value is US$ '.NEW_SIGNUP_GIFT_VOUCHER_AMOUNT.', and you can apply it to your order.</p>':''));
define('PRIMARY_ADDRESS_TITLE', 'Primary Address');
define('TEXT_GO_TO_ADD_ADDRESS_ENTRY','<p>There is not any address entry in you address book!<span><a href="'.zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS).'" style="font-size:20px;color:#cc3300">=>new address book entry</a></span></p>');
?>