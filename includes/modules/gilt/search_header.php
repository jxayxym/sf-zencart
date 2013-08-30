<?php
//  $content = 'search:';
  $content .= '<div class="search-container" id="search_container">';
  $content .= zen_draw_form('quick_find_header', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false), 'get');
 
  $content .= zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
  $content .= zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();

//  if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes') {
//    $content .= zen_draw_input_field('keyword', '', 'size="6" maxlength="30" style="width: 100px" value="' . HEADER_SEARCH_DEFAULT_TEXT . '" onfocus="if (this.value == \'' . HEADER_SEARCH_DEFAULT_TEXT . '\') this.value = \'\';" onblur="if (this.value == \'\') this.value = \'' . HEADER_SEARCH_DEFAULT_TEXT . '\';"') . '&nbsp;' . zen_image_submit (BUTTON_IMAGE_SEARCH,HEADER_SEARCH_BUTTON);
//  } else {
//    $content .= zen_draw_input_field('keyword', '', 'size="6" maxlength="30" style="width: 150px" value="' . HEADER_SEARCH_DEFAULT_TEXT . '" onfocus="if (this.value == \'' . HEADER_SEARCH_DEFAULT_TEXT . '\') this.value = \'\';" onblur="if (this.value == \'\') this.value = \'' . HEADER_SEARCH_DEFAULT_TEXT . '\';"') . '&nbsp;<input type="submit" value="' . HEADER_SEARCH_BUTTON . '" style="width: 60px" />';
//  }
  $content .= zen_draw_input_field('keyword','','id="search_input" class="back" placeholder="'.HEADER_SEARCH_DEFAULT_TEXT.'"');
  $content .= '<button class="search-submit hide-text forward" type="submit">Search</button>';
  $content .= "</form>";
  $content .= '</div>';
  $content .= '<script type="text/javascript">$(document).ready(function(){ $("#search_input").focus(function(){$("#search_container").addClass("selected");}).focusout(function(){ $("#search_container").removeClass("selected"); }); });</script>';
  echo $content;
?>