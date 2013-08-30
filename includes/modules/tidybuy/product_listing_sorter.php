<?php
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
if (isset($sort_list['sort_selection'])) {
	$select_data = array();
	foreach ($sort_list['sort_selection'] as $key=>$entry){
		$select_data[] = array('id'=>$key,'text'=>$entry);
	}
	echo 'Sort By:',zen_draw_pull_down_menu('sort', $select_data, (isset($_GET['sort']) ? $_GET['sort'] : ''), 'onchange="this.form.submit()"');
}