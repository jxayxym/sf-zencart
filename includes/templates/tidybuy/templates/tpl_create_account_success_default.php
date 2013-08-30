<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create-account_success.<br />
 * Displays confirmation that a new account has been created.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_create_account_success_default.php 4886 2006-11-05 09:01:18Z drbyte $
 */
?>
<div class="centerColumn" id="createAcctSuccess">
<h1 id="createAcctSuccessHeading"><?php echo HEADING_TITLE; ?></h1>

<div id="createAcctSuccessMainContent" class="content"><?php echo sprintf(TEXT_ACCOUNT_CREATED,'<span class="customers_email_address">'.$_SESSION['customers_email_address'].'</span>','<span class="new_signup_coupon_code">'.$_SESSION['new_signup_coupon_code'].'</span>'); ?></div>
<fieldset>
<legend><?php echo PRIMARY_ADDRESS_TITLE; ?></legend>
<?php
if (zen_not_null($addressArray)){
/**
 * Used to loop thru and display address book entries
 */
  foreach ($addressArray as $addresses) {
?>
<h3 class="addressBookDefaultName"><?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></h3>

<address><?php echo zen_address_format($addresses['format_id'], $addresses['address'], true, ' ', '<br />'); ?></address>

<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a> <a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT) . '</a>'; ?></div>
<br class="clearBoth">
<?php
  }
}else{
	echo TEXT_GO_TO_ADD_ADDRESS_ENTRY;
}  
?>
</fieldset>


<div>
<div><?php echo 'Go to <a href="' . zen_href_link(FILENAME_DEFAULT) . '" style="color:#cc3300;font-weight:bold;text-decoration:underline;">Home</a>'; ?></div>
<div><?php echo 'Go to <a href="' . $origin_href . '" style="color:#cc3300;font-weight:bold;text-decoration:underline;">The recent Visit</a>'; ?></div>
</div>
</div>
