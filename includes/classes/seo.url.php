<?php
/*
	+----------------------------------------------------------------------+
	|	Ultimate SEO URLs For Zen Cart, version 2.211                      |
	+----------------------------------------------------------------------+
	|                                                                      |
	|	Derrived from Ultimate SEO URLs v2.1 for osCommerce by Chemo       |
	|                                                                      |
	|	Portions Copyright 2011-2012, Andrew Ballanger                     |
	|                                                                      |
	|	Portions Copyright 2005, Joshua Dechant                            |
	|                                                                      |
	|	Portions Copyright 2005, Bobby Easland                             |
	|                                                                      |
	|	Portions Copyright 2003 The zen-cart developers                    |
	|                                                                      |
	+----------------------------------------------------------------------+
	| This source file is subject to version 2.0 of the GPL license,       |
	| that is bundled with this package in the file LICENSE, and is        |
	| available through the world-wide-web at the following url:           |
	| http://www.zen-cart.com/license/2_0.txt.                             |
	| If you did not receive a copy of the zen-cart license and are unable |
	| to obtain it through the world-wide-web, please send a note to       |
	| license@zen-cart.com so we can mail you a copy immediately.          |
	+----------------------------------------------------------------------+
*/

class SEO_URL {
	public $canonical;

	protected $cache;
	protected $languages_id;
	protected $base_url;
	protected $base_url_ssl;
	protected $reg_anchors;
	protected $cache_query;
	protected $cache_file;
	protected $data;
	protected $need_redirect;
	protected $is_seopage;
	protected $uri;
	protected $real_uri;
	protected $uri_parsed;
	protected $redirect_url;
	protected static $unicodeEnabled;

	private $filter_pcre;
	private $filter_char;

	function __construct($languages_id='') {
		global $session_started;

		if ($languages_id == '') $languages_id = $_SESSION['languages_id'];
		$this->languages_id = (int)$languages_id;

		$this->data = array();
		$this->base_url = HTTP_SERVER;
		$this->base_url_ssl = HTTPS_SERVER;
		$this->cache = array();

		$this->reg_anchors = array(
			'products_id' => '-p-',
			'cPath' => '-c-',
// 			'manufacturers_id' => '-m-',
			'pID' => '-pi-',
			'products_id_review' => '-pr-',
			'products_id_review_info' => '-pri-',
			'id' => '-ezp-',
			'options_values_id'	=>'-opv-'
		);

		if(null === self::$unicodeEnabled) {
			self::$unicodeEnabled = (@preg_match('/\pL/u', 'a')) ? true : false;
		}

		if(defined('SEO_USE_CACHE_GLOBAL') && SEO_USE_CACHE_GLOBAL == 'true'){
			$this->cache_file = 'seo_urls_v2_';
			$this->cache_gc(); // Cleanup Cache

			// Generate enabled caches
			if(SEO_USE_CACHE_PRODUCTS == 'true') $this->generate_products_cache();
			if(SEO_USE_CACHE_CATEGORIES == 'true') $this->generate_categories_cache();
			if(SEO_USE_CACHE_MANUFACTURERS == 'true') $this->generate_manufacturers_cache();
			if(SEO_USE_CACHE_EZ_PAGES == 'true') $this->generate_ezpages_cache();
		}

		$this->check_canonical();

		if(defined('SEO_USE_REDIRECT') && SEO_USE_REDIRECT == 'true') {
			$this->check_redirect();
		}

		$this->filter_pcre = defined('SEO_URLS_FILTER_PCRE') ? $this->expand(SEO_URLS_FILTER_PCRE, true) : 'false';
		$this->filter_char = defined('SEO_URLS_FILTER_CHARS') ? $this->expand(SEO_URLS_FILTER_PCRE) : 'false';
	}

