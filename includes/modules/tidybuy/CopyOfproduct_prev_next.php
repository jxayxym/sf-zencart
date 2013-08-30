<?php
/**
 *  product_prev_next.php
 *
 * @package productTypes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_prev_next.php 6912 2007-09-02 02:23:45Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// bof: previous next
if (PRODUCT_INFO_PREVIOUS_NEXT != 0) {
  // sort order
  switch(PRODUCT_INFO_PREVIOUS_NEXT_SORT) {
    case (0):
    $prev_next_order= ' order by LPAD(p.products_id,11,"0")';
    break;
    case (1):
    $prev_next_order= " order by pd.products_name";
    break;
    case (2):
    $prev_next_order= " order by p.products_model";
    break;
    case (3):
    $prev_next_order= " order by p.products_price_sorter, pd.products_name";
    break;
    case (4):
    $prev_next_order= " order by p.products_price_sorter, p.products_model";
    break;
    case (5):
    $prev_next_order= " order by pd.products_name, p.products_model";
    break;
    case (6):
    $prev_next_order= ' order by LPAD(p.products_sort_order,11,"0"), pd.products_name';
    break;
    default:
    $prev_next_order= " order by pd.products_name";
    break;
  }

/*
  if (!$current_category_id || SHOW_CATEGORIES_ALWAYS == 1) {
    $sql = "SELECT categories_id
            from   " . TABLE_PRODUCTS_TO_CATEGORIES . "
            where  products_id ='" .  (int)$_GET['products_id']
    . "'";
    $cPath_row = $db->Execute($sql);
    $current_category_id = $cPath_row->fields['categories_id'];
    $cPath = $current_category_id;
  }
*/
  
	if (isset($_GET['cPath'])&&preg_match('/\d(_\d)*/', $_GET['cPath'])){
		$cPath = $_GET['cPath'];
	}
  if ($cPath < 1 || !isset($_GET['cPath'])) {
    $cPath = zen_get_product_path((int)$_GET['products_id']);
  }
  $cPath_array = zen_parse_category_path($cPath);
  $cPath = implode('_', $cPath_array);
  $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  
// 	$sql = 'select ,products_id from ' . TABLE_PRODUCTS . ',(select @offset:=0) as t where products_id='.(int)$_GET['products_id'];
//   $sql = "select (@offset:=@offset+1) row_index, p.products_id
//           from   " . TABLE_PRODUCTS . " p, "
//   . TABLE_PRODUCTS_DESCRIPTION . " pd, "
//   . TABLE_PRODUCTS_TO_CATEGORIES . " ptc,(select @offset:=-1) as t
//           where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . (int)$_SESSION['languages_id'] . "' and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$current_category_id . "'" .
//   $prev_next_order;

//   $sql = 'select row_index,@offset max_row_index from ('.$sql.') as t2 where products_id='.(int)$_GET['products_id'];

  $sql = "select p.products_id from   " . TABLE_PRODUCTS . " p, ". TABLE_PRODUCTS_DESCRIPTION . " pd, ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc
          where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . (int)$_SESSION['languages_id'] . "' and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$current_category_id . "'" .
            $prev_next_order;
  $sql = "select products_id,(@offset:=@offset+1) row_index from (".$sql.") as t2,(select @offset:=-1) as t1";
  $sql = 'select row_index,@offset max_row_index from ('.$sql.') as t3 where products_id='.(int)$_GET['products_id'];
  $r = $db->Execute($sql);
  $current_product_offset = $r->fields['row_index'];//当前产品的偏移
  $max_offset = $r->fields['max_row_index'];
// echo $sql;exit;  
  $preview_num = 18;//缩略图预览产品的数量
  $preview_pre_num = floor($preview_num/2);
  $preview_suff_num = $preview_num-$preview_pre_num-1;
  
  $offset_preview = $current_product_offset-$preview_pre_num;
  $offset_preview = $offset_preview<0?0:$offset_preview;
  
  $sql = "select p.products_id,pd.products_name,p.products_image
          from   " . TABLE_PRODUCTS . " p, "
  . TABLE_PRODUCTS_DESCRIPTION . " pd, "
  . TABLE_PRODUCTS_TO_CATEGORIES . " ptc
          where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . (int)$_SESSION['languages_id'] . "' and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$current_category_id . "'" .
  $prev_next_order . ' limit '.$offset_preview.','.$preview_num;
//  echo $sql;
  $products_preview = $db->Execute($sql);
  
  //向前翻页对应的产品
  if($offset_preview>0){
	  if(($offset_preview+1)<=$preview_num)
	  		$offset_back_page = 0;
	  else 
	  		$offset_back_page = $offset_preview+1-$preview_num;
	//   echo 'offset_preview='.$offset_preview;
	//   echo ',offset_back_page='.$offset_back_page;
	  $sql = "select p.products_id
	          from   " . TABLE_PRODUCTS . " p, "
	  . TABLE_PRODUCTS_DESCRIPTION . " pd, "
	  . TABLE_PRODUCTS_TO_CATEGORIES . " ptc
	          where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . (int)$_SESSION['languages_id'] . "' and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$current_category_id . "'" .
	  $prev_next_order . ' limit '.$offset_back_page.',1';
	  $r = $db->Execute($sql);
	  $back_products_id = $r->fields['products_id'];
  }else 
  	$back_products_id = 0;
//   echo 'back_products_id='.$back_products_id;
  //向后翻页对应的产品
  $offset_next_page = $offset_preview+$preview_num;
  if($offset_next_page<=$max_offset){
	  $sql = "select p.products_id
	          from   " . TABLE_PRODUCTS . " p, "
	            		. TABLE_PRODUCTS_DESCRIPTION . " pd, "
	            				. TABLE_PRODUCTS_TO_CATEGORIES . " ptc
	          where  p.products_status = '1' and p.products_id = pd.products_id and pd.language_id= '" . (int)$_SESSION['languages_id'] . "' and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$current_category_id . "'" .
	            $prev_next_order . ' limit '.$offset_next_page.',1';
	  $r = $db->Execute($sql);
	  $next_products_id = $r->fields['products_id'];
  }else{
  	$next_products_id = 0;
  }
  
  $content_preview = '';
  while (!$products_preview->EOF){
  	$price_preview = zen_get_products_display_price($products_preview->fields['products_id']);
  	$content_preview .= '<div class="products_preview_item">';
  	$content_preview .=  '<a href="' . zen_href_link(zen_get_info_page($products_preview->fields['products_id']),'products_id=' . $products_preview->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $products_preview->fields['products_image'], $products_preview->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT).'</a>';
  	$content_preview .=  '</div>';
  	$products_preview->MoveNext();
  }  
  
//   echo 'next_products_id='.$next_products_id;
}
// eof: previous next
?>