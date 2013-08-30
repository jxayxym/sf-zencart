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
                    <div id="categories_list_container">
                    <?php
                    $top_categories = get_top_categories();
                    foreach ($top_categories as $entry){
                            echo '<div class="back category_item"><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$entry['categories_id']).'">';
                            echo '<div class="category_item-title">'.$entry['categories_name'].'</div>';
                            echo zen_image(DIR_WS_IMAGES.$entry['categories_image'],$entry['categories_name'],'',280);
//					if (zen_not_null($entry['categories_description'])) echo '<div class="category_item-desc">'.$entry['categories_description'].'</div>';
                            echo '</a></div>';
                    }
                    ?>
                    </div>
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
</script>