	/**
	 * Generates the link to the requested page suitable for use in an href
	 * paramater.
	 *
	 * @param string $page the name of the page
	 * @param string $parameters any paramaters for the page
	 * @param string $connection 'NONSSL' or 'SSL' the type of connection to use
	 * @param bool $add_session_id true if a session id be added to the url, false otherwise
	 * @param bool $search_engine_safe true if we should use search engine safe urls, false otherwise
	 * @param bool $static true if this is a static page (no paramaters)
	 * @param bool $use_dir_ws_catalog true if we should use the DIR_WS_CATALOG / DIR_WS_HTTPS_CATALOG from the configuration
	 * @return NULL|string|unknown
	 */
	function href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true) {
		// Do not rewrite when disabled
		if(!defined('SEO_ENABLED') || SEO_ENABLED == 'false') {
			return null;
		}

		// Much of the code in Zen Cart creates the dynamic link by itself before
		// passing the code to zen_href_link and then just claims the link is
		// static and passes no params. Much of the code also has the bad habit
		// of claiming a link is "static" when it is not. So we ignore the value
		// of "static" and start by checking if the page starts with index.php?
		if(strstr($page, 'index.php?') !== false) {

			// If we find the main_page parse the URL
			$result = array();
			if(preg_match('/[?&]main_page=([^&]*)/', $page, $result) === 1) {
				$temp = parse_url($page);

				// Adjust the page and parameters to be correct. This mainly
				// fixes the handling of EZ-Pages (but may fix additional pages).
				$page = $result[1];

				$temp['query'] = preg_replace('/main_page=' . $result[1] . '/', '', $temp['query']);
				$parameters = $temp['query'] . ($parameters != '' ? '&' . $parameters : '');
			}
		}

		// Remove the end from the page if it is present
		$pos = strrpos($page, SEO_URL_END);
		if($pos !== false) {
			$page = substr($page, 0, $pos);
		}
		unset($pos);

		// Do not rewrite if page is not in the list of pages to rewrite
		$sefu = explode(',', str_replace(' ', '', SEO_URLS_ONLY_IN));
		if(zen_not_null(SEO_URLS_ONLY_IN) && !in_array($page, $sefu)) {
			return null;
		}

		// don't rewrite the paypal IPN notify url
		if($page == 'ipn_main_handler.php') {
			return null;
		}

		if($connection == 'NONSSL') {
			$link = $this->base_url;
		}
		else if($connection == 'SSL') {
			if(ENABLE_SSL == 'true') {
				$link = $this->base_url_ssl ;
			}
			else {
				$link = $this->base_url;
			}
		}

		if($use_dir_ws_catalog) {
			if($connection == 'SSL' && ENABLE_SSL == 'true') {
				$link .= DIR_WS_HTTPS_CATALOG;
			}
			else {
				$link .= DIR_WS_CATALOG;
			}
		}
		// We start with no separator, so define one.
		$separator = '?';
		if (zen_not_null($parameters)) {
			$link .= $this->parse_parameters($page, $parameters, $separator);
		} else {
			$link .= ($page != FILENAME_DEFAULT ? $page . SEO_URL_END : '');
		}

		$link = $this->add_sid($link, $add_session_id, $connection, $separator);
		
		return htmlspecialchars($link, ENT_QUOTES, CHARSET, false);

		return $link;
	}

	/**
	 * Adds the sid to the end of the URL if needed. If a page cache has been
	 * enabled and no customer is logged in the sid is replaced with '<zinsid>'.
	 *
	 * @param string $link current URL.
	 * @param bool $add_session_id true if a session id be added to the url, false otherwise
	 * @param string $connection 'NONSSL' or 'SSL' the type of connection to use
	 * @param string $separator the separator to use between the link and this paramater (if added)
	 * @return unknown
	 */
	function add_sid($link, $add_session_id, $connection, $separator) {
		global $request_type, $http_domain, $https_domain, $session_started;

		if(($add_session_id == true) && ($session_started) && (SESSION_FORCE_COOKIE_USE == 'False')) {
			if(defined('SID') && zen_not_null(SID)) {
				$_sid = SID;
			}
			else if((($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true')) || (($request_type == 'SSL') && ($connection == 'NONSSL'))) {
				if($http_domain != $https_domain) {
					$_sid = zen_session_name() . '=' . zen_session_id();
				}
			}
		}

		switch(true){
			case (!isset($_SESSION['customer_id']) && defined('ENABLE_PAGE_CACHE') && ENABLE_PAGE_CACHE == 'true' && class_exists('page_cache')):
				$return = $link . $separator . '<zensid>';
				break;
			case (zen_not_null($_sid)):
				$return = $link . $separator . $_sid;
				break;
			default:
				$return = $link;
				break;
		}
		return $return;
	}


	/**
	 * Parses the paramaters for a page to generate a valid url for the page.
	 *
	 * @param string $page the name of the page
	 * @param string $params any paramaters for the page
	 * @param string $separator the separator to use between the link and this paramater (if needed)
	 * @return Ambigous <string, unknown>
	 */
	function parse_parameters($page, $params, &$separator) {
		$p = @explode('&', $params);
		krsort($p);
		$container = array();
		
		$params_valuepair = array();
		foreach ($p as $index=>$valuepair){
			$p2 = @explode('=', $valuepair);
			if (zen_not_null($p2[0]))
				$params_valuepair[$p2[0]] = $p2[1];
		}
		if (isset($params_valuepair['cPath']) && isset($params_valuepair['options_values_id'])){
			$tmp = strrpos($params_valuepair['cPath'], '_');
			if($tmp !== false)
			{
				$params_valuepair['cPath'] = substr($params_valuepair['cPath'], $tmp+1);
			}
			$category = $this->get_category_name($params_valuepair['cPath']);
			if(SEO_URL_CATEGORY_DIR == 'off') {
				$url = $this->make_url($page, $category, 'cPath', $params_valuepair['cPath'], SEO_URL_END, $separator);
				$container['options_values_id'] = $params_valuepair['options_values_id'];
			}
			else {
				$url = $this->make_url($page, $category,  'cPath', $params_valuepair['cPath'], '/', $separator);
				$options_name = get_option_name($params_valuepair['options_values_id'],'/');
				$options_name = preg_replace('/\s/','-',$options_name);
				$options_name = preg_replace('/[^a-zA-Z0-9_\/-]/','',$options_name);				
// 				$options_name = $this->filter($options_name);
				$url = $url.$this->make_url($page, $options_name, 'options_values_id', $params_valuepair['options_values_id'], '/', $separator);	
			}	
			unset($params_valuepair['cPath']);
			unset($params_valuepair['options_values_id']);
		}
		foreach ($params_valuepair as $key=>$value){
			if ($key=='products_id'){
				$value = zen_get_prid($value);
				switch(true) {
					case ($page == FILENAME_PRODUCT_REVIEWS):
						$url = $this->make_url($page, $this->get_product_name($value), 'products_id_review', $value, SEO_URL_END, $separator);
						break;
					case ($page == FILENAME_PRODUCT_REVIEWS_INFO):
						$url = $this->make_url($page, $this->get_product_name($value), 'products_id_review_info', $value, SEO_URL_END, $separator);
						break;
					case ($page == FILENAME_DEFAULT):
						$container[$key] = $value;
						break;
					case ($page == FILENAME_PRODUCT_INFO):
					default:
						$url = $this->make_url($page, $this->get_product_name($value),$key , $value, SEO_URL_END, $separator);
						break;
				} # end switch	
			}elseif ($key=='cPath'){
				switch(true){
					case ($page == FILENAME_DEFAULT):
						// Change $p2[1] to the actual category id
						$tmp = strrpos($value, '_');
						if($tmp !== false)
						{
							$value = substr($value, $tmp+1);
						}
				
						$category = $this->get_category_name($value);
						if(SEO_URL_CATEGORY_DIR == 'off') {
							$url = $this->make_url($page, $category, $key, $value, SEO_URL_END, $separator);
						}
						else {
							$url = $this->make_url($page, $category, $key, $value, '/', $separator);
						}
						unset($category);
						break;
					case ($this->is_product_string($params)):
						if(SEO_URL_CATEGORY_DIR == 'off' && SEO_URL_CPATH == 'auto') {
							$container[$key] = $value;
						}
						break;
					default:
						$container[$key] = $value;
						break;
				} # end switch
			}elseif ($key=='options_values_id'){
				switch(true){
					case ($page == FILENAME_DEFAULT):
						$options_name = get_option_name($value,'/');
						$options_name = preg_replace('/\s/','-',$options_name);
						$options_name = preg_replace('/[^a-zA-Z0-9_\/-]/','',$options_name);
// 						$options_name = $this->filter($options_name);
						$url = $this->make_url($page, $options_name, $key, $value, '/', $separator);
						break;
					default:
						$container[$key] = $value;
						break;
				}
			}/*elseif ($key=='manufacturers_id'){
				switch(true){
					case ($page == FILENAME_DEFAULT && !$this->is_cPath_string($params) && !$this->is_product_string($params)):
						$url = $this->make_url($page, $this->get_manufacturer_name($value), $key, $value, SEO_URL_END, $separator);
						break;
					case ($page == FILENAME_PRODUCT_INFO):
						break;
					default:
						$container[$key] = $value;
						break;
				} # end switch
			}*/elseif ($key=='pID'){
				switch(true){
					case ($page == FILENAME_POPUP_IMAGE):
						$url = $this->make_url($page, $this->get_product_name($value), $key, $value, SEO_URL_END, $separator);
						break;
					default:
						$container[$key] = $value;
						break;
				} # end switch	
			}elseif ($key=='id'){// EZ-Pages
				switch(true){
					case ($page == FILENAME_EZPAGES):
						$url = $this->make_url($page, $this->get_ezpages_name($value), $key, $value, SEO_URL_END, $separator);
						break;
					default:
						$container[$key] = $value;
						break;
				} # end switch
			}else{
				$container[$key] = $value;
			}
		}
		
		$url = isset($url) ? $url : $page . SEO_URL_END;
		if(sizeof($container) > 0) {
			if($imploded_params = $this->implode_assoc($container)) {
				$url .= $separator . zen_output_string($imploded_params);
				$separator = '&';
			}
		}

		return $url;
	}
	
	/**
	 * Generates the url for the given page and paramaters.
	 *
	 * @param string $page the page for the link
	 * @param string $link the name to use for the url
	 * @param string $anchor_type the last paramater parsed type (products_id, cPath, etc.)
	 * @param string $id the last paramater parsed id (or cPath)
	 * @param string $extension Default =
	 * @param string $separator NOTE: passed by reference
	 * @return string the final generated url
	 */
	function make_url($page, $link, $anchor_type, $id, $extension = SEO_URL_END, &$separator){
		// In the future there may be additional methods here in the switch
		switch (SEO_REWRITE_TYPE){
			case 'rewrite':
				return $link . $this->reg_anchors[$anchor_type] . $id . $extension;
				break;
			default:
				break;
		}
	}

	/**
	 * Function to get the product name. Use evaluated cache, per page cache,
	 * or database query in that order of precedent.
	 *
	 * @param integer $pID
	 * @return string product name
	 */
	function get_product_name($pID) {
		global $db;

		switch(true){
			case (SEO_USE_CACHE_GLOBAL == 'true' && defined('PRODUCT_NAME_' . $pID)):
				$return = constant('PRODUCT_NAME_' . $pID);
				$this->cache['PRODUCTS'][$pID] = $return;
				break;

			case (SEO_USE_CACHE_GLOBAL == 'true' && isset($this->cache['PRODUCTS'][$pID])):
				$return = $this->cache['PRODUCTS'][$pID];
				break;

			default:
				if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR != 'off') {
					$sql = 'SELECT pd.products_name AS pName, ptc.categories_id AS c_id, p.master_categories_id AS master_id ' .
						'FROM `' . TABLE_PRODUCTS_DESCRIPTION . '` AS pd ' .
						'LEFT JOIN `' . TABLE_PRODUCTS . '` AS p ' .
						'ON pd.products_id=p.products_id ' .
						'LEFT JOIN `' . TABLE_PRODUCTS_TO_CATEGORIES . '` AS ptc ' .
						'ON pd.products_id=ptc.products_id ' .
						'WHERE pd.products_id=\'' . (int)$pID . '\' ' .
						'AND language_id=\'' . (int)$this->languages_id . '\' LIMIT 1';
				}
				else {
					$sql = 'SELECT pd.products_name as pName ' .
						'FROM ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ' .
						'WHERE products_id=\'' . (int)$pID . '\' ' .
						'AND language_id=\'' . (int)$this->languages_id . '\' LIMIT 1';
				}
				$result = $db->Execute($sql, false, true, 43200);
				$pName = $this->filter($result->fields['pName']);

				$category = '';
				$canonical = null;
				if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR != 'off') {
					$cID = (int)$result->fields['c_id'];
					$masterID = (int)$result->fields['master_id'];
					$category = (SEO_URL_CATEGORY_DIR == 'off' ? $this->get_category_name($cID, 'original') : $this->get_category_name($cID));

					if(SEO_URL_CATEGORY_DIR != 'off') {
						$category .= $this->reg_anchors['cPath'] . $cID . '/';

						if($cID != $masterID) {
							$canonical = $this->get_category_name($masterID) .
								$this->reg_anchors['cPath'] . $masterID . '/';
						}
					}
					else {
						$category .= '-';
					}
				}

				if($canonical !== null) $this->cache['PRODUCTS_CANONICAL'][$pID] = $canonical . $pName;
				$this->cache['PRODUCTS'][$pID] = $category . $pName;

				$return = $this->cache['PRODUCTS'][$pID];
				break;
		}
		return $return;
	}

	/**
	 * Function to get the product canonical. Use evaluated cache, per page cache,
	 * or database query in that order of precedent.
	 *
	 * @param integer $pID
	 * @return string product canonical
	 */
	function get_product_canonical($pID) {
		global $db;

		switch(true){
			case (SEO_USE_CACHE_GLOBAL == 'true' && defined('PRODUCT_CANONICAL_' . $pID)):
				$return = constant('PRODUCT_CANONICAL_' . $pID);
				$this->cache['PRODUCTS_CANONICAL'][$pID] = $return;
				break;

			case (SEO_USE_CACHE_GLOBAL == 'true' && isset($this->cache['PRODUCTS_CANONICAL'][$pID])):
				$return = $this->cache['PRODUCTS_CANONICAL'][$pID];
				break;

			default:
				if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR != 'off') {
					$sql = 'SELECT pd.products_name AS pName, ptc.categories_id AS c_id, p.master_categories_id AS master_id ' .
						'FROM `' . TABLE_PRODUCTS_DESCRIPTION . '` AS pd ' .
						'LEFT JOIN `' . TABLE_PRODUCTS . '` AS p ' .
						'ON pd.products_id=p.products_id ' .
						'LEFT JOIN `' . TABLE_PRODUCTS_TO_CATEGORIES . '` AS ptc ' .
						'ON pd.products_id=ptc.products_id ' .
						'WHERE pd.products_id=\'' . (int)$pID . '\' ' .
						'AND language_id=\'' . (int)$this->languages_id . '\' LIMIT 1';
				}
				else {
					$sql = 'SELECT pd.products_name as pName ' .
						'FROM ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ' .
						'WHERE products_id=\'' . (int)$pID . '\' ' .
						'AND language_id=\'' . (int)$this->languages_id . '\' LIMIT 1';
				}
				$result = $db->Execute($sql, false, true, 43200);
				$pName = $this->filter($result->fields['pName']);

				$category = '';
				$canonical = null;
				if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR != 'off') {
					$cID = (int)$result->fields['c_id'];
					$masterID = (int)$result->fields['master_id'];
					$category = (SEO_URL_CATEGORY_DIR == 'off' ? $this->get_category_name($cID, 'original') : $this->get_category_name($cID));

					if(SEO_URL_CATEGORY_DIR != 'off') {
						$category .= $this->reg_anchors['cPath'] . $cID . '/';

						if($cID != $masterID) {
							$canonical = $this->get_category_name($masterID) .
								$this->reg_anchors['cPath'] . $masterID . '/';
						}
					}
					else {
						$category .= '-';
					}
				}

				if($canonical !== null) $this->cache['PRODUCTS_CANONICAL'][$pID] = $canonical . $pName;
				$this->cache['PRODUCTS'][$pID] = $category . $pName;

				$return = ($canonical !== null ? $this->cache['PRODUCTS_CANONICAL'][$pID] : null);
				break;
		}

		return $return;
	}

	/**
	 * Function to get the category name. Use evaluated cache, per page cache,
	 * or database query in that order of precedent
	 * @param integer $cID NOTE: passed by reference
	 * @return string category name
	 */
	function get_category_name(&$cID, $format = SEO_URL_FORMAT){
		global $db;

		$full_cPath = $this->get_full_cPath($cID, $single_cID); // full cPath needed for uniformity
		switch(true){
			case (SEO_USE_CACHE_GLOBAL == 'true' && defined('CATEGORY_NAME_' . $full_cPath)):
				$return = constant('CATEGORY_NAME_' . $full_cPath);
				$this->cache['CATEGORIES'][$full_cPath] = $return;
				break;
			case (SEO_USE_CACHE_GLOBAL == 'true' && isset($this->cache['CATEGORIES'][$full_cPath])):
				$return = $this->cache['CATEGORIES'][$full_cPath];
				break;
			default:
				$cName = '';
				if(SEO_URL_CATEGORY_DIR == 'full') {
					$path = array();
					$this->get_parent_categories_path($path, $single_cID);
					if(sizeof($path) > 0) {
						$cName = implode('/', $path);
						$cut = strrpos($cName, $this->reg_anchors['cPath']);
						if($cut !== false) $cName = substr($cName, 0, $cut);
						unset($cut);
					}
					unset($path);
				}
				else if($format == 'parent') {
					$sql = 'SELECT `c`.`categories_id`, `c`.`parent_id`, `cd`.`categories_name` AS `cName`, `cd2`.`categories_name` AS `pName` ' .
						'FROM `' . TABLE_CATEGORIES_DESCRIPTION . '` AS `cd`, `' . TABLE_CATEGORIES . '` AS `c` ' .
						'LEFT JOIN `' . TABLE_CATEGORIES_DESCRIPTION . '` AS `cd2` ' .
						'ON `c`.`parent_id`=`cd2`.`categories_id` AND `cd2`.`language_id`=\'' . (int)$this->languages_id . '\' ' .
						'WHERE `c`.`categories_id`=\'' . (int)$single_cID . '\' ' .
						'AND `cd`.`categories_id`=\'' . (int)$single_cID . '\' ' .
						'AND `cd`.`language_id`=\'' . (int)$this->languages_id . '\' ' .
						'LIMIT 1';
					$result = $db->Execute($sql, false, true, 43200);
					if(!$result->EOF) {
						$cName = zen_not_null($result->fields['pName']) ? $this->filter($result->fields['pName'] . ' ' . $result->fields['cName']) : $this->filter($result->fields['cName']);
					}
				}
				else {
					$sql = 'SELECT `categories_name` AS `cName` ' .
						'FROM `' . TABLE_CATEGORIES_DESCRIPTION . '` ' .
						'WHERE `categories_id`=\'' . (int)$single_cID . '\' ' .
						'AND `language_id`=\'' . (int)$this->languages_id . '\' ' .
						'LIMIT 1';
					$result = $db->Execute($sql, false, true, 43200);
					if(!$result->EOF) $cName = $this->filter($result->fields['cName']);
				}

				$this->cache['CATEGORIES'][$full_cPath] = $cName;
				$return = $cName;
				break;
		}
		$cID = $full_cPath;
		return $return;
	}

