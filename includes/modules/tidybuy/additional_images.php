<?php
/** * additional_images module * * Prepares list of additional product images to be displayed in template * * @package templateSystem * @copyright Copyright 2003-2011 Zen Cart Development Team * @copyright Portions Copyright 2003 osCommerce * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0 * @version $Id: additional_images.php 18697 2011-05-04 14:35:20Z wilt $ */
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
if (! defined ( 'IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE' ))
	define ( 'IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE', 'Yes' );
$images_array = array ();
// do not check for additional images when turned off
if ($products_image != '' && $flag_show_product_info_additional_images != 0) {
	// prepare image name
	$products_image_extension = substr ( $products_image, strrpos ( $products_image, '.' ) );
	$products_image_base = str_replace ( $products_image_extension, '', $products_image );
	// if in a subdirectory
	if (strrpos ( $products_image, '/' )) {
		$products_image_match = substr ( $products_image, strrpos ( $products_image, '/' ) + 1 );
		// echo 'TEST 1: I match ' . $products_image_match . ' - ' . $file . ' - base ' . $products_image_base . '<br>';
		$products_image_match = str_replace ( $products_image_extension, '', $products_image_match ) . '_';
		$products_image_base = $products_image_match;
	}
	$products_image_directory = str_replace ( $products_image, '', substr ( $products_image, strrpos ( $products_image, '/' ) ) );
	if ($products_image_directory != '') {
		$products_image_directory = DIR_WS_IMAGES . str_replace ( $products_image_directory, '', $products_image ) . "/";
	} else {
		$products_image_directory = DIR_WS_IMAGES;
	}
	
	// Check for additional matching images
	$file_extension = $products_image_extension;
	$products_image_match_array = array ();
	if ($dir = @dir ( DIR_FS_CATALOG.$products_image_directory )) {
		while ( $file = $dir->read () ) {
			if (! is_dir ( $products_image_directory . $file )) {
				if (substr ( $file, strrpos ( $file, '.' ) ) == $file_extension) {
// 					if (preg_match ( '/\Q' . $products_image_base . '\E/i', $file ) == 1) {
// 						if ($file != $products_image) {
// 							if ($products_image_base . str_replace ( $products_image_base, '', $file ) == $file) {
								// echo 'I AM A MATCH ' . $file . '<br>';
								$images_array [] = $file;
// 							} else {
								// echo 'I AM NOT A MATCH ' . $file . '<br>';
// 							}
// 						}
// 					}
				}
			}
		}
// 		if (sizeof ( $images_array )) {
// 			$images_array [] = pathinfo ( $products_image, PATHINFO_BASENAME );
// 			sort ( $images_array );
// 		}
		$dir->close ();
	}
}
// Build output based on images found
$num_images = sizeof ( $images_array );
$list_box_contents = '';
$title = '';
if ($num_images) {
	$row = 0;
	$col = 0;
	if ($num_images < IMAGES_AUTO_ADDED || IMAGES_AUTO_ADDED == 0) {
		$col_width = floor ( 100 / $num_images );
	} else {
		$col_width = floor ( 100 / IMAGES_AUTO_ADDED );
	}
	for($i = 0, $n = $num_images; $i < $n; $i ++) {
		$file = $images_array [$i];
		$products_image_large = str_replace ( DIR_WS_IMAGES, DIR_WS_IMAGES . 'large/', $products_image_directory ) . str_replace ( $products_image_extension, '', $file ) . IMAGE_SUFFIX_LARGE . $products_image_extension;
		// bof Zen Lightbox 2008-12-11 aclarke
		// next line is commented out for Image Handler
		// $flag_has_large = file_exists($products_image_large);
		if (function_exists ( 'handle_image' )) {
			$flag_has_large = true;
		} else {
			// eof Zen Lightbox 2008-12-11 aclarke
			$flag_has_large = file_exists ( $products_image_large );
			// bof Zen Lightbox 2008-12-11 aclarke
		}
		// eof Zen Lightbox 2008-12-11 aclarke
		$products_image_large = ($flag_has_large ? $products_image_large : $products_image_directory . $file);
		$flag_display_large = (IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE == 'Yes' || $flag_has_large);
		$base_image = $products_image_directory . $file;
		// $thumb_slashes = zen_image(addslashes($base_image), addslashes($products_name), 60, 80);
		// $thumb_slashes = '<img src="'.addslashes($base_image).'" width="60px" height="60px" alt="'.addslashes($products_name).'" title="'.addslashes($products_name).'">';
		$thumb_slashes = zen_image ( $base_image, addslashes ( $products_name ), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT );
		
		if (! file_exists ( $products_image_large )) {
			$products_image_large = $base_image;
		}
		// bof Zen Lightbox 2008-12-11 aclarke
		if (function_exists ( 'handle_image' )) {
			// remove additional single quotes from image attributes (important!)
			$thumb_slashes = preg_replace ( "/([^\\\\])'/", '$1\\\'', $thumb_slashes );
		}
		// eof Zen Lightbox 2008-12-11 aclarke
		$thumb_regular = zen_image ( $base_image, $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT );
		$large_link = zen_href_link ( FILENAME_POPUP_IMAGE_ADDITIONAL, 'pID=' . $_GET ['products_id'] . '&pic=' . $i . '&products_image_large_additional=' . $products_image_large );
		// Link Preparation:
		// bof Zen Lightbox 2008-12-11 aclarke
		if (ZEN_LIGHTBOX_STATUS == 'true') {
			if (ZEN_LIGHTBOX_GALLERY_MODE == 'true') {
				// $rel = 'lightbox-g';
				$rel = "lightbox-g {gallery: \\'gal1\\', smallimage: \\'" . addslashes ( $base_image) . "\\',largeimage: \\'" . $products_image_large . "\\'}";
			} else {
				$rel = 'lightbox';
			}
			$script_link = '<script type="text/javascript"><!--' . "\n" . 'document.write(\'' . ($flag_display_large ? '<a href="' . zen_lightbox ( $products_image_large, addslashes ( $products_name ), LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT ) . '" rel="' . $rel . '" title="' . addslashes ( $products_name ) . '">' . $thumb_slashes . '</a>' : $thumb_slashes) . '\');' . "\n" . '//--></script>';
		} else {
			// eof Zen Lightbox 2008-12-11 aclarke
			$script_link = '<script type="text/javascript"><!--' . "\n" . 'document.write(\'' . ($flag_display_large ? '<a href="javascript:popupWindow(\\\'' . str_replace ( $products_image_large, urlencode ( addslashes ( $products_image_large ) ), $large_link ) . '\\\')">' . $thumb_slashes . '<br />' . TEXT_CLICK_TO_ENLARGE . '</a>' : $thumb_slashes) . '\');' . "\n" . '//--></script>';
			// bof Zen Lightbox 2008-12-11 aclarke
		}
		// eof Zen Lightbox 2008-12-11 aclarke
		$noscript_link = '<noscript>' . ($flag_display_large ? '<a href="' . zen_href_link ( FILENAME_POPUP_IMAGE_ADDITIONAL, 'pID=' . $_GET ['products_id'] . '&pic=' . $i . '&products_image_large_additional=' . $products_image_large ) . '" target="_blank">' . $thumb_regular . '</a>' : $thumb_regular) . '</noscript>';
		// $alternate_link = '<a href="' . $products_image_large . '" onclick="javascript:popupWindow(\''. $large_link . '\') return false;" title="' . $products_name . '" target="_blank">' . $thumb_regular . '<br />' . TEXT_CLICK_TO_ENLARGE . '</a>';
		$link = $script_link . "\n      " . $noscript_link;
		// $link = $alternate_link;
		// List Box array generation:
		$list_box_contents [$row] [$col] = array (
				'params' => 'class="additionalImages centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
				'text' => "\n      " . $link 
		);
		$col ++;
		if ($col > (IMAGES_AUTO_ADDED - 1)) {
			$col = 0;
			$row ++;
		}
	} // end for loop
} // endif