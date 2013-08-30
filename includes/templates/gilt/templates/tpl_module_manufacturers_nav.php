<?php
require DIR_WS_MODULES . zen_get_module_directory('manufacturers_nav.php');
// echo DIR_WS_MODULES . zen_get_module_directory('manufacturers_nav.php');
if(!empty($manufacturer_array)){
?>

<ul class="manufacturer_tags">
	<li class="manufacturer_tags_label back">DESIGNERS A-Z:</li>
<?php
	foreach ($manufacturer_array as $tag=>$manufacturers){
?>
	<li class="manufacturer_tag_entry">
		<?php 
		if(empty($manufacturers)){
			echo '<span class="tag_label">'.$tag.'</span>';
		}else{
			echo '<span class="tag_label has_child">'.$tag.'</span>';
		}	
		?>
		<ul class="manufacturers_list">
		<?php
		foreach($manufacturers as $manufacturer_entry){
		?>
		<li><a class="manufacturers_list_entry" href="<?php echo zen_href_link(FILENAME_DEFAULT,'manufacturers_id='.$manufacturer_entry['id'])?>"><?php echo $manufacturer_entry['text']?></a></li>
		<?php
		}
		?>
		</ul>
	</li>	
<?php		
	}
?>
	<li class="clearBoth"></li>
</ul>
<?	
}
