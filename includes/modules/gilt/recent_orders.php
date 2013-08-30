<?php
  $orders_history_query = "select distinct op.products_id,p.products_id,p.products_image,op.products_name,o.delivery_state,o.delivery_country 
                   from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p
                   where o.orders_id = op.orders_id
                   and op.products_id = p.products_id
                   and p.products_status = '1'
                   order by o.date_purchased desc
                   limit 0," . 20;
   $orders = $db->Execute($orders_history_query);
   if ($orders->RecordCount() > 0) {
     $box_id =  'recent-orders';
     $content = '<div id="recent-orders-data" class="sideBoxContent">';
      while (!$orders->EOF) {
      	$products_name = array();
      	explode_utf8_str($orders->fields['products_name'],50,$products_name);
      	$img = zen_image(DIR_WS_IMAGES . $orders->fields['products_image'], $orders->fields['products_name'], 100, 100,'style="float:left;"');
      	$content .= '<div class="marquee-item">';
        $content .= '<a href="'.zen_href_link(zen_get_info_page($orders->fields['products_id']), 'products_id=' . (int)$orders->fields['products_id']).'">'.$img.$products_name[0].'...';
        $content .= ' ship to '.$orders->fields['delivery_state'].','.$orders->fields['delivery_country'].'</a>';
        $content .= '<br class="clearBoth" /></div>';
        $orders->MoveNext();
      }
      	$content .= '</div>';
  		$title =  'Recent Orders';
  		$title_link = false;
  		require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);      
    }   