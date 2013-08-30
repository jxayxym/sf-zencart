<?php
/**
 * categories_tabs.php module
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: categories_tabs.php 3018 2006-02-12 21:04:04Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

/*最多支持2级的分类
$sql = 'select c1.`categories_id` top_id,cd1.`categories_name` top_name,c2.`categories_id` child_id,cd2.`categories_name` child_name from '.TABLE_CATEGORIES.' c1 '.
'left join '.TABLE_CATEGORIES.' c2 on c1.`categories_id`=c2.`parent_id` '.
'join '.TABLE_CATEGORIES_DESCRIPTION.' cd1 on cd1.`categories_id`=c1.`categories_id` left join '.
TABLE_CATEGORIES_DESCRIPTION.' cd2 on cd2.`categories_id`=c2.`categories_id` '.
'where c1.`parent_id`=0';

$order_by = " order by c1.sort_order, cd1.categories_name,c2.sort_order, cd2.categories_name ";

$sql = $sql.$order_by;
// echo $sql;
$r = $db->Execute($sql);
$categories_tabs = array();
while (!$r->EOF) {
	
	if(!isset($categories_tabs[$r->fields['top_id']]))
		$categories_tabs[$r->fields['top_id']] = array();
	$categories_tabs[$r->fields['top_id']]['top_name'] = $r->fields['top_name'];
	if (zen_not_null($r->fields['child_id'])){
		if (!isset($categories_tabs[$r->fields['top_id']]['children'])) 
			$categories_tabs[$r->fields['top_id']]['children'] = array();
		$categories_tabs[$r->fields['top_id']]['children'][] = array('categories_id'=>$r->fields['child_id'],'categories_name'=>$r->fields['child_name']);
	}

  $r->MoveNext();
}
*/
//无限级分类
$sql = 'select c.categories_id,cd.categories_name,c.parent_id from '.TABLE_CATEGORIES.' c join '.TABLE_CATEGORIES_DESCRIPTION.' cd on c.categories_id=cd.categories_id where c.categories_status=1 and cd.language_id='.(int)$_SESSION['languages_id'].' order by c.sort_order asc,c.categories_id asc';
$r = $db->Execute($sql);
$categories_tree = array();
while (!$r->EOF) {

	if(!isset($categories_tree[$r->fields['parent_id']]))
		$categories_tree[$r->fields['parent_id']] = array();
	$categories_tree[$r->fields['parent_id']][] = array(
				'categories_id'=>$r->fields['categories_id'],
				'categories_name'=>$r->fields['categories_name'],
			);
	$r->MoveNext();
}
$sql = 'select max(last_modified) as last_modified from '.TABLE_CATEGORIES.' c join '.TABLE_CATEGORIES_DESCRIPTION.' cd on c.categories_id=cd.categories_id where c.categories_status=1 and cd.language_id='.(int)$_SESSION['languages_id'];
$r = $db->Execute($sql);
$last_modified = $r->fields['last_modified'];
?>