/**
 * Function to get the manufacturer name. Use evaluated cache, per page cache, or database query in that order of precedent.
 * @author Bobby Easland
 * @version 1.1
 * @param integer $mID
 * @return string
 */
	function get_manufacturer_name($mID) {
		global $db;

		switch(true){
			case (SEO_USE_CACHE_GLOBAL == 'true' && defined('MANUFACTURER_NAME_' . $mID)):
				$return = constant('MANUFACTURER_NAME_' . $mID);
				$this->cache['MANUFACTURERS'][$mID] = $return;
				break;
			case (SEO_USE_CACHE_GLOBAL == 'true' && isset($this->cache['MANUFACTURERS'][$mID])):
				$return = $this->cache['MANUFACTURERS'][$mID];
				break;
			default:
				$sql = "SELECT manufacturers_name as mName
						FROM ".TABLE_MANUFACTURERS."
						WHERE manufacturers_id='".(int)$mID."'
						LIMIT 1";
				$result = $db->Execute($sql, false, true, 43200);
				$mName = $this->filter($result->fields['mName']);
				$this->cache['MANUFACTURERS'][$mID] = $mName;
				$return = $mName;
				break;
		} # end switch
		return $return;
	} # end function

/**
 * Function to get the EZ-Pages name. Use evaluated cache, per page cache, or database query in that order of precedent.
 * @author Bobby Easland, Ronald Crawford
 * @version 1.0
 * @param integer $mID
 * @return string
 */
	function get_ezpages_name($ezpID) {
		global $db;

		switch(true){
			case (SEO_USE_CACHE_GLOBAL == 'true' && defined('EZPAGES_NAME_' . $ezpID)):
				$return = constant('EZPAGES_NAME_' . $ezpID);
				$this->cache['EZPAGES'][$ezpID] = $return;
				break;
			case (SEO_USE_CACHE_GLOBAL == 'true' && isset($this->cache['EZPAGES'][$ezpID])):
				$return = $this->cache['EZPAGES'][$ezpID];
				break;
			default:
				if(defined('TABLE_EZPAGES_TEXT')) {
					$sql = 'SELECT et.pages_title AS ezpName ' .
						'FROM `' . TABLE_EZPAGES . '` AS e, `' . TABLE_EZPAGES_TEXT . '` AS et ' .
						'WHERE e.pages_id=\''.(int)$ezpID.'\' ' .
						'AND e.pages_id = et.pages_id ' .
						'AND et.languages_id = \'' . (int)$_SESSION['languages_id'] . '\' ' .
						'LIMIT 1';
				}
				else {
					$sql = 'SELECT pages_title AS ezpName ' .
						'FROM `' . TABLE_EZPAGES . '` ' .
						'WHERE pages_id=\''.(int)$ezpID.'\' ' .
						'LIMIT 1';
				}
				$result = $db->Execute($sql, false, true, 43200);
				$ezpName = $this->filter($result->fields['ezpName']);
				$this->cache['EZPAGES'][$ezpID] = $ezpName;
				$return = $ezpName;
				break;
		} # end switch
		return $return;
	} # end function

