<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping.<br />
 * Displays allowed shipping modules for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_shipping_default.php 14807 2009-11-13 17:22:47Z drbyte $
 */
?>
<div class="centerColumn" id="checkoutShipping">

<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

<h1 id="checkoutShippingHeading"><?php echo _HEADING_TITLE; ?></h1>
<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>

<h2 class="fill_in_your_address">Fill In Your Address</h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabel_style2">
  <tbody>
  <tr class="tableHeading">
    <th width="85" height="31" align="center" valign="middle" class="first_th">Name</th>                                                                                        
    <th width="170" align="center" valign="middle">Region</th>
    <th width="130" align="center" valign="middle">Address</th>
    <th width="83" align="center" valign="middle"> Postal Code </th>
    <th width="107" align="center" valign="middle">Phone Number </th>
    <th width="94" align="center" valign="middle" class="last_th">Operation</th>
  </tr>
<?php
 $i=1;
 while (!$customer_address_entries->EOF){
	$city = zen_output_string_protected($customer_address_entries->fields['entry_city']);
	$state = zen_output_string_protected($customer_address_entries->fields['entry_state']);
	if (isset($customer_address_entries->fields['entry_country_id']) && zen_not_null($customer_address_entries->fields['entry_country_id'])) {
		$country = zen_get_country_name($customer_address_entries->fields['entry_country_id']);
	
		if (isset($customer_address_entries->fields['entry_zone_id']) && zen_not_null($customer_address_entries->fields['entry_zone_id'])) {
			$state = zen_get_zone_code($customer_address_entries->fields['entry_country_id'], $customer_address_entries->fields['entry_zone_id'], $state);
		}
	}else {
		$country = '';
	}
	$street = zen_output_string_protected($customer_address_entries->fields['entry_street_address']);
	$suburb = zen_output_string_protected($customer_address_entries->fields['entry_suburb']);
	$postcode = zen_output_string_protected($customer_address_entries->fields['entry_postcode']);
	$row_even_odd = ($i%2)==0?'rowEven':'rowOdd';
	$i++
?>  
  <tr class="<?php echo $row_even_odd?>">
    <td align="center" valign="middle"><?php echo zen_output_string_protected($customer_address_entries->fields['entry_firstname'] . ' ' . $customer_address_entries->fields['entry_lastname']); ?></td>
    <td align="center" valign="middle"><?php echo $city.' '.$state.' '.$country ?></td>
    <td align="center" valign="middle"><?php echo $street.'<br />'.$suburb ?></td>
    <td align="center" valign="middle"><?php echo $postcode?></td>
    <td align="center" valign="middle"><?php echo zen_output_string_protected(zen_get_address_book_telephone($customer_address_entries->fields['address_book_id'])) ?></td>
    <td align="center" valign="middle">
        <?php if ($customer_address_entries->fields['address_book_id']==$_SESSION['sendto']){?>
        <span style=" color:Green">Send here</span>
        <?php }else{
        	echo '<a href="'.zen_href_link(FILENAME_CHECKOUT_SHIPPING,'action=set_send_to&set_address_book_id='.$customer_address_entries->fields['address_book_id']).'"><span class="cssButton button_send_here">send here</span></a>';
        }?>
   </td>
  </tr>
<?php 
	$customer_address_entries->MoveNext();
}
?>  
	<tr>
		<td colspan="6" align="right"><a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS)?>">Add Address</a></td>
	</tr>
</tbody></table>

<?php
  if (zen_count_shipping_modules() > 0) {
?>

<h2 id="checkoutShippingHeadingMethod"><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></h2>

<?php
    if ($free_shipping == true) {
?>
<div id="freeShip" class="important" ><?php echo FREE_SHIPPING_TITLE; ?>&nbsp;<?php echo $quotes[$i]['icon']; ?></div>
<div id="defaultSelected"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . zen_draw_hidden_field('shipping', 'free_free'); ?></div>

<?php
    } else {
      $radio_buttons = 0;
      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
      // bof: field set
// allows FedEx to work comment comment out Standard and Uncomment FedEx
//      if ($quotes[$i]['id'] != '' || $quotes[$i]['module'] != '') { // FedEx
      if ($quotes[$i]['module'] != '') { // Standard
?>
<fieldset>
<legend><?php echo $quotes[$i]['module']; ?>&nbsp;<?php if (isset($quotes[$i]['icon']) && zen_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></legend>

<?php
        if (isset($quotes[$i]['error'])) {
?>
      <div><?php echo $quotes[$i]['error']; ?></div>
<?php
        } else {
          for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
// set the radio button to be checked if it is the method chosen
            $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);

            if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
              //echo '      <div id="defaultSelected" class="moduleRowSelected">' . "\n";
            //} else {
              //echo '      <div class="moduleRow">' . "\n";
            }
?>
<?php
            if ( ($n > 1) || ($n2 > 1) ) {
?>
<div class="important forward"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></div>
<?php
            } else {
?>
<div class="important forward"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></div>
<?php
            }
?>

<?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, 'id="ship-'.$quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']) .'"'); ?>
<label for="ship-<?php echo $quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']); ?>" class="checkboxLabel" ><?php echo $quotes[$i]['methods'][$j]['title']; ?></label>
<!--</div>-->
<br class="clearBoth" />
<?php
            $radio_buttons++;
          }
        }
?>

</fieldset>
<?php
    }
// eof: field set
      }
    }
?>

<?php
  } else {
?>
<h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
<?php
  }
?>
<fieldset class="shipping" id="comments">
<legend><?php echo TABLE_HEADING_COMMENTS; ?></legend>
<?php echo zen_draw_textarea_field('comments', '45', '3'); ?>
</fieldset>

<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT); ?></div>
<div class="buttonRow back"><?php echo '<strong>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</strong><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form>
</div>