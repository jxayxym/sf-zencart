<?php
echo '<h3>Shop by sitemap</h3>';

//分类
$sql = 'select c1.categories_id from '.TABLE_CATEGORIES.' c1 left join '.TABLE_CATEGORIES.' c2 on c1.categories_id=c2.parent_id where c1.categories_status=1 and c2.categories_id is null';
$r_categories = $db->Execute($sql);
$categories_id = array();
while (!$r_categories->EOF){
	$categories_id[] = $r_categories->fields['categories_id'];
	$r_categories->MoveNext();
}

$sql = 'select po.products_options_id,po2pv.products_options_values_id from '.TABLE_PRODUCTS_OPTIONS.' po join '.TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS.' po2pv on po.products_options_id=po2pv.products_options_id '.
		'where po.products_options_type=5 order by products_options_sort_order,po2pv.products_options_values_id';
$r_attribute = $db->Execute($sql);

$attribute_array = array();
$answer = array();
while (!$r_attribute->EOF){
	if (!isset($attribute_array[$r_attribute->fields['products_options_id']])){
		$attribute_array[$r_attribute->fields['products_options_id']] = array();
		$attribute_array[$r_attribute->fields['products_options_id']][] = 0;
		$answer[$r_attribute->fields['products_options_id']] = 0;
	}
	$attribute_array[$r_attribute->fields['products_options_id']][] = $r_attribute->fields['products_options_values_id'];
	$r_attribute->MoveNext();
}
// $attribute_array = array(array(1,2,3),array('a','b','c'),array('A','B'));
// $answer = array(0,0,0);
$total = array();
foreach ($attribute_array as $key=>$entry){
	$total[$key] = count($entry);
}

// $test = 0;
$loop = true;
if ($sitemapXML->SitemapOpen('shopby')) {
	while ($loop){
		$option_values_id = array();
		foreach ($answer as $key=>$index){
	// 		echo $attribute_array[$key][$index],',';
			if($attribute_array[$key][$index]!=0)
			$option_values_id[] = $attribute_array[$key][$index];
		}
	// 	echo '<br />';
		if (count($option_values_id)>0){
			foreach ($categories_id as $cid){
				$sql = 'select count(*) as num from (select pa.products_id from '.TABLE_PRODUCTS_ATTRIBUTES.' pa join '.TABLE_PRODUCTS.' p on p.products_id=pa.products_id '.
						'join '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c on p2c.products_id=pa.products_id '.
						'where p2c.categories_id='.$cid.' and pa.options_values_id in('.implode(',',$option_values_id).') group by pa.products_id having count(*)>='.count($option_values_id).') as t';
				$r = $db->Execute($sql);
				if ($r->fields['num']>1)
					$sitemapXML->writeItem(FILENAME_DEFAULT, 'cPath='.$cid.'&options_values_id='.implode('_',$option_values_id), 1, date('Y-m-d H:i:s'), 'monthly');
				unset($r);
			}
		}
		reset($attribute_array);
		$k = key($attribute_array);
// 		if ((++$test)==100) break;
		while (true){
			if ($answer[$k]<($total[$k]-1)){
				$answer[$k]++;
				break;
			}else {
				$answer[$k] = 0;
				if(false == next($attribute_array)){
					$loop = false;
					break;
				}else{
					$k = key($attribute_array);
				}
			}	
		}
	}
}
$sitemapXML->SitemapClose();