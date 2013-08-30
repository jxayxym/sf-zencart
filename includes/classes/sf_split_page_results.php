<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

class sf_splitPageResults extends splitPageResults{
	
  //override method display_links	
  function display_links($max_page_links, $parameters = '') {
    global $request_type;
    if ($max_page_links == '') $max_page_links = 1;

    $display_links_string = '';

    $class = '';

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    // previous button - not displayed on first page
    if ($this->number_of_pages>1) {
	    if ($this->current_page_number > 1) 
	    	$display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;&nbsp;';
		else{
			$display_links_string .= '<span>' . PREVNEXT_BUTTON_PREV . '</span>&nbsp;&nbsp;';
		} 
    }	
    
    $right_page_num = ceil($max_page_links/2); 
    $left_page_num = $max_page_links-$right_page_num;
    
    $jump_to_page = 0;
    //current page left page link
    $left_display_links_string = '';
    for ($i=1;$i<=$left_page_num;$i++){
    	$jump_to_page = $this->current_page_number-$i;
    	if ($jump_to_page<1) break;
    	$left_display_links_string = '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>&nbsp;'.$left_display_links_string;
    }
    if ($jump_to_page>3) {
    	$left_display_links_string = '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=1', $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">1</a>&nbsp;...'.$left_display_links_string;
    }elseif ($jump_to_page==2){
    	$left_display_links_string = '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=1', $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">1</a>&nbsp;'.$left_display_links_string;
    }
    //current page right page link
    $right_display_links_string = '';
    for ($i=0;$i<$right_page_num;$i++){
    	$jump_to_page = $this->current_page_number+$i;
    	if ($jump_to_page>$this->number_of_pages) break;
    	if ($jump_to_page==$this->current_page_number) {
    		$right_display_links_string .= '&nbsp;<span class="currentPage">' . $jump_to_page . '</span>&nbsp;';
    	}else
    		$right_display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>&nbsp;';
    }
    if ($jump_to_page<($this->number_of_pages-1)) {
    	$right_display_links_string .= '...&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $this->number_of_pages . '</a>';
    }elseif ($jump_to_page==($this->number_of_pages-1)){
    	$right_display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $this->number_of_pages . '</a>';
    }
    $display_links_string = $left_display_links_string.$right_display_links_string;
    if ($this->number_of_pages>1) {
    	if ($this->current_page_number>1) {
    		$display_links_string = '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;'.$display_links_string;
    	}else 
    		$display_links_string = '<span class="prevBackDisabled">' . PREVNEXT_BUTTON_PREV . '</span>&nbsp;'.$display_links_string;
    	
    	if ($this->current_page_number<$this->number_of_pages)
    		$display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a>';
    	else
    		$display_links_string .= '&nbsp;<span class="prevBackDisabled">' . PREVNEXT_BUTTON_NEXT . '</span>';
    }
    return $display_links_string;
  }
}