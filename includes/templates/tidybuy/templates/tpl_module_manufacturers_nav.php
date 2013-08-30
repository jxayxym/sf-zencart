<?php
require DIR_WS_MODULES . zen_get_module_directory('manufacturers_nav.php');
// echo DIR_WS_MODULES . zen_get_module_directory('manufacturers_nav.php');
if(!empty($manufacturer_array)){
?>

<table class="manufacturer_tags" width="100%">
<tr>
	<td class="manufacturer_tags_label">DESIGNERS A-Z:</td>
<?php
	foreach ($manufacturer_array as $tag=>$manufacturers){
?>
	<td class="manufacturer_tag_entry" width="3.3%">
		<?php 
		if(empty($manufacturers)){
			echo '<span class="tag_label">'.$tag.'</span>';
		}else{
			echo '<span class="tag_label has_child">'.$tag.'</span>';
		}	
		?>
		<?php 
		if (zen_not_null($manufacturers)){
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
		<?php 
		}
		?>
	</td>	
<?php		
	}
?>
</tr>
</table>
<?php	
}
?>