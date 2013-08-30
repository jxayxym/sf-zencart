<?php
$categories = array();
//计算指定分类下的所有树叶分类
if (empty($_GET['cPath']))
	$cur_category = 0;
else
	$cur_category = array_pop(explode('_', $_GET['cPath']));
$sql = 'SELECT c1.categories_id,c1.categories_image,cd.categories_name,cd.categories_description FROM '.TABLE_CATEGORIES.' c1 LEFT JOIN '.TABLE_CATEGORIES.' c2 ON '.
		'c1.`categories_id`=c2.`parent_id` JOIN '.TABLE_CATEGORIES_DESCRIPTION.' cd ON '.
		'cd.categories_id=c1.categories_id  where c2.`categories_id` IS NULL and c1.categories_status=1';
$leaf_categories = $db->Execute($sql);


	

