<?php
if (zen_not_null($tag_list)) {
	echo '<ul id="brandsWrapper">';
	foreach ($tag_list as $tag=>$list){
		echo '<li class="brandsIndex">'.$tag.'<ul class="brandList">';
		foreach ($list as $entry){
			echo '<li class="brandEntry"><a href="'.zen_href_link(FILENAME_DEFAULT,'manufacturers_id='.$entry['manufacturers_id']).'">'.$entry['manufacturers_name'].'</a></li>';
		}
		echo '<li class="clearBoth"></li>';
		echo '</ul></li>';
	}
	echo '</ul>';
}	
