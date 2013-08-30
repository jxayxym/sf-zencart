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
	<div class="layout-center1000 centeredContent pr">
		<div class="footerNav">
		<?php 
		echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" rel="nofollow">'.HEADER_TITLE_CATALOG.'</a>'; 
		echo '<a href="' . zen_href_link(FILENAME_ABOUT_US) . '" rel="nofollow">'.FOOTER_TEXT_ABOUT_US.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" rel="nofollow">'.FOOTER_TEXT_CONTACT_US.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_CONDITIONS) . '" rel="nofollow">'.FOOTER_TEXT_CONDITION.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_PRIVACY) . '" rel="nofollow">'.FOOTER_TEXT_PRIVACY_POLICIES.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_PAYMENT_METHODS) . '" rel="nofollow">'.FOOTER_TEXT_PAYMENT_METHODS.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_SHIPPING) . '" rel="nofollow">'.FOOTER_TEXT_SHIPPING_GUIDE.'</a>';
		echo '<a href="' . zen_href_link(FILENAME_RETURN) . '" class="lastItem" rel="nofollow">'.FOOTER_TEXT_RETURN_POLICY.'</a>';
		?>
		</div>
		<div id="siteinfoLegal" class="legalCopyright"><?php echo FOOTER_TEXT_BODY; ?><?php include DIR_WS_MODULES.  zen_get_module_directory('analyticstracking.php'); ?></div>
		<div class="scroll_top">
			<div class="scroll_top_text">TOP</div>
			<div class="arrow_north"></div>
		</div>
	</div>
</div>
<script type='text/javascript' src='http://tb.53kf.com/kf.php?arg=10017941&style=1'></script><div style='display:none;'><a href='http://www.53kf.com'>在线客服系统</a></div>
<script type="text/javascript">
$(document).ready(function(){
	var clientWidth = $(window).width();
	var layout_width = $(".layout-center1000").width();
	$('.scroll_top').css({right:(clientWidth-layout_width)/2-$('.scroll_top').width()/2});
});


$(window).scroll(function(){
	$(this).scrollTop() >= 220 ? $('.scroll_top').animate({ opacity: "show"},'slow') : $('.scroll_top').animate({ opacity: "hide"},'slow');	
});
$('.scroll_top').on('click',function(){
	$('html,body').animate({scrollTop : 0},100);
});
</script>
<?php
} // flag_disable_footer
?>