/**
 * Function to retrieve full cPath from category ID
 * @author Bobby Easland
 * @version 1.1
 * @param mixed $cID Could contain cPath or single category_id
 * @param integer $original Single category_id passed back by reference
 * @return string Full cPath string
 */
	function get_full_cPath($cID, &$original){
		if ( is_numeric(strpos($cID, '_')) ){
			$temp = @explode('_', $cID);
			$original = $temp[sizeof($temp)-1];
			return $cID;
		} else {
			$c = array();
			$this->get_parent_categories_id($c, $cID);
			$c = array_reverse($c);
			$c[] = $cID;
			$original = $cID;
			$cID = sizeof($c) > 1 ? implode('_', $c) : $cID;
			return $cID;
		}
	} # end function

/**
 * Recursion function to retrieve parent categories from category ID
 * @author Bobby Easland
 * @version 1.0
 * @param mixed $categories Passed by reference
 * @param integer $categories_id
 */
	function get_parent_categories_id(&$categories, $categories_id) {
		global $db;

		$sql = "SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE categories_id = " . (int)$categories_id;

		$parent_categories = $db->Execute($sql);

		while (!$parent_categories->EOF) {
			if ($parent_categories->fields['parent_id'] == 0) return true;

			$categories[sizeof($categories)] = $parent_categories->fields['parent_id'];

			if ($parent_categories->fields['parent_id'] != $categories_id) {
				$this->get_parent_categories_id($categories, $parent_categories->fields['parent_id']);
			}

			$parent_categories->MoveNext();
		}
	}

	/**
	 * Recursion function to retrieve parent categories from category ID.
	 *
	 * @author Andrew Ballanger
	 * @version 1.0
	 * @param mixed $path Passed by reference
	 * @param integer $categories_id
	 */
	function get_parent_categories_path(&$path, $categories_id, &$cPath = array()) {
		global $db;

		$sql = 'SELECT c.parent_id AS p_id, cd.categories_name AS name ' .
			'FROM `' . TABLE_CATEGORIES . '` AS c ' .
			'LEFT JOIN `' . TABLE_CATEGORIES_DESCRIPTION . '` AS cd ' .
			'ON c.categories_id=cd.categories_id ' .
			'AND cd.language_id=\'' . (int)$this->languages_id . '\'' .
			'WHERE c.categories_id=\'' . (int)$categories_id . '\'';

		$parent = $db->Execute($sql, false, true, 43200);

		if(!$parent->EOF) {

			// Recurse if the parent id is not empty or equal the passed categories id
			if ($parent->fields['p_id'] != 0 && $parent->fields['p_id'] != $categories_id) {
				$this->get_parent_categories_path($path, $parent->fields['p_id'], $cPath);
			}

			// Add category id to cPath and name to path
			$cPath[sizeof($cPath)] = $categories_id;
			$path[sizeof($path)] = $this->filter($parent->fields['name']) . '-c-' .
			(sizeof($cPath) > 1 ? implode('_', $cPath) : $categories_id);
		}
	}

	function is_attribute_string($params){
		if (preg_match('/products_id=([0-9]+):([a-zA-z0-9]{32})/', $params)) {
			return true;
		}

		return false;
	}

	function is_product_string($params) {
		if (preg_match('/products_id=/i', $params)) {
			return true;
		}

		return false;
	}

	function is_cPath_string($params) {
		if (preg_match('/cPath=/i', $params)) {
			return true;
		}

		return false;
	}

