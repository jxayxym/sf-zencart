<?php
/** *  product_prev_next.php * * @package productTypes * @copyright Copyright 2003-2006 Zen Cart Development Team * @copyright Portions Copyright 2003 osCommerce * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0 * @version $Id: product_prev_next.php 6912 2007-09-02 02:23:45Z drbyte $ */
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
// bof: previous next
if (PRODUCT_INFO_PREVIOUS_NEXT != 0) {
	// sort order
	switch (PRODUCT_INFO_PREVIOUS_NEXT_SORT) {
		case (0) :
			$prev_next_order = ' order by LPAD(p.products_id,11,"0")';
			break;
		case (1) :
			$prev_next_order = " order by pd.products_name";
			break;
		case (2) :
			$prev_next_order = " order by p.products_model";
			break;
		case (3) :
			$prev_next_order = " order by p.products_price_sorter, pd.products_name";
			break;
		case (4) :
			$prev_next_order = " order by p.products_price_sorter, p.products_model";
			break;
		case (5) :
			$prev_next_order = " order by pd.products_name, p.products_model";
			break;
		case (6) :
			$prev_next_order = ' order by LPAD(p.products_sort_order,11,"0"), pd.products_name';
			break;
		default :
			$prev_next_order = " order by pd.products_name";
			break;
	}
	
	$current_category_id = get_master_categories_id ( ( int ) $_GET ['products_id'] );
	
	$preview_num = 9; // 缩略图预览产品的数量
	if (isset ( $_GET ['page'] )) {
		$sql = "select count(distinct(p.products_id)) as total from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . ( int ) $_SESSION ['languages_id'] . "' and p.master_categories_id=".( int ) $current_category_id. $prev_next_order;
		$r = $db->Execute ( $sql );
		$total_page = $r->fields ['total'];
		$cur_page = ( int ) $_GET ['page'];
		if ($cur_page < 1)
			$cur_page = 1;
		elseif ($cur_page > $total_page)
			$cur_page = $total_page;
	} else {
		$_sql = "select distinct(p.products_id) from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . ( int ) $_SESSION ['languages_id'] . "' and  p.master_categories_id=".( int ) $current_category_id.$prev_next_order;
		$_sql = "select products_id,(@offset:=@offset+1) row_index from (" . $_sql . ") as t2,(select @offset:=0) as t1";
		$sql = 'select row_index,@offset max_row_index from (' . $_sql . ') as t3 where products_id=' . ( int ) $_GET ['products_id'];
		
		$r = $db->Execute ( $sql );
		$current_product_offset = $r->fields ['row_index']; // 当前产品的偏移
		$max_offset = $r->fields ['max_row_index'];
		// echo $sql;exit;
		$cur_page = ceil ( $current_product_offset / $preview_num ); // 当前的页码
		$total_page = ceil ( $max_offset / $preview_num ); // 总共页数
		
		if ($cur_page<$total_page) {
			$sql = "select products_id from (".$_sql.") as t where row_index=".($preview_num*$cur_page+1);
			$r = $db->Execute ( $sql );
			$next_page_products = $r->fields['products_id'];
			$next_product_link = zen_href_link(zen_get_info_page($next_page_products),'products_id='.$next_page_products);
		}else{
			$next_product_link = '#';
		}
		if ($cur_page>1) {
			$sql = "select products_id from (".$_sql.") as t where row_index=".($preview_num*$cur_page-10);
			$r = $db->Execute ( $sql );
			$back_page_products = $r->fields['products_id'];
			$back_product_link = zen_href_link(zen_get_info_page($back_page_products),'products_id='.$back_page_products);
		}else{
			$back_product_link = '#';
		}
	}
	$offset_preview = ($cur_page - 1) * $preview_num;
	$sql = "select distinct(p.products_id),pd.products_name,p.products_image from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id=" . ( int ) $_SESSION ['languages_id'] . " and p.master_categories_id=".(int)$current_category_id. $prev_next_order . ' limit ' . $offset_preview . ',' . $preview_num;
	// echo $sql;exit;
	$products_preview = $db->Execute ( $sql );
	$i = 0;
	$content_preview = '<div id="preview_page' . $cur_page . '">';
	while ( ! $products_preview->EOF ) {
		$price_preview = zen_get_products_display_price ( $products_preview->fields ['products_id'] );
		if ($products_preview->fields ['products_id'] == $_GET ['products_id'])
			$content_preview .= '<div class="products_preview_item cur_product">';
		else
			$content_preview .= '<div class="products_preview_item">';
// 		$content_preview .= '<a href="' . zen_href_link ( zen_get_info_page ( $products_preview->fields ['products_id'] ), 'products_id=' . $products_preview->fields ['products_id'] ) . '"><img src="' . DIR_WS_IMAGES . $products_preview->fields ['products_image'] . '" alt="' . $products_preview->fields ['products_name'] . '" width="80px" height="" /></a>';
		$content_preview .= '<a href="' . zen_href_link ( zen_get_info_page ( $products_preview->fields ['products_id'] ), 'products_id=' . $products_preview->fields ['products_id'] ) . '">'.zen_image(DIR_WS_IMAGES . $products_preview->fields ['products_image'],$products_preview->fields ['products_name'],80,120).'</a>';
		$content_preview .= '</div>';
		$products_preview->MoveNext ();
		$i ++;
	}
	for(; $i < $preview_num; $i ++) {
		$content_preview .= '<div class="products_preview_item_place_hold">';
		$content_preview .= '</div>';
	}
	$content_preview .= '</div>';
	$javascript_obj = "{cur_page:" . $cur_page . ",total_page:" . $total_page . "}";
}
// eof: previous next
?>