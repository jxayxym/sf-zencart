<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_manufacturers_select.php 15882 2010-04-11 16:37:54Z wilt $
 */
  $content = "";
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">';
  if (zen_not_null($manufacturer_sidebox_array)){
  	$content .= '<ul>';
  	$parameters = zen_get_all_get_params(array('info', 'x', 'y','manufacturers_id'));
    foreach ($manufacturer_sidebox_array as $entry){
      if (zen_not_null($manufacturers_array) && in_array($entry['id'],$manufacturers_array)){
      	$class = 'class="hoverLineThrough fw_bold"';
      	$m_params = implode('_',array_diff($manufacturers_array,array($entry['id'])));
      }elseif (zen_not_null($manufacturers_array)){
      	$class = 'class="hoverUnderline"';
      	$m_params = implode('_',array_merge(array($entry['id']),$manufacturers_array));
      }else{
      	$class = 'class="hoverUnderline"';
      	$m_params = $entry['id'];
      }	
  	  $content .= '<li><a '.$class.' href="'.zen_href_link(FILENAME_DEFAULT,$parameters.'manufacturers_id='.$m_params).'" title="'.$entry['full_text'].'">'.$entry['text'].'</a></li>';
    }
    $content .= '</ul>';
  }
  $content .= '</div>';
?>