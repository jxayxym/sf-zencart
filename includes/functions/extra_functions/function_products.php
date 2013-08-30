<?php
function get_featureds($num=0){
	global $db;
	$sql = 'select * from '.TABLE_FEATURED.' f join '.TABLE_PRODUCTS.' p on p.products_id=f.products_id '.
			'join '.TABLE_PRODUCTS_DESCRIPTION.' pd on pd.products_id=p.products_id '.
			'where p.products_status=1 and pd.language_id='.(int)$_SESSION['languages_id'].' ';
	if ($num!=0){
		$sql .= 'limit 0,'.$num;
	}
	$r = $db->Execute($sql);
	$featureds = array();
	while (!$r->EOF){
		$featureds[] = array(
			'products_id'=>$r->fields['products_id'],
			'products_image'=>$r->fields['products_image'],
                        'products_name'=>$r->fields['products_name'],
		);
		$r->MoveNext();
	}
	return $featureds;
}

function get_best_sellers($num=0){
    global $db;
    $best_sellers_query = "select op.products_id,op.products_name,count(op.products_quantity) as total_sell from ".TABLE_ORDERS." o join ".TABLE_ORDERS_PRODUCTS." op on o.orders_id=op.orders_id ".
                          "where o.orders_status=3 group by op.products_id order by total_sell desc";
    if($num!=0){
        $best_sellers_query .= " limit 0,".$num;
    }
    return $r = $db->Execute($best_sellers_query);
} 

function get_product_info($products_id){
	global $db;
	$sql = 'select * from '.TABLE_PRODUCTS.' p join '.TABLE_PRODUCTS_DESCRIPTION.' pd on p.products_id=pd.products_id where p.products_id='.(int)$products_id;
	$r = $db->Execute($sql);
	return $r->fields;
}