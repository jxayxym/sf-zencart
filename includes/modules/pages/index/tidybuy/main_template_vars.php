<?php
/**
 * index main_template_vars.php
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 18695 2011-05-04 05:24:19Z drbyte $
 */

// This should be first line of the script:
$zco_notifier->notify ( 'NOTIFY_HEADER_START_INDEX_MAIN_TEMPLATE_VARS' );

// die($category_depth);
// die($_GET['music_genre_id']);

if (isset ( $_GET ['options_values_id'] ) && $_GET ['options_values_id'] <= 0) {
	unset ( $_GET ['options_values_id'] );
}

// release manufacturers_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
if (isset ( $_GET ['manufacturers_id'] ) && $_GET ['manufacturers_id'] <= 0) {
	unset ( $_GET ['manufacturers_id'] );
	unset ( $manufacturers_id );
}

// release music_genre_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
if (isset ( $_GET ['music_genre_id'] ) && $_GET ['music_genre_id'] <= 0) {
	unset ( $_GET ['music_genre_id'] );
	unset ( $music_genre_id );
}

// release record_company_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
if (isset ( $_GET ['record_company_id'] ) && $_GET ['record_company_id'] <= 0) {
	unset ( $_GET ['record_company_id'] );
	unset ( $record_company_id );
}

// only release typefilter if both record_company_id and music_genre_id are blank
// this will result in the home page, if used
if ((isset ( $_GET ['record_company_id'] ) && $_GET ['record_company_id'] <= 0) and (isset ( $_GET ['music_genre_id'] ) && $_GET ['music_genre_id'] <= 0)) {
	unset ( $_GET ['typefilter'] );
	unset ( $typefilter );
}

// release filter for category or manufacturer when nothing is there
if (isset ( $_GET ['filter_id'] ) && $_GET ['filter_id'] <= 0) {
	unset ( $_GET ['filter_id'] );
	unset ( $filter_id );
}

// release alpha filter when nothing is there
if (isset ( $_GET ['alpha_filter_id'] ) && $_GET ['alpha_filter_id'] <= 0) {
	unset ( $_GET ['alpha_filter_id'] );
	unset ( $alpha_filter_id );
}

// hook to notifier so that additional product-type-specific vars can be released too
$zco_notifier->notify ( 'NOTIFY_HEADER_INDEX_MAIN_TEMPLATE_VARS_RELEASE_PRODUCT_TYPE_VARS' );

if ($category_depth == 'nested' || $category_depth == 'products' || zen_check_url_get_terms () || isset ( $_GET ['options_values_id'] )) {
	if (SHOW_PRODUCT_INFO_ALL_PRODUCTS == '1') {
		// set a category filter
		$new_products_category_id = $cPath;
	} else {
		// do not set the category
	}
	
	$sort_list = array(
		'sort_selection'=>array(
			'0a'=>'Popularity ↑',
			'0d'=>'Popularity ↓',
			'1a'=>'Price ↑',
			'1d'=>'Price ↓',
			'2a'=>'Product Name ↑',
			'2d'=>'Product Name ↓',						
		),	
		'sort_data'=>array(	
			'0'=>array( 'field'=>'pd.products_viewed'),
			'1'=>array('field'=>'p.products_price'),
			'2'=>array('field'=>'pd.products_name'),
		),
		'sort_default'=>array('field'=>'pd.products_viewed')	
	);
	
	
	$select_column_list = '';
	$select_column_list .= 'pd.products_name, ';
	$select_column_list .= 'p.products_image, ';
	$select_column_list .= 'pd.products_viewed, ';
	
	// set the product filters according to selected product type
	$typefilter = 'default';
	if (isset ( $_GET ['typefilter'] ))
		$typefilter = $_GET ['typefilter'];
	require (zen_get_index_filters_directory ( $typefilter . '_filter.php' ));
	//分类页
	$tpl_page_body = 'tpl_index_product_list.php';
} else {
	//home page
	$tpl_page_body = 'tpl_index_default.php';
}

$current_categories_description = "";
// categories_description
$sql = "SELECT categories_description
        FROM " . TABLE_CATEGORIES_DESCRIPTION . "
        WHERE categories_id= :categoriesID
        AND language_id = :languagesID";

$sql = $db->bindVars ( $sql, ':categoriesID', $current_category_id, 'integer' );
$sql = $db->bindVars ( $sql, ':languagesID', $_SESSION ['languages_id'], 'integer' );
$categories_description_lookup = $db->Execute ( $sql );
if ($categories_description_lookup->RecordCount () > 0) {
	$current_categories_description = $categories_description_lookup->fields ['categories_description'];
}
require ($template->get_template_dir ( $tpl_page_body, DIR_WS_TEMPLATE, $current_page_base, 'templates' ) . '/' . $tpl_page_body);

// This should be last line of the script:
$zco_notifier->notify ( 'NOTIFY_HEADER_END_INDEX_MAIN_TEMPLATE_VARS' );
?>