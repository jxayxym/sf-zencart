<?php
$query = 'select m.manufacturers_id,upper(LEFT(m.manufacturers_name,1)) tag,m.manufacturers_name,m.manufacturers_image from '.TABLE_MANUFACTURERS.' m join '.TABLE_MANUFACTURERS_INFO.' m_info on '.
		 'm.manufacturers_id=m_info.manufacturers_id where languages_id='.(int)$_SESSION['languages_id'].' order by tag asc';
$result_brands = $db->execute($query);

$tag_list = array();
while (!$result_brands->EOF){
	$tag_list[$result_brands->fields['tag']][] = array(
			'manufacturers_id'=>$result_brands->fields['manufacturers_id'],
			'manufacturers_name'=>$result_brands->fields['manufacturers_name'],
			'manufacturers_image'=>$result_brands->fields['manufacturers_image'],
	);
	$result_brands->MoveNext();
}
require($template->get_template_dir('tpl_brands_default.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_brands_default.php');