<?php
/**
 * Module Template - categories_tabs
 *
 * Template stub used to display categories-tabs output
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_categories_tabs.php 3395 2006-04-08 21:13:00Z ajeh $
 */

include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_CATEGORIES_TABS));
$cache_filename = DIR_FS_SQL_CACHE.'/cache_modules_categories_tabs.php';
if (file_exists($cache_filename) && filemtime ($cache_filename)>strtotime($last_modified)) {
	include $cache_filename;
}else{
	$string = '<ul id="navCatTabs">';  
	$string .= '<li class="navCatTabs-home"><a href="'.zen_href_link(FILENAME_DEFAULT).'">HOME</a></li>';
	if (zen_not_null($categories_tree))	{
			$stack_array = array();
			$deep_stack = array();
			$deep_counter = array(0=>0);
			for ($i = count($categories_tree[0])-1;$i>=0;$i--){
				array_push($stack_array,$categories_tree[0][$i]);
				array_push($deep_stack,0);
				$deep_counter[0]++;//深度计数器
			}
			$deep_now = 0;
			$deep_next = 0;
			
			do {
				$note = array_pop($stack_array);
				$deep_now = array_pop($deep_stack);//当前深度
				$deep_next = $deep_now;//下一个的深度
				
				$deep_counter[$deep_now]--;//当前深度减一
				if (zen_not_null($categories_tree[$note['categories_id']])){
					$deep_next++;
					if (!isset($deep_counter)) $deep_counter[$deep_next] = 0;
					for ($i=count($categories_tree[$note['categories_id']])-1;$i>=0;$i--){
						array_push($stack_array,$categories_tree[$note['categories_id']][$i]);
						$deep_counter[$deep_next]++;
						array_push($deep_stack,$deep_next);
					}
				}else{
					$deep_next = end($deep_stack);
				}
				$string .= '<li id="categories_tab'.$note['categories_id'].'" class="deep_li'.$deep_now.($deep_now<$deep_next?' hasChildren':'').'"><a class="deep_a'.$deep_now.'" href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$note['categories_id']).'">'.$note['categories_name'].'</a>';
				if ($deep_now<$deep_next)
					$string .= '<ul id="categories'.$note['categories_id'].'_children" class="deep_ul'.$deep_now.'">';
				elseif($deep_next<$deep_now){
					$string .= '</li>'.str_repeat('</ul></li>',$deep_now-$deep_next);
				}else
					$string .= '</li>';
			}while (zen_not_null($stack_array));
		}
	// echo '<li class="deep_li0"><a href="'.zen_href_link(FILENAME_BRANDS).'" class="deep_a0">All Brands</a></li>';	
	$string .= '</ul>';
	$f = fopen($cache_filename, 'w');
	fwrite($f, $string);
	fclose($f);
	echo $string;
}
?>