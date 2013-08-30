<?php
function get_ext_manufacturers($hot_rank,$limit=0){
	global $db;
	$sql = 'SELECT m.manufacturers_id,m.manufacturers_name,m.manufacturers_image FROM '.TABLE_EXT_MANUFACTURERS.' em JOIN '.TABLE_MANUFACTURERS.' m ON em.manufacturers_id=m.manufacturers_id WHERE hot_rank='.$hot_rank.' order by sort asc,manufacturers_id asc';
	if ($limit!=0) {
		$sql .= ' limit 0,'.(int)$limit;
	}
	$r = $db->execute($sql);
	return $r;
}

function get_total_manufacturers(){
	global $db;
	$sql = 'SELECT count(manufacturers_id) as total FROM '.TABLE_MANUFACTURERS;
	$r = $db->execute($sql);
	return $r->fields['total'];
	
}

function get_manufacturers_name($manufacturers_id){
	global $db;
	$sql = 'SELECT manufacturers_name FROM '.TABLE_MANUFACTURERS.' WHERE manufacturers_id='.(int)$manufacturers_id;
	$r = $db->execute($sql);
	return $r->fields['manufacturers_name'];
}