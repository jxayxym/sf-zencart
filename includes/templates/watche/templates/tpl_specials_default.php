<div class="centerColumn" id="specialsListing">

<h1 id="specialsListingHeading"><?php echo $breadcrumb->last(); ?></h1>

<!-- bof: specials -->
<?php
/**
 * require the list_box_content template to display the products
 */
  include(DIR_WS_MODULES . zen_get_module_directory('special_page.php'));
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>
<!-- eof: specials -->
<?php
  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div id="specialsListingBottomLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
<div id="specialsListingBottomNumber" class="navSplitPagesResult"><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></div>
<?php
  } // split page
?>
</div>