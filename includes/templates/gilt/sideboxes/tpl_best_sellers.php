<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_best_sellers.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = '';
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content .= '<div class="bestSellerwrapper">' . "\n" . '<ol id="ol_best_sellers">' . "\n";
  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
    $content .= '<li style="border-bottom:1px solid #E9E8E6;"><a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 'products_id=' . $bestsellers_list[$i]['id']) . '">'.zen_image(zen_output_string(DIR_WS_IMAGES.$bestsellers_list[$i]['image']),zen_output_string($bestsellers_list[$i]['name'],false,true),300,500).'<span class="bestSellerName">NO.'.$i .'&nbsp;&nbsp;'. zen_output_string(zen_trunc_string($bestsellers_list[$i]['name'], BEST_SELLERS_TRUNCATE, BEST_SELLERS_TRUNCATE_MORE),false,true) .'</span></a></li>' . "\n";
  }
  $content .= '</ol>' . "\n";
  $content .= '</div>' . "\n";
  $content .= '</div>';
?>