<?php
/**
 * Common Template - tpl_footer.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_footer.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_footer = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 15511 2010-02-18 07:19:44Z drbyte $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>

<div id="whyBuyFromUsWrapper">
<div id="whyBuyFromUs" class="w-whyBuyFromUs layout_width">
	<h2>Why Shop at <?php $site=preg_replace('/http:\/\/www\./','',HTTP_SERVER);echo $site; ?></h2>
	<dl class="easyOrders"> 
		<dt>More Choices for A Better Life</dt>
		<dd><?php echo $site;?> is the global online retailer with an affordable item for every hobby and lifestyle. Home improvement, electronics, fashion and beauty supplies: available worldwide at unbeatable prices. For convenient shopping and everyday savings, make <?php echo $site;?> a part of your life today!</dd>
	</dl>
	<dl class="bestMerchandise"> 
		<dt>High Quality With Global Standards</dt>
		<dd>Every <?php echo $site;?> product undergoes an extensive testing and quality control procedure, ensuring each and every item purchased meets global quality standards. <?php echo $site;?> offers only the highest quality products, allowing customers to shop with confidence.
<button class="cssButton" onclick="window.location.href='<?php echo zen_href_link(FILENAME_LOGIN)?>'">Join Now</button>
</dd>
	</dl>
	<dl class="freeShipping"> 
		<dt>Low Prices Direct From Factory Suppliers</dt>
		<dd>As a China-based global online retailer, <?php echo $site;?> has developed long lasting ties with factories, distributors and warehouses throughout the Chinese wholesale community. Eliminating unnecessary costs and delivering the lowest possible prices to customers worldwide, <?php echo $site;?> is committed to providing high quality merchandise for less.</dd>
	</dl>

	<br class="clearBoth">
	<dl class="secure">  
		<dt>Easy &amp; Safe Online Shopping</dt>
		<dd>With a wide variety of payment options, <?php echo $site;?> offers convenience to customers worldwide. Purchasing options include major credit cards, debit cards, wire transfer, Western Union and PayPal. <?php echo $site;?> has a payment method that works for you, with VeriSign’s world renowned secure payment technology keeping your information safe at all times.</dd>
	</dl>
	<dl class="freeJoin"> 
		<dt>Convenient &amp; Friendly Customer Service</dt>
		<dd><?php echo $site;?> offers excellent, comprehensive customer service every step of the way. Before you order, make real time inquiries through use of our live chat. Once you’ve made a purchase, our customer service representatives are always on-hand to answer questions through our website’s easy to use ticket system. Shop with confidence and save with <?php echo $site;?>!</dd>
	</dl>
	<dl class="freeDelivery">
		<dt>Fast Delivery Around The Globe</dt>
		<dd>Partnering with internationally trusted logistic service providers such as DHL, EMS and UPS, <?php echo $site;?> ships to over 200 countries around the world. A variety of expedited shipping methods means there’s a convenient delivery option for every budget.
		</dd>
	</dl>
	<br class="clearBoth">
</div>
</div>
<?php
if (!isset($flag_disable_footer) || !$flag_disable_footer) {
?>
<div id="footerWrapper">
	<div id="footerNav" class="centeredContent pr layout_width">
		<div class="footerNav">
		<?php 
		echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HEADER_TITLE_CATALOG.'</a>'; 
		echo '<a href="' . zen_href_link(FILENAME_ABOUT_US) . '">'.FOOTER_TEXT_ABOUT_US.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">'.FOOTER_TEXT_CONTACT_US.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_CONDITIONS) . '">'.FOOTER_TEXT_CONDITION.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_PRIVACY) . '">'.FOOTER_TEXT_PRIVACY_POLICIES.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_PAYMENT_METHODS) . '">'.FOOTER_TEXT_PAYMENT_METHODS.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_SHIPPING) . '">'.FOOTER_TEXT_SHIPPING_GUIDE.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_RETURN) . '" class="lastItem">'.FOOTER_TEXT_RETURN_POLICY.'</a>';
		?>
		</div>
		<div class="footerlogo"></div>
		<div id="siteinfoLegal" class="legalCopyright"><?php echo FOOTER_TEXT_BODY; ?><?php include DIR_WS_MODULES.  zen_get_module_directory('analyticstracking.php'); ?></div>
		<div class="scroll_top">
			<div class="scroll_top_text">TOP</div>
			<div class="arrow_north"></div>
		</div>	
	</div>
</div>

<script type='text/javascript' src='http://chat.53kf.com/kf.php?arg=dodohandbag&style=1'></script><div style='display:none;'><a href='http://www.53kf.com'>在线客服系统</a>
<script type="text/javascript">
$(document).ready(function(){
	$(window).scroll(function(){
		$(this).scrollTop() >= 220 ? $('.scroll_top').animate({ opacity: "show"},'slow') : $('.scroll_top').animate({ opacity: "hide"},'slow');	
	});
	$('.scroll_top').on('click',function(){
		$('html,body').animate({scrollTop : 0},100);
	});
});
</script>
<?php
} // flag_disable_footer
?>