<?php
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_POPULAR_PRODUCTS));
?>

<div class="centerBoxWrapper" id="popularProducts">
<?php
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>
</div>