/**
 * Function to filter a string and remove punctuation and white space.
 *
 * @param string $string input text
 * @return string filtered text
 */
	function filter($string){
		$retval = $string;

		// First filter using PCRE Rules
		if(is_array($this->filter_pcre))
		{
			$retval = preg_replace(
				array_keys($this->filter_pcre),
				array_values($this->filter_pcre),
				$retval
			);
		}

		// Next run Character Conversion Sets over the string
		if(is_array($this->filter_char)) $retval = strtr($retval, $this->filter_char);

		// Next run character filters over the string
		$pattern = '';
		// Remove Special Characters from the strings
		switch(SEO_URLS_REMOVE_CHARS) {
			case 'alphanumerical':
				// Remove all non alphanumeric characters
				if(!self::$unicodeEnabled) {
					// POSIX named classes are not supported by preg_replace
					$pattern = '/[^a-zA-Z0-9\s]/';
				} else {
					// Each language's alphabet.
					$pattern = '/[^\p{L}\p{N}\s]/u';
				}
				break;
			case 'special':
				// Remove all punctuation
				if(!self::$unicodeEnabled) {
					// POSIX named classes are not supported by preg_replace
					$pattern = '/[!"#$%&\'()*+,.\/:;<=>?@[\\\]^_`{|}~]/';
				} else {
					// Each language's punctuation.
					$pattern = '/[\p{P}\p{S}]/u';
				}

				break;
			default:
		}
		$retval = preg_replace($pattern, '', strtolower($retval));

		// Replace any remaining whitespace with a -
		$retval = preg_replace('/\s/', '-', $retval);

		return $this->short_name($retval); // return the short filtered name
	} # end function

/**
 * Function to expand the SEO_CONVERT_SET group
 * @author Bobby Easland
 * @version 1.0
 * @param string $set
 * @return mixed
 */
	// START SEO_URLS_FILTER_PCRE PATCH
	function expand($set, $pcre = false){
	// END SEO_URLS_FILTER_PCRE PATCH
		if ( zen_not_null($set) ){
			if ( $data = @explode(',', $set) ){
				foreach ( $data as $index => $valuepair){
					$p = @explode('=>', $valuepair);
					// START SEO_URLS_FILTER_PCRE PATCH
					if($pcre) $p[0] = '/' . $p[0] . '/';
					// END SEO_URLS_FILTER_PCRE PATCH
					$container[trim($p[0])] = trim($p[1]);
				}
				return $container;
			} else {
				return 'false';
			}
		} else {
			return 'false';
		}
	} # end function
/**
 * Function to return the short word filtered string
 * @author Bobby Easland
 * @version 1.0
 * @param string $str
 * @param integer $limit
 * @return string Short word filtered
 */
	function short_name($str, $limit=3){
		if(defined('SEO_URLS_FILTER_SHORT_WORDS')) $limit = (int)SEO_URLS_FILTER_SHORT_WORDS;
		$foo = @explode('-', $str);
		foreach($foo as $index => $value){
			switch (true){
				case ( strlen($value) <= $limit ):
					continue;
				default:
					$container[] = $value;
					break;
			}
		} # end foreach
		$container = ( sizeof($container) > 1 ? implode('-', $container) : $str );
		return $container;
	}

/**
 * Function to implode an associative array
 * @author Bobby Easland
 * @version 1.0
 * @param array $array Associative data array
 * @param string $inner_glue
 * @param string $outer_glue
 * @return string
 */
	function implode_assoc($array, $inner_glue='=', $outer_glue='&') {
		$output = array();
		foreach( $array as $key => $item ){
			if ( zen_not_null($key) && zen_not_null($item) ){
				$output[] = $key . $inner_glue . $item;
			}
		} # end foreach
		return @implode($outer_glue, $output);
	}

