<?php
$content .= '<div class="sideBoxContent centeredContent">';
$recently_viewed_box_counter = 0;
while (!$recently_viewed_products->EOF) {
	$recently_viewed_price = zen_get_products_display_price($recently_viewed_products->fields['products_id']);
	$content .= "\n" . '  <div class="sideBoxContentItem">';
	$content .= '<a href="' . zen_href_link(zen_get_info_page($recently_viewed_products->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($recently_viewed_products->fields['master_categories_id']) . '&products_id=' . $recently_viewed_products->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $recently_viewed_products->fields['products_image'], $recently_viewed_products->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
	$content .= '<br />' . $recently_viewed_products->fields['products_name'] . '</a>';
	$content .= '<div>' . $recently_viewed_price . '</div>';
	$content .= '</div>';
	if($recently_viewed_box_counter==6) break;
	$recently_viewed_box_counter++;
	$recently_viewed_products->MoveNext();
}
$content .= '</div>' . "\n";