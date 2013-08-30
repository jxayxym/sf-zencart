<?php
$parameters = zen_get_all_get_params(array('info', 'x', 'y','page'));
$amountfrom = (zen_not_null($_GET['amountfrom'])&&preg_match('/^[0-9]+$/',$_GET['amountfrom']))?$_GET['amountfrom']:'';
$amountto   = (zen_not_null($_GET['amountto'])&&preg_match('/^[0-9]+$/',$_GET['amountto']))?$_GET['amountto']:'';

$content = '<div class="price_range_form sideBoxContent">';
$content .= zen_draw_form('price_range', zen_href_link(FILENAME_DEFAULT),'get');
$content .= $currencies->currencies[$_SESSION['currency']]['symbol_left'].zen_draw_input_field('amountfrom',$amountfrom,'id="amountfrom" pattern="[0-9]*" style="width:35px;"');
$content .= '&nbsp;-&nbsp;'.$currencies->currencies[$_SESSION['currency']]['symbol_left'].zen_draw_input_field('amountto',$amountto,'id="amountto" pattern="[0-9]*" style="width:35px;"');
foreach ($_GET as $key=>$value) {
	if ($key!=='amountfrom' && $key!=='amountto' && ($key != zen_session_name()) && ($key != 'error') && ($key != 'main_page'))
		 $content .= zen_draw_hidden_field($key,$value);
}
$content .= '<input type="submit" value="Go" class="price_range_submit" />';
$content .= '</form></div>';