/**
 * Function to translate a string
 * @author Bobby Easland
 * @version 1.0
 * @param string $data String to be translated
 * @param array $parse Array of tarnslation variables
 * @return string
 */
	function parse_input_field_data($data, $parse) {
		return strtr(trim($data), $parse);
	}

/**
 * Function to generate EZ-Pages cache entries
 */
	function generate_ezpages_cache() {
		global $db;

		$this->is_cached($this->cache_file . 'ezpages', $is_cached, $is_expired);
		if (!$is_cached || $is_expired) {
			if(defined('TABLE_EZPAGES_TEXT')) {
				$sql = 'SELECT e.pages_id AS id, et.pages_title AS name ' .
					'FROM `' . TABLE_EZPAGES . '` AS e, `' . TABLE_EZPAGES_TEXT . '` AS et ' .
					'WHERE e.pages_id = et.pages_id ' .
					'AND et.languages_id = \'' . (int)$_SESSION['languages_id'] . '\'';
			}
			else {
				$sql = 'SELECT pages_id AS id, pages_title AS name ' .
					'FROM `' . TABLE_EZPAGES . '` ';
			}
			$ezpages = $db->Execute($sql, false, true, 43200);
			$ezpages_cache = '';
			while (!$ezpages->EOF) {
				$define = 'define(\'EZPAGES_NAME_' . $ezpages->fields['id'] . '\', \'' . $this->filter($ezpages->fields['name']) . '\');';
				$ezpages_cache .= $define . "\n";
				eval("$define");
				$ezpages->MoveNext();
			}
			$this->save_cache($this->cache_file . 'ezpages', $ezpages_cache, 'EVAL', 1 , 1);
			unset($ezpages_cache);
		} else {
			$this->get_cache($this->cache_file . 'ezpages');
		}
	} # end function

/**
 * Function to generate products cache entries
 */
	function generate_products_cache() {
		global $db;

		$this->is_cached($this->cache_file . 'products', $is_cached, $is_expired);
		$generate = (!$is_cached || $is_expired);
		$this->is_cached($this->cache_file . 'products_canonical', $is_cached, $is_expired);
		if($generate || !$is_cached || $is_expired) {
			if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR != 'off') {
				$sql = 'SELECT p.products_id as id, ptc.categories_id as c_id, p.master_categories_id AS master_id, pd.products_name as name ' .
					'FROM ' . TABLE_PRODUCTS  . ' AS p ' .
					'LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' AS pd ' .
					'ON p.products_id=pd.products_id ' .
					'LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' AS ptc ' .
					'ON p.products_id=ptc.products_id ' .
					'WHERE p.products_status=\'1\' ' .
					'AND pd.language_id=\'' . (int)$this->languages_id . '\'';
			}
			else {
				$sql = 'SELECT p.products_id as id, pd.products_name as name ' .
					'FROM ' . TABLE_PRODUCTS  . ' AS p ' .
					'LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' AS pd ' .
					'ON p.products_id=pd.products_id ' .
					'WHERE p.products_status=\'1\' ' .
					'AND pd.language_id=\'' . (int)$this->languages_id . '\'';
			}

			$product = $db->Execute($sql, false, true, 43200);
			$prod_cache = '';
			$prod_canonical = '';
			while (!$product->EOF) {
				$pName = $this->filter($product->fields['name']);
				$category = '';
				$canonical = null;
				if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR != 'off') {
					$cID = (int) $product->fields['c_id'];
					$masterID = (int) $product->fields['master_id'];
					$category = (SEO_URL_CATEGORY_DIR == 'off' ? $this->get_category_name($cID, 'original') : $this->get_category_name($cID));

					if(SEO_URL_CATEGORY_DIR != 'off') {
						$category .= $this->reg_anchors['cPath'] . $cID . '/';

						if($cID != $masterID) {
							$canonical = $this->get_category_name($masterID) .
								$this->reg_anchors['cPath'] . $masterID . '/';
						}
					}
					else {
						$category .= '-';
					}
				}

				if($canonical !== null) {
					$define_canonical = 'define(\'PRODUCT_CANONICAL_' . $product->fields['id'] . '\', \'' . $canonical . $pName . '\');';
					$prod_canonical .= $define_canonical . "\n";
					eval("$define_canonical");
				}

				$define = 'define(\'PRODUCT_NAME_' . $product->fields['id'] . '\', \'' . $category . $pName . '\');';
				$prod_cache .= $define . "\n";
				eval("$define");
				$product->MoveNext();
			}
			unset($cID, $masterID, $pName, $category, $canonical, $define, $define_canonical);

			$this->save_cache($this->cache_file . 'products', $prod_cache, 'EVAL', 1 , 1);
			$this->save_cache($this->cache_file . 'products_canonical', $prod_canonical, 'EVAL', 1 , 1);
			unset($prod_cache, $prod_canonical);
		}
		else
		{
			$this->get_cache($this->cache_file . 'products');
			$this->get_cache($this->cache_file . 'products_canonical');
		}
	} # end function

/**
 * Function to generate manufacturers cache entries
 * @author Bobby Easland
 * @version 1.0
 */
	function generate_manufacturers_cache() {
		global $db;

		$this->is_cached($this->cache_file . 'manufacturers', $is_cached, $is_expired);
		if ( !$is_cached || $is_expired ) { // it's not cached so create it
		$sql = "SELECT m.manufacturers_id as id, m.manufacturers_name as name
		        FROM ".TABLE_MANUFACTURERS." m
				LEFT JOIN ".TABLE_MANUFACTURERS_INFO." md
				ON m.manufacturers_id=md.manufacturers_id
				AND md.languages_id='".(int)$this->languages_id."'";
		$manufacturers = $db->Execute($sql, false, true, 43200);
		$man_cache = '';
		while (!$manufacturers->EOF) {
			$define = 'define(\'MANUFACTURER_NAME_' . $manufacturer->fields['id'] . '\', \'' . $this->filter($manufacturer->fields['name']) . '\');';
			$man_cache .= $define . "\n";
			eval("$define");
			$manufacturers->MoveNext();
		}
		$this->save_cache($this->cache_file . 'manufacturers', $man_cache, 'EVAL', 1 , 1);
		unset($man_cache);
		} else {
			$this->get_cache($this->cache_file . 'manufacturers');
		}
	} # end function

