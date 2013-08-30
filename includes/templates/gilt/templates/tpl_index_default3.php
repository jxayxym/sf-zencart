<?php
/**
 * Page Template
 *
 * Main index page<br />
 * Displays greetings, welcome text (define-page content), and various centerboxes depending on switch settings in Admin<br />
 * Centerboxes are called as necessary
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>
<div class="centerColumn" id="indexDefault">
	<div class="layout-center1000">
		<div class="c-black" id="indexWelcome">
			<h1>Welcome!</h1>
		</div>
		<div>
		<?php 
		include ($template->get_template_dir('tpl_module_products_show_by_categories.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_module_products_show_by_categories.php');
		?>
		</div>
		<br class="clearBoth" />
	</div>
</div>
<script type="text/javascript">
$("#Banner_slideshowHolder").player({
	width	: '300px',
	height  : '579px',
	time	: 3000,
}).play();
//new srcMarquee("recent-orders-data",0,2,300,500,30,3000,3000,70);
new srcMarquee("index-reviewsContent",0,2,300,500,30,2000,2000,70);
$(".products_show_products_item").mouseover(function(){
	$('.shade',$(this).parent()).show();
	$('.shade',this).hide();
}).mouseout(function(){
	$('.shade',$(this).parent()).hide();
});
</script>