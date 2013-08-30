<?php
include 'includes/configure.php';
include 'includes/classes/class.Image.php';

$noimages_path = 'images/NoImage.jpg';
$image_path = isset($_GET['path'])?$_GET['path']:$noimages_path;
$width = isset($_GET['width'])?(int)$_GET['width']:0;
$height = isset($_GET['height'])?(int)$_GET['height']:0;

$pattern = '/(\.jpg)|(\.png)|(\.gif)$/i';

if (file_exists(DIR_FS_CATALOG.$image_path) && 
    preg_match($pattern, $image_path)) {
	$image_path = realpath(DIR_FS_CATALOG.$image_path);
}else {
	$image_path = realpath($noimages_path);
}

if (isset($_SERVER['HTTP_REFERER'])==false || 
	(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], HTTP_SERVER)!=0 )) {
	$image_path = $noimages_path;
}

$image = new Image($image_path);
$width = ($width==0)?$image->width:$width;
$height = ($height==0)?$image->height:$height;
$image->output(NULL,$width,$height);