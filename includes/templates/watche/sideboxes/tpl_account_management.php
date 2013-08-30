<?php
$content = '<ul id="account_management_list">';
foreach($account_management_list as $list_header=>$list_entris){
	$content .= '<li>'.$list_header.'<ul>';
	foreach($list_entris as $a_entry){
		$content .= '<li><a href="'.$a_entry['link'].'">'.$a_entry['text'].'</a></li>';
	}
	
	$content .= '</ul></li>';
}
$content .= '</ul>';

$title = 'My Account';