/**
 * Function to generate categories cache entries
 */
	function generate_categories_cache() {
		global $db;

		$this->is_cached($this->cache_file . 'categories', $is_cached, $is_expired);
		if(!$is_cached || $is_expired) { // it's not cached so create it
			if(SEO_URL_FORMAT == 'parent' || SEO_URL_CATEGORY_DIR == 'short') {
				$sql = 'SELECT c.categories_id as id, c.parent_id, cd.categories_name as cName, cd2.categories_name as pName ' .
					'FROM `' . TABLE_CATEGORIES . '` AS c ' .
					'LEFT JOIN `' . TABLE_CATEGORIES_DESCRIPTION . '` AS cd2 ' .
					'ON c.parent_id=cd2.categories_id AND cd2.language_id=\'' . (int)$this->languages_id . '\'' .
					', `' . TABLE_CATEGORIES_DESCRIPTION . '` AS cd ' .
					'WHERE c.categories_id=cd.categories_id ' .
					'AND cd.language_id=\'' . (int)$this->languages_id . '\'';
			}
			else {
				$sql = 'SELECT categories_id as id, categories_name as cName ' .
					'FROM `' . TABLE_CATEGORIES_DESCRIPTION . '` ' .
					'WHERE language_id=\'' . (int)$this->languages_id . '\'';
			}
			$category = $db->Execute($sql, false, true, 43200);
			$cat_cache = '';
			while (!$category->EOF) {
				$cName = '';
				$cPath = $this->get_full_cPath($category->fields['categories_id'], $single_cID);
				if(SEO_URL_CATEGORY_DIR == 'full') {
					$path = array();
					$this->get_parent_categories_path($path, $single_cID);
					if(sizeof($path) > 0) {
						$cName = implode('/', $path);
						$cut = strrpos($cName, $this->reg_anchors['cPath']);
						if($cut !== false) $cName = substr($cName, 0, $cut);
						unset($cut);
					}
					unset($path);
				}
				else if (SEO_URL_FORMAT == 'parent') {
					$cName = zen_not_null($category->fields['pName']) ? $this->filter($category->fields['pName'] . ' ' . $category->fields['cName']) : $this->filter($category->fields['cName']);
				}
				else {
					$cName = $this->filter($category->fields['cName']);
				}

				$define = 'define(\'CATEGORY_NAME_' . $cPath . '\', \'' . $cName . '\');';
				$cat_cache .= $define . "\n";
				eval("$define");
				$category->MoveNext();
			}
			$this->save_cache($this->cache_file . 'categories', $cat_cache, 'EVAL', 1 , 1);
			unset($cat_cache);
		} else {
			$this->get_cache($this->cache_file . 'categories');
		}
	} # end function

/**
 * Function to save the cache to database
 * @author Bobby Easland
 * @version 1.0
 * @param string $name Cache name
 * @param mixed $value Can be array, string, PHP code, or just about anything
 * @param string $method RETURN, ARRAY, EVAL
 * @param integer $gzip Enables compression
 * @param integer $global Sets whether cache record is global is scope
 * @param string $expires Sets the expiration
 */
	function save_cache($name, $value, $method='RETURN', $gzip=1, $global=0, $expires = '30 days'){
		global $queryCache;

		$expires = date('Y-m-d H:i:s', strtotime('+' . $expires));
		if ($method == 'ARRAY') $value = serialize($value);
		$value = ( $gzip === 1 ? base64_encode(gzdeflate($value, 1)) : addslashes($value) );
		$sql_data_array = array(
			'cache_id' => md5($name),
			'cache_language_id' => (int)$this->languages_id,
			'cache_name' => $name,
			'cache_data' => $value,
			'cache_global' => (int)$global,
			'cache_gzip' => (int)$gzip,
			'cache_method' => $method,
			'cache_date' => date("Y-m-d H:i:s"),
			'cache_expires' => $expires
		);
		$this->is_cached($name, $is_cached, $is_expired);
		$cache_check = ( $is_cached ? 'true' : 'false' );
		switch ( $cache_check ) {
			case 'true':
				zen_db_perform(TABLE_SEO_CACHE, $sql_data_array, 'update', "cache_id='".md5($name)."'");
				break;
			case 'false':
				zen_db_perform(TABLE_SEO_CACHE, $sql_data_array, 'insert');
				break;
			default:
				break;
		} # end switch ($cache check)

		// Fix for query_cache
		$query = "SELECT cache_expires FROM " . TABLE_SEO_CACHE . " WHERE cache_id='".md5($name)."' AND cache_language_id='".(int)$this->languages_id."' LIMIT 1";
		if(isset($queryCache) && $queryCache->inCache($query))
			$queryCache->removeFromCache($query);

		# unset the variables...clean as we go
		unset($value, $expires, $sql_data_array, $query);
	}# end function save_cache()

/**
 * Function to get cache entry
 * @author Bobby Easland
 * @version 1.0
 * @param string $name
 * @param boolean $local_memory
 * @return mixed
 */
	function get_cache($name = 'GLOBAL', $local_memory = false){
		global $db;

		$select_list = 'cache_id, cache_language_id, cache_name, cache_data, cache_global, cache_gzip, cache_method, cache_date, cache_expires';
		$global = ( $name == 'GLOBAL' ? true : false ); // was GLOBAL passed or is using the default?
		switch($name){
			case 'GLOBAL':
				$cache = $db->Execute("SELECT ".$select_list." FROM " . TABLE_SEO_CACHE . " WHERE cache_language_id='".(int)$this->languages_id."' AND cache_global='1'");
				break;
			default:
				$cache = $db->Execute("SELECT ".$select_list." FROM " . TABLE_SEO_CACHE . " WHERE cache_id='".md5($name)."' AND cache_language_id='".(int)$this->languages_id."'");
				break;
		}
		$num_rows = $cache->RecordCount();
		if ($num_rows){
			$container = array();
			while(!$cache->EOF){
				$cache_name = $cache->fields['cache_name'];
				if ( $cache->fields['cache_expires'] > date("Y-m-d H:i:s") ) {
					$cache_data = ( $cache->fields['cache_gzip'] == 1 ? gzinflate(base64_decode($cache->fields['cache_data'])) : stripslashes($cache->fields['cache_data']) );
					switch($cache->fields['cache_method']){
						case 'EVAL': // must be PHP code
							eval("$cache_data");
							break;
						case 'ARRAY':
							$cache_data = unserialize($cache_data);
						case 'RETURN':
						default:
							break;
					} # end switch ($cache['cache_method'])
					if ($global) $container['GLOBAL'][$cache_name] = $cache_data;
					else $container[$cache_name] = $cache_data; // not global
				} else { // cache is expired
					if ($global) $container['GLOBAL'][$cache_name] = false;
					else $container[$cache_name] = false;
				}# end if ( $cache['cache_expires'] > date("Y-m-d H:i:s") )
				if ( $this->keep_in_memory || $local_memory ) {
					if ($global) $this->data['GLOBAL'][$cache_name] = $container['GLOBAL'][$cache_name];
					else $this->data[$cache_name] = $container[$cache_name];
				}
				$cache->MoveNext();
			} # end while ($cache = $this->DB->FetchArray($this->cache_query))
			unset($cache_data);
			switch (true) {
				case ($num_rows == 1):
					if ($global){
						if ($container['GLOBAL'][$cache_name] == false || !isset($container['GLOBAL'][$cache_name])) return false;
						else return $container['GLOBAL'][$cache_name];
					} else { // not global
						if ($container[$cache_name] == false || !isset($container[$cache_name])) return false;
						else return $container[$cache_name];
					} # end if ($global)
				case ($num_rows > 1):
				default:
					return $container;
					break;
			}# end switch (true)
		} else {
			return false;
		}# end if ( $num_rows )
	} # end function get_cache()

