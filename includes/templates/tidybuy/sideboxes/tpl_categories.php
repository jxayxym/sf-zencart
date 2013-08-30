<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_categories.php 4162 2006-08-17 03:55:02Z ajeh $
 */
  $content = "";
  
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  while(!$sub_categories->EOF){
	$content .= '<div class="sideboxCategoriesEntry"><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$sub_categories->fields['categories_id']).'">'.$sub_categories->fields['categories_name'].'</a></div>';
	$sub_categories->MoveNext();
  }
  $content .= '</div>';
?>