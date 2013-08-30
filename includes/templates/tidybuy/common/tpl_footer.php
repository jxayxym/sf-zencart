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

<?php
if (!isset($flag_disable_footer) || !$flag_disable_footer) {
?>
<div id="footerWrapper">
	<div id="companyInformation" class="layout_site_width">
		<div class="back">
			<h1>SFNET<?php include DIR_WS_MODULES.  zen_get_module_directory('analyticstracking.php'); ?></h1>
			<p><?php echo FOOTER_TEXT_BODY?></p>
		</div>
		<div class="back">
			<header>Company Info</header>
			<ul>
				<li><a href="<?php echo zen_href_link(FILENAME_ABOUT_US) ?>">About Us</a></li>
				<li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP) ?>">Site Map</a></li>
			</ul>
		</div>
		<div class="back">
			<header>Customer Service</header>
			<ul>
				<li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US) ?>">Contact Us</a></li>
				<li><a href="<?php echo zen_href_link(FILENAME_FAQ) ?>">FAQ</a></li>
			</ul>		
		</div>
		<div class="back">
			<header>Payment &amp; Shipping</header>
			<ul>
				<li><a href="<?php echo zen_href_link(FILENAME_PAYMENT_METHODS) ?>">Payment Methods</a></li>
				<li><a href="<?php echo zen_href_link(FILENAME_SHIPPING) ?>">Shipping Guide</a></li>
			</ul>		
		</div>		
		<div class="back">
			<header>Company Policies</header>
			<ul>
				<li><a href="<?php echo zen_href_link(FILENAME_PRIVACY) ?>">Privacy Policy</a></li>
				<li><a href="<?php echo zen_href_link(FILENAME_RETURN) ?>">Return Policy</a></li>
				<li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS) ?>">Conditions of Use</a></li>
			</ul>				
		</div>
		<br class="clearBoth" />
	</div>
</div>
<?php
} // flag_disable_footer
?>
	<div class="scroll_top">
		<div class="scroll_top_text">TOP</div>
		<div class="arrow_north"></div>
	</div>	
<script type="text/javascript">
$(document).ready(function(){
	var clientWidth = $(window).width();
	var layout_width = $(".layout_site_width").width();
	$('.scroll_top').css({right:(clientWidth-layout_width)/2-$('.scroll_top').width()/2});
});

$(window).scroll(function(){
	$(this).scrollTop() >= 220 ? $('.scroll_top').animate({ opacity: "show"},'slow') : $('.scroll_top').animate({ opacity: "hide"},'slow');	
});
$('.scroll_top').on('click',function(){
	$('html,body').animate({scrollTop : 0},100);
});
</script>