<?php
/**
 * reviews sidebox - displays a random product-review
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: reviews.php 16044 2010-04-23 01:15:45Z drbyte $
 */

// if review must be approved or disabled do not show review
  $review_status = " and r.status = 1 ";

  $random_review_sidebox_select = "select r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name,
                    substring(reviews_text, 1, 70) as reviews_text
                    from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, "
                           . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                    where p.products_status = '1'
                    and p.products_id = r.products_id
                    and r.reviews_id = rd.reviews_id
                    and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'
                    and p.products_id = pd.products_id
                    and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
                    $review_status;

  $random_review_sidebox_product = $db->ExecuteRandomMulti($random_review_sidebox_select, 20);
  $content = "";
  $box_id = "index_reviews";
  if ($random_review_sidebox_product->RecordCount() > 0) {
	  $review_box_counter = 0;
	  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">';
	  while (!$random_review_sidebox_product->EOF) {
	    $review_box_counter++;
	    $content .= '<div class="marquee-item">';
	    $content .= '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id']) . '">';
	    $content .= '<div class="back">';
	    $content .= zen_image(DIR_WS_IMAGES . $random_review_sidebox_product->fields['products_image'], $random_review_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,'class="back"').'<br />'.zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $random_review_sidebox_product->fields['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_review_sidebox_product->fields['reviews_rating']));
	    $content .= '</div>';
	    $content .= zen_trunc_string(nl2br(zen_output_string_protected(stripslashes($random_review_sidebox_product->fields['reviews_text']))), 60);
	    $content .= '</a>';
	    $content .= '<br class="clearBoth" /></div>';
	    $random_review_sidebox_product->MoveNextRandom();
	  }
	  $content .= '</div>';
  } 
  $title =  BOX_HEADING_REVIEWS;
  $title_link = FILENAME_REVIEWS;
  require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
?>