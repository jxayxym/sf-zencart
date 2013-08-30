<?php
/**
 * manufacturers sidebox - displays a list of manufacturers so customer can choose to filter on their products only
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Thu Jul 12 12:27:04 2012 -0400 Modified in v1.5.1 $
 */

// test if manufacturers sidebox should show
  $show_manufacturers= true;
// for large lists of manufacturers uncomment this section
/*
  if (($_GET['main_page']==FILENAME_DEFAULT and ($_GET['cPath'] == '' or $_GET['cPath'] == 0)) or  ($request_type == 'SSL')) {
    $show_manufacturers= false;
  } else {
    $show_manufacturers= true;
  }
*/
if ($show_manufacturers) {
// only check products if requested - this may slow down the processing of the manufacturers sidebox
  $manufacturer_sidebox_query = "select m.manufacturers_id, m.manufacturers_name,count(distinct p.products_id) as num 
                            from " . TABLE_MANUFACTURERS . " m
                            join " . TABLE_PRODUCTS . " p on m.manufacturers_id = p.manufacturers_id ";
  if (isset($current_category_id)){
  	$manufacturer_sidebox_query .= "join ".TABLE_PRODUCTS_TO_CATEGORIES." p2c on p2c.products_id=p.products_id "; 
  }  
  $manufacturer_sidebox_query .= "where m.manufacturers_id = p.manufacturers_id and p.products_status= 1 ";
  if (zen_not_null($current_category_id)){
  	$manufacturer_sidebox_query .= "and p2c.categories_id={$current_category_id} ";
  }
  $manufacturer_sidebox_query .= "group by m.manufacturers_id order by manufacturers_name";
  $manufacturer_sidebox = $db->Execute($manufacturer_sidebox_query);

  if ($manufacturer_sidebox->RecordCount()>0) {
    $number_of_rows = $manufacturer_sidebox->RecordCount()+1;

// Display a list
    $manufacturer_sidebox_array = array();
    while (!$manufacturer_sidebox->EOF) {
      $manufacturer_sidebox_name = zen_output_string(((strlen($manufacturer_sidebox->fields['manufacturers_name']) > (int)MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturer_sidebox->fields['manufacturers_name'], 0, (int)MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturer_sidebox->fields['manufacturers_name']), false, true);
      $manufacturer_sidebox_array[] = array('id' => $manufacturer_sidebox->fields['manufacturers_id'],
                                       'text' => (in_array($manufacturer_sidebox->fields['manufacturers_id'],$manufacturers_array)?zen_image(DIR_WS_TEMPLATE_IMAGES.'checkboxchecked.gif'):zen_image(DIR_WS_TEMPLATE_IMAGES.'checkbox.gif')).'&nbsp;'.$manufacturer_sidebox_name.'('.$manufacturer_sidebox->fields['num'].')');

      $manufacturer_sidebox->MoveNext();
    }
    $box_id = 'brands';
      require($template->get_template_dir('tpl_manufacturers_select.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_manufacturers_select.php');

    $title = '<label>' . BOX_HEADING_MANUFACTURERS . '</label>';
    $title_link = false;
    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
  }
} // $show_manufacturers