/**
 * Function to get cache from memory
 * @author Bobby Easland
 * @version 1.0
 * @param string $name
 * @param string $method
 * @return mixed
 */
	function get_cache_memory($name, $method = 'RETURN'){
		$data = ( isset($this->data['GLOBAL'][$name]) ? $this->data['GLOBAL'][$name] : $this->data[$name] );
		if ( isset($data) && !empty($data) && $data != false ){
			switch($method){
				case 'EVAL': // data must be PHP
					eval("$data");
					return true;
					break;
				case 'ARRAY':
				case 'RETURN':
				default:
					return $data;
					break;
			} # end switch ($method)
		} else {
			return false;
		} # end if (isset($data) && !empty($data) && $data != false)
	} # end function get_cache_memory()

/**
 * Function to perform basic garbage collection for database cache system
 * @author Bobby Easland
 * @version 1.0
 */
	function cache_gc() {
		global $db;

		$db->Execute("DELETE FROM " . TABLE_SEO_CACHE . " WHERE cache_expires <= '" . date("Y-m-d H:i:s") . "'");
	}

/**
 * Function to check if the cache is in the database and expired
 * @author Bobby Easland
 * @version 1.0
 * @param string $name
 * @param boolean $is_cached NOTE: passed by reference
 * @param boolean $is_expired NOTE: passed by reference
 */
	function is_cached($name, &$is_cached, &$is_expired){ // NOTE: $is_cached and $is_expired is passed by reference !!
		global $db;

		$this->cache_query = $db->Execute("SELECT cache_expires FROM " . TABLE_SEO_CACHE . " WHERE cache_id='".md5($name)."' AND cache_language_id='".(int)$this->languages_id."' LIMIT 1");
		$is_cached = ( $this->cache_query->RecordCount() > 0 ? true : false );

		if ($is_cached){
			$is_expired = ( $this->cache_query->fields['cache_expires'] <= date("Y-m-d H:i:s") ? true : false );
			unset($check);
		}
	}# end function is_cached()

	function check_canonical() {
		global $db, $request_type;

		$this->uri = ltrim($_SERVER['REQUEST_URI']);
		$this->real_uri = ltrim( basename($_SERVER['SCRIPT_NAME']) . '?' . $_SERVER['QUERY_STRING'], '/' );
		$this->uri_parsed = parse_url($this->uri);

		$this->check_seo_page();
		if($this->is_seopage && array_key_exists('products_id', $_GET)) {
			// Retrieve the product type handler from the database
			$type = $db->Execute(
				'SELECT `pt`.`type_handler` ' .
				'FROM `'. TABLE_PRODUCTS .'` AS `p` ' .
				'LEFT JOIN `'. TABLE_PRODUCT_TYPES .'` AS `pt` ON `pt`.`type_id` = `p`.`products_type` ' .
				'WHERE `p`. `products_id` = \'' . (int)$_GET['products_id'] . '\' LIMIT 1'
			);
			if(!$type->EOF) {
				// Validate this was a request to the product page
				$product_page = $type->fields['type_handler'] . '_info';
				if($_GET['main_page'] == $product_page) {
					$separator = '?';
					$this->canonical = ($request_type == 'SSL' ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG) .
						$this->make_url(
							$product_page,
							$this->get_product_canonical((int)$_GET['products_id']),
							'products_id', (int)$_GET['products_id'],
							SEO_URL_END,
							$separator
						);
					unset($separator);
				}
			}
			unset($type, $product_page, $separator);
		}
	}

	function check_redirect() {
		if($this->is_seopage) {
			$this->need_redirect();

			// This does not need to run if we are not on a seo_page
			if($this->need_redirect) {
				$this->do_redirect();
			}
		}
	}

	function need_redirect() {
		$this->need_redirect = false;

		// If we are in the admin we should never redirect
		// We should also avoid redirects with post content
		if(IS_ADMIN_FLAG != 'true' && count($_POST) <= 0) {

			// First see if we need to redirect because the URL contains main_page=
			$this->need_redirect = (preg_match('/[?&]main_page=([^&]*)/', $this->uri) === 1 ? true : false);

			// Retrieve the generated URL for this request
			$params = array();
			foreach($_GET as $key => $value) {
				if($key == 'main_page') continue;

				// Fix the case sensitivity, shopping cart sometimes breaks this
				if($key == 'cpath') $key = 'cPath';

				$params[] = $key . '=' . $value;
			}
			$params = (sizeof($params) > 0 ? implode('&', $params) : '');
			$my_url = $this->href_link($_GET['main_page'], $params, 'NONSSL', false, true, false, true);
			if($my_url === null) $my_url = original_zen_href_link($_GET['main_page'], $params, 'NONSSL', false);
			$this->redirect_url = parse_url($my_url);
			unset($my_url);

			// See if the path's match

			if($this->uri_parsed['path'] != $this->redirect_url['path']) {
				if($this->canonical !== null) {
					$canonical = parse_url($this->canonical);
					if($this->uri_parsed['path'] != $canonical['path']) {
						$this->need_redirect = true;
					}
				}
				else {
					$this->need_redirect = true;
				}

			}

			// See if the parameters match. We do not care about order.
			else {
				$params = asort(explode('&', $this->uri_parsed['query']));
				$old_params = asort(explode('&', $this->uri_parsed['query']));
				if(count($params) != count($old_params)) {
					$this->need_redirect = true;
				}
				else {
					for($i=0,$n=count($params);$i<$n;$i++) {
						if($params[$i] != $old_params[$i]) {
							$this->need_redirect = true;
							break;
						}
					}
				}
				unset($params, $old_params);
			}

			$this->redirect_url = $this->redirect_url['path'] . (array_key_exists('query', $this->redirect_url) ? '?' . $this->redirect_url['query'] : '');
		}
	}

	function check_seo_page() {
		$this->is_seopage = false;
		if(defined('SEO_ENABLED') && SEO_ENABLED == 'true') {
			$sefu = explode(',', str_replace(' ', '', SEO_URLS_ONLY_IN));
			if(!zen_not_null(SEO_URLS_ONLY_IN) || in_array($_GET['main_page'], $sefu)) {
				$this->is_seopage = true;
			}
		}
	}

	function do_redirect() {
		// Cleanup URL for redirection (this is actually needed)
		$this->redirect_url = str_replace('&amp;', '&', $this->redirect_url);

		switch(SEO_USE_REDIRECT){
			case 'true':
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . $this->redirect_url);
				break;
			default:
		}
	}
}