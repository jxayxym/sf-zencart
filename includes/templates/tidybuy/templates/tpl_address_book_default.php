<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=adress_book.<br />
 * Allows customer to manage entries in their address book
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_default.php 5369 2006-12-23 10:55:52Z drbyte $
 */
?>
<div class="centerColumn" id="addressBookDefault">

<h1 id="addressBookDefaultHeading"><?php echo HEADING_TITLE; ?></h1>
 
<?php if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); ?> 
      
<br class="clearBoth" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="ress mallp">
  <tbody>
  <tr class="ress_tit">
    <th width="85" height="31" align="center" valign="middle">Name</th>                                                                                        
    <th width="170" align="center" valign="middle">Region</th>
    <th width="130" align="center" valign="middle">Address</th>
    <th width="83" align="center" valign="middle"> Postal Code </th>
    <th width="107" align="center" valign="middle">Phone Number </th>
    <th width="94" align="center" valign="middle" class="th3">Operation</th>
  </tr>
<?php
 foreach ($addressArray as $addresses) {
	$city = zen_output_string_protected($addresses['address']['city']);
	$state = zen_output_string_protected($addresses['address']['state']);
	if (isset($addresses['address']['country_id']) && zen_not_null($addresses['address']['country_id'])) {
		$country = zen_get_country_name($addresses['address']['country_id']);
	
		if (isset($addresses['address']['zone_id']) && zen_not_null($addresses['address']['zone_id'])) {
			$state = zen_get_zone_code($addresses['address']['country_id'], $addresses['address']['zone_id'], $state);
		}
	} elseif (isset($addresses['address']['country']) && zen_not_null($addresses['address']['country'])) {
		if (is_array($addresses['address']['country'])) {
			$country = zen_output_string_protected($addresses['address']['country']['countries_name']);
		} else {
			$country = zen_output_string_protected($addresses['address']['country']);
		}
	} else {
		$country = '';
	}
	$street = zen_output_string_protected($addresses['address']['street_address']);
	$suburb = zen_output_string_protected($addresses['address']['suburb']);
	$postcode = zen_output_string_protected($addresses['address']['postcode']);
?>  
  <tr class="">
    <td align="center" valign="top"><?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></td>
    <td align="center" valign="top"><?php echo $city.' '.$state.' '.$country ?></td>
    <td align="center" valign="top"><?php echo $street.'<br />'.$suburb ?></td>
    <td align="center" valign="top"><?php echo $postcode?></td>
    <td align="center" valign="top"><?php echo zen_output_string_protected(zen_get_address_book_telephone($addresses['address_book_id'])) ?></td>
    <td align="center" valign="top">
<?php echo '<a class="back" href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a> <a class="back" href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_DELETE_SMALL, BUTTON_DELETE_SMALL_ALT) . '</a>'; ?>    
        <?php if ($addresses['address_book_id']==$_SESSION['customer_default_address_id']){?>
        <span style=" color:Green">Default</span>
        <?php }?>
   </td>
  </tr>
<?php 
}
?>  
</tbody></table>


<?php
  if (zen_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {
?>
   <div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_ADD_ADDRESS, BUTTON_ADD_ADDRESS_ALT) . '</a>'; ?></div>
<?php
  }
?>
<div class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
<br class="clearBoth" />
</div>
