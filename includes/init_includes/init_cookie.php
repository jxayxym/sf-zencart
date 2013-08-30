<?php
//Recently Viewed
if (isset($_COOKIE['recently_viewed'])){
	$recently_viewed = explode(',',$_COOKIE['recently_viewed']);
}else{
	$recently_viewed = array();
}
if(isset($_GET['products_id'])){
	array_unshift($recently_viewed, $_GET['products_id']);
	$recently_viewed = array_unique($recently_viewed);

	setcookie('recently_viewed',implode(',', $recently_viewed),0,'/');
}