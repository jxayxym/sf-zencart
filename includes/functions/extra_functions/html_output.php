<?php
/**
 * generate CSS buttons in the current language
 * concept from contributions by Seb Rouleau and paulm, subsequently adapted to Zen Cart
 * note: any hard-coded buttons will not be able to use this function
 **/
function zenCssButton($image = '', $text, $type, $sec_class = '', $parameters = '') {

	// if no secondary class is set use the image name for the sec_class
	if (empty($sec_class)) $sec_class = basename($image, '.gif');
	if(!empty($sec_class))$sec_class = ' ' . $sec_class;
	if(!empty($parameters))$parameters = ' ' . $parameters;
	$mouse_out_class  = 'cssButton' . $sec_class;

	if ($type == 'submit'){
		// form input button
		$css_button = '<input class="' . $mouse_out_class . '" type="submit" value="' .$text . '"' . $parameters . $style . ' />';
	}

	if ($type=='button'){
		// link button
		$css_button = '<span class="' . $mouse_out_class . '">&nbsp;' . $text . '&nbsp;</span>'; // add $parameters ???
	}
	return $css_button;
}

function sf_draw_image($src,$alt,$width,$height,$params='')
{
	$src = 'image_handle.php?path='.$src.'&width='.$width.'&height='.$height;
	$html = '<img src="images/loading.gif" data-src='.$src.' alt="'.zen_clean_html($alt).'" width="'.$width.'px" height="'.$height.'px"';
	if (zen_not_null($params)) {
		$html .= ' '.$params;
	}
	$html .= ' />';
	return $html;
}