<?php
include(DIR_WS_MODULES . zen_get_module_directory('filter_selected.php'));

if (zen_not_null($filter_selected)) {
?>
<div class="filter_selected">
<span class="filter_selected_title"><?php echo TEXT_FILTER_SELECTED?></span>
<?php
foreach ($filter_selected as $entry){
	echo '<div class="filter_selected_entry"><a href="'.$entry['link'].'">'.$entry['text'].'</a></div>';	
}?>
<br class="clearBoth" />
</div>
<?php
}