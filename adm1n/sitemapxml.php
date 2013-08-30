<?php
/**
 * Sitemap XML Feed
 *
 * @package Sitemap XML Feed
 * @copyright Copyright 2005-2012 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @link http://www.sitemaps.org/
 * @version $Id: sitemapxml.php, v 3.2.6 17.06.2012 16:13 AndrewBerezin $
 */

  require('includes/application_top.php');

  $current_version = '3.2.6 17.06.2012 16:13';

  if (defined('SITEMAPXML_VERSION')) {
    $default['SITEMAPXML_SITEMAPINDEX'] = 'sitemapindex';
    $default['SITEMAPXML_DIR_WS'] = '';
  } else {
    $default['SITEMAPXML_SITEMAPINDEX'] = 'sitemap';
    $default['SITEMAPXML_DIR_WS'] = 'sitemap';
  }
  $install_configuration = array(
'SITEMAPXML_VERSION' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_VERSION, $current_version, TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_VERSION, -10, null, 'zen_cfg_read_only('),

'SITEMAPXML_SITEMAPINDEX' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_SITEMAPINDEX, $default['SITEMAPXML_SITEMAPINDEX'], TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_SITEMAPINDEX, 1, null, null),

'SITEMAPXML_DIR_WS' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_DIR_WS, $default['SITEMAPXML_DIR_WS'], TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_DIR_WS, 1, null, null),

'SITEMAPXML_COMPRESS' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_COMPRESS, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_COMPRESS, 2, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),

'SITEMAPXML_LASTMOD_FORMAT' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_LASTMOD_FORMAT, 'date', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_LASTMOD_FORMAT, 3, null, 'zen_cfg_select_option(array(\'date\', \'full\'),'),

'SITEMAPXML_EXECUTION_TOKEN' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_EXECUTION_TOKEN, '', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_EXECUTION_TOKEN, 3, null, null),

'SITEMAPXML_USE_EXISTING_FILES' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_USE_EXISTING_FILES, 'true', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_USE_EXISTING_FILES, 4, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),

'SITEMAPXML_USE_ONLY_DEFAULT_LANGUAGE' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_USE_ONLY_DEFAULT_LANGUAGE, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_USE_ONLY_DEFAULT_LANGUAGE, 5, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),

//'SITEMAPXML_USE_DEFAULT_LANGUAGE' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_USE_DEFAULT_LANGUAGE, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_USE_DEFAULT_LANGUAGE, 6, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),

'SITEMAPXML_USE_LANGUAGE_PARM' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_USE_LANGUAGE_PARM, 'true', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_USE_LANGUAGE_PARM, 6, null, 'zen_cfg_select_option(array(\'true\', \'all\', \'false\'),'),

'SITEMAPXML_CHECK_DUBLICATES' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_CHECK_DUBLICATES, 'true', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_CHECK_DUBLICATES, 7, null, 'zen_cfg_select_option(array(\'true\', \'mysql\', \'false\'),'),

'SITEMAPXML_PING_URLS' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PING_URLS,
'Google => http://www.google.com/webmasters/sitemaps/ping?sitemap=%s;
Ask.com => http://submissions.ask.com/ping?sitemap=%s;
Bing => http://www.bing.com/webmaster/ping.aspx?siteMap=%s', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PING_URLS, 10, null, 'zen_cfg_textarea('),

'SITEMAPXML_HOMEPAGE_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_HOMEPAGE_ORDERBY, 'sort_order ASC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_HOMEPAGE_ORDERBY, 20, null, null),
'SITEMAPXML_HOMEPAGE_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_HOMEPAGE_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_HOMEPAGE_CHANGEFREQ, 21, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),

'SITEMAPXML_PRODUCTS_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PRODUCTS_ORDERBY, 'products_sort_order ASC, last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PRODUCTS_ORDERBY, 30, null, null),
'SITEMAPXML_PRODUCTS_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PRODUCTS_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PRODUCTS_CHANGEFREQ, 31, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
'SITEMAPXML_PRODUCTS_USE_CPATH' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PRODUCTS_USE_CPATH, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PRODUCTS_USE_CPATH, 32, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_PRODUCTS_IMAGES' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PRODUCTS_IMAGES, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PRODUCTS_IMAGES, 35, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_PRODUCTS_IMAGES_CAPTION' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PRODUCTS_IMAGES_CAPTION, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PRODUCTS_IMAGES_CAPTION, 36, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_PRODUCTS_IMAGES_LICENSE' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_PRODUCTS_IMAGES_LICENSE, '', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_PRODUCTS_IMAGES_LICENSE, 37, null, null),

'SITEMAPXML_CATEGORIES_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_CATEGORIES_ORDERBY, 'sort_order ASC, last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_CATEGORIES_ORDERBY, 40, null, null),
'SITEMAPXML_CATEGORIES_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_CATEGORIES_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_CATEGORIES_CHANGEFREQ, 41, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
'SITEMAPXML_CATEGORIES_IMAGES' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_CATEGORIES_IMAGES, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_CATEGORIES_IMAGES, 42, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_CATEGORIES_IMAGES_CAPTION' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_CATEGORIES_IMAGES_CAPTION, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_CATEGORIES_IMAGES_CAPTION, 43, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_CATEGORIES_IMAGES_LICENSE' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_CATEGORIES_IMAGES_LICENSE, '', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_CATEGORIES_IMAGES_LICENSE, 44, null, null),

'SITEMAPXML_REVIEWS_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_REVIEWS_ORDERBY, 'reviews_rating ASC, last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_REVIEWS_ORDERBY, 50, null, null),
'SITEMAPXML_REVIEWS_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_REVIEWS_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_REVIEWS_CHANGEFREQ, 51, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),

'SITEMAPXML_EZPAGES_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_EZPAGES_ORDERBY, 'sidebox_sort_order ASC, header_sort_order ASC, footer_sort_order ASC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_EZPAGES_ORDERBY, 60, null, null),
'SITEMAPXML_EZPAGES_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_EZPAGES_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_EZPAGES_CHANGEFREQ, 61, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),

'SITEMAPXML_TESTIMONIALS_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_TESTIMONIALS_ORDERBY, 'last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_TESTIMONIALS_ORDERBY, 70, null, null),
'SITEMAPXML_TESTIMONIALS_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_TESTIMONIALS_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_TESTIMONIALS_CHANGEFREQ, 71, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),

'SITEMAPXML_NEWS_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_NEWS_ORDERBY, 'last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_NEWS_ORDERBY, 80, null, null),
'SITEMAPXML_NEWS_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_NEWS_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_NEWS_CHANGEFREQ, 81, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),

'SITEMAPXML_MANUFACTURERS_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_MANUFACTURERS_ORDERBY, 'last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_MANUFACTURERS_ORDERBY, 90, null, null),
'SITEMAPXML_MANUFACTURERS_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_MANUFACTURERS_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_MANUFACTURERS_CHANGEFREQ, 91, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),
'SITEMAPXML_MANUFACTURERS_IMAGES' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_MANUFACTURERS_IMAGES, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_MANUFACTURERS_IMAGES, 92, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_MANUFACTURERS_IMAGES_CAPTION' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_MANUFACTURERS_IMAGES_CAPTION, 'false', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_MANUFACTURERS_IMAGES_CAPTION, 93, null, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
'SITEMAPXML_MANUFACTURERS_IMAGES_LICENSE' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_MANUFACTURERS_IMAGES_LICENSE, '', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_MANUFACTURERS_IMAGES_LICENSE, 94, null, null),

'SITEMAPXML_BOXNEWS_ORDERBY' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_BOXNEWS_ORDERBY, 'last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_BOXNEWS_ORDERBY, 100, null, null),
'SITEMAPXML_BOXNEWS_CHANGEFREQ' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_BOXNEWS_CHANGEFREQ, 'weekly', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_BOXNEWS_CHANGEFREQ, 101, null, 'zen_cfg_select_option(array(\'no\', \'always\', \'hourly\', \'daily\', \'weekly\', \'monthly\', \'yearly\', \'never\'),'),

//'SITEMAPXML_EXTRAURLS' => array(TEXT_CONFIGURATION_TITLE_SITEMAPXML_EXTRAURLS, 'last_date DESC', TEXT_CONFIGURATION_DESCRIPTION_SITEMAPXML_EXTRAURLS, 80, null, 'zen_cfg_textarea('),

/*
'SITEMAPXML_VIDEO_PING_URLS' => array('Ping urls',
'Google => http://www.google.com/webmasters/sitemaps/ping?sitemap=%s;
Ask.com => http://submissions.ask.com/ping?sitemap=%s;
Bing => http://www.bing.com/webmaster/ping.aspx?siteMap=%s', 'List of pinging urls separated by ;', 10, null, 'zen_cfg_textarea('),
*/
);

/*
  $admin_page = array(
          'page_key' => 'sitemapxml',
          'language_key' => 'BOX_SITEMAPXML',
          'main_page' => 'FILENAME_SITEMAPXML',
          'page_params' => '',
          'menu_key' => 'tools',
          'display_on_menu' => 'Y',
          'sort_order' => '',
                      );
  $ext_modules->install_admin_pages($admin_page);
*/
/*
  $admin_page = array(
          'page_key' => 'sitemapxmlConfig',
          'language_key' => 'BOX_CONFIGURATION_SITEMAPXML',
          'main_page' => 'FILENAME_CONFIGURATION',
          'page_params' => 'gID=' . $ext_modules->configuration_group_id,
          'menu_key' => 'configuration',
          'display_on_menu' => 'Y',
          'sort_order' => $ext_modules->configuration_group_id,
                      );
  $ext_modules->install_admin_pages($admin_page);
*/

  $install_table_sitemapxml_extraurls_sql =
"CREATE TABLE IF NOT EXISTS `" . TABLE_SITEMAPXML_EXTRAURLS . "` (
  `id` int(11) NOT NULL auto_increment,
  `loc` varchar(256) NOT NULL DEFAULT '',
  `lastmod` varchar(32) NOT NULL DEFAULT '',
  `changefreq` varchar(8) NOT NULL DEFAULT '',
  `priority` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM" . ((strtolower(DB_CHARSET) == 'utf8') ? ' /*!40101 DEFAULT CHARSET=utf8 */;' : ';');
//  $ext_modules->install_db_table(TABLE_SITEMAPXML_EXTRAURLS, $install_table_sitemapxml_extraurls_sql);

$action = (isset($_POST['action']) ? $_POST['action'] : '');

if (zen_not_null($action)) {

  switch ($action) {
    // demo active test
    case (zen_admin_demo()):
      $action = '';
      $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
      zen_redirect(zen_href_link(FILENAME_SITEMAPXML));
      break;

    case 'upgrade':
    case 'install':
      require_once(DIR_WS_CLASSES . 'ext_modules.php');
      $ext_modules = new ext_modules;
      $ext_modules->install_configuration_group('SITEMAPXML_', 'BOX_CONFIGURATION_SITEMAPXML', 'SitemapXML', 'sitemapxmlConfig');
      $ext_modules->install_configuration($install_configuration);
/*
      if ($action == 'upgrade') {
        if (sizeof($ext_modules->configUpdates['add']) > 0) {
          $messageStack->add_session(TEXT_UPGRADE_CONFIG_ADD, 'success');
          foreach ($ext_modules->configUpdates['add'] as $msg) {
            $messageStack->add_session('&nbsp;nbsp;nbsp;' . $msg, 'success');
          }
        }
        if (sizeof($ext_modules->configUpdates['upd']) > 0) {
          $messageStack->add_session(TEXT_UPGRADE_CONFIG_UPD, 'success');
          foreach ($ext_modules->configUpdates['upd'] as $msg) {
            $messageStack->add_session('&nbsp;nbsp;nbsp;' . $msg, 'success');
          }
        }
        if (sizeof($ext_modules->configUpdates['del']) > 0) {
          $messageStack->add_session(TEXT_UPGRADE_CONFIG_DEL, 'success');
          foreach ($ext_modules->configUpdates['del'] as $msg) {
            $messageStack->add_session('&nbsp;nbsp;nbsp;' . $msg, 'success');
          }
        }
      }
*/
/*
if (function_exists('zen_register_admin_page')) {
  $admin_page = array(
          'page_key' => 'sitemapxml',
          'language_key' => 'BOX_SITEMAPXML',
          'main_page' => 'FILENAME_SITEMAPXML',
          'page_params' => '',
          'menu_key' => 'tools',
          'display_on_menu' => 'Y',
          'sort_order' => '',
                      );
  if (zen_page_key_exists($page['page_key']) == FALSE) {
    if (!isset($page['sort_order']) || (int)$page['sort_order'] == 0) {
      $sql = "SELECT MAX(sort_order) AS sort_order_max FROM " . TABLE_ADMIN_PAGES . " WHERE menu_key = :menu_key:";
      $sql = $db->bindVars($sql, ':menu_key:', $page['menu_key'], 'string');
      $result = $db->Execute($sql);
      $page['sort_order'] = $result->fields['sort_order_max']+1;
    }
    zen_register_admin_page($page['page_key'], $page['language_key'], $page['main_page'], $page['page_params'], $page['menu_key'], $page['display_on_menu'], $page['sort_order'])
  }
}
*/
      zen_redirect(zen_href_link(FILENAME_SITEMAPXML));
      break;

    case 'uninstall':
      require_once(DIR_WS_CLASSES . 'ext_modules.php');
      $ext_modules = new ext_modules;
      $ext_modules->uninstall_configuration('SITEMAPXML_');
      $ext_modules->uninstall_admin_pages(array('sitemapxml', 'sitemapxmlConfig'));
      zen_redirect(zen_href_link(FILENAME_SITEMAPXML));
      break;

    case 'view_file':
    case 'truncate_file':
    case 'delete_file':
      if (isset($_POST['file']) && trim($_POST['file']) != '' && (($ext = substr($_POST['file'], strpos($_POST['file'], '.'))) == '.xml' || $ext = '.xml.gz')) {
        $file = zen_db_prepare_input($_POST['file']);
        switch ($action) {
          case 'view_file':
            if ($fp = fopen(DIR_FS_CATALOG . $file, 'r')) {
              header('Content-Length: ' . filesize(DIR_FS_CATALOG . $file));
              header('Content-Type: text/plain');
              while (!feof($fp)) {
                $contents = fread($fp, 8192);
                echo $contents;
              }
              fclose($fp);
              die();
            } else {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_ERROR_OPENED, $file), 'error');
            }
            break;
          case 'truncate_file':
            if ($fp = fopen(DIR_FS_CATALOG . $file, 'w')) {
              fclose($fp);
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_TRUNCATED, $file), 'success');
            } else {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_ERROR_OPENED, $file), 'error');
            }
            break;
          case 'delete_file':
            if (unlink(DIR_FS_CATALOG . $file)) {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_DELETED, $file), 'success');
            } else {
              $messageStack->add_session(sprintf(TEXT_MESSAGE_FILE_ERROR_DELETED, $file), 'error');
            }
            break;
        }
      }
      zen_redirect(zen_href_link(FILENAME_SITEMAPXML));
      break;

  }

}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<style>
.alert {
  color:#FF0000;
  font-weight:bold;
}
.index {
  font-weight:bold;
}
.zero {
/*  text-decoration: line-through; */
  font-style:italic;
}
</style>
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<script type="text/javascript">
<!--
function getFormFields(obj) {
  var getParms = "&";
  for (i=0; i<obj.childNodes.length; i++) {
    if (obj.childNodes[i].name == "securityToken") continue;
    if (obj.childNodes[i].tagName == "INPUT") {
      if (obj.childNodes[i].type == "text") {
        getParms += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
      }
      if (obj.childNodes[i].type == "hidden") {
        getParms += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
      }
      if (obj.childNodes[i].type == "checkbox") {
        if (obj.childNodes[i].checked) {
          getParms += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
        } else {
          getParms += obj.childNodes[i].name + "=&";
        }
      }
      if (obj.childNodes[i].type == "radio") {
        if (obj.childNodes[i].checked) {
          getParms += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
        }
      }
    }
    if (obj.childNodes[i].tagName == "SELECT") {
      var sel = obj.childNodes[i];
      getParms += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
    }
  }
  getParms = getParms.replace(/\s+/g," ");
  getParms = getParms.replace(/ /g, "+");
  return getParms;
}
  // -->
</script>
</head>
<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo (defined('SITEMAPXML_VERSION') ? ' v ' . SITEMAPXML_VERSION : ''); ?></td>
          </tr>
        </table></td>
      </tr>

<?php
$configuration_group_id = $db->Execute("SELECT configuration_group_id
                                        FROM " . TABLE_CONFIGURATION . "
                                        WHERE configuration_key LIKE 'SITEMAPXML_%' LIMIT 1");

if (!$configuration_group_id->EOF) {
  $sitemapxml_configuration_group_id = $configuration_group_id->fields['configuration_group_id'];
}
if (!defined('SITEMAPXML_VERSION') && !isset($sitemapxml_configuration_group_id)) {
?>
      <tr>
        <td>
          <div style="border: solid 1px; padding: 4px;"><?php echo zen_draw_form('install', FILENAME_SITEMAPXML, '', 'post') . zen_draw_hidden_field('action', 'install') . '<input type="submit" value="' . TEXT_INSTALL . '" />' . '</form>'; ?></div>
        </td>
      </tr>
<?php
} elseif (SITEMAPXML_VERSION != $current_version) {
?>
      <tr>
        <td>
          <div style="border: solid 1px; padding: 4px;"><?php echo zen_draw_form('upgrade', FILENAME_SITEMAPXML, '', 'post') . zen_draw_hidden_field('action', 'upgrade') . '<input type="submit" value="' . TEXT_UPGRADE . '" />' . '</form>'; ?></div>
        </td>
      </tr>
<?php
}
?>

<?php
$sitemapxml_install_notes = '';
$filesArray = array(
        DIR_FS_CATALOG . 'googlesitemap.php.txt',
        DIR_FS_CATALOG . 'googlesitemap.php',
        DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.ext_modules.php',
        DIR_FS_ADMIN . DIR_WS_INCLUDES . 'init_includes/init_ext_modules.php',
        DIR_FS_ADMIN . DIR_WS_MODULES . 'ext_modules/sitemapxml.php',
        DIR_FS_ADMIN . DIR_WS_FUNCTIONS . 'extra_functions/sitemapxml.php',
        DIR_FS_CATALOG . DIR_WS_MODULES . 'pages/sitemapxml/sitemapxml_homepage.php',
                    );
if (version_compare(PROJECT_VERSION_NAME . ' ' . PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR, '1.5.0', '>=')) {
  $filesArray[] = DIR_FS_ADMIN . DIR_WS_INCLUDES . 'boxes/extra_boxes/sitemapxml_tools_dhtml.php';
}
foreach ($filesArray as $file) {
  if (is_file($file)) {
    if (!@unlink($file)) {
      $sitemapxml_install_notes .= TEXT_SITEMAPXML_INSTALL_DELETE_FILE . ' - ' . $file . '<br />';
    }
  }
}

if ($sitemapxml_install_notes != '') {
?>
      <tr>
        <td>
                <h3><span class="alert"><?php echo TEXT_SITEMAPXML_INSTALL_HEAD; ?></span></h3>
                <div style="border: solid 1px; padding: 4px;"><span class="alert"><?php echo $sitemapxml_install_notes; ?></span></div>
        </td>
      </tr>
<?php } ?>

<?php
if (defined('SITEMAPXML_VERSION') && SITEMAPXML_VERSION == $current_version) {
  $start_parms = '';
  if (defined('SITEMAPXML_EXECUTION_TOKEN') && zen_not_null(SITEMAPXML_EXECUTION_TOKEN)) {
    $start_parms = 'token=' . SITEMAPXML_EXECUTION_TOKEN;
  }
?>
      <tr>
        <td width="100%" valign="top">
          <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td width="100%" align="left" valign="top">

                <h3><?php echo TEXT_SITEMAPXML_INSTRUCTIONS_HEAD; ?></h3>
                <fieldset>
                  <legend><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS; ?></legend>
                  <?php echo zen_draw_form('pingSE', FILENAME_SITEMAPXML, '', 'post', 'id="pingSE" target="_blank" onsubmit="javascript:window.open(\'' .  zen_catalog_href_link(FILENAME_SITEMAPXML, $start_parms) . '\'+getFormFields(this), \'sitemapPing\', \'resizable=1,statusbar=5,width=700,height=400,top=0,left=50,scrollbars=yes\');return false;"'); ?>
                    <?php echo zen_draw_checkbox_field('rebuild', 'yes', false, '', 'id="rebuild"'); ?>
                    <label for="rebuild"><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS_REBUILD; ?></label>
                    <br class="clearBoth" />
<?php if (false) { ?>
                    <?php echo zen_draw_checkbox_field('inline', 'yes', false, '', 'id="inline"'); ?>
                    <label for="inline"><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS_INLINE; ?></label>
                    <br class="clearBoth" />
<?php } ?>
                    <?php echo zen_draw_checkbox_field('ping', 'yes', false, '', 'id="ping"'); ?>
                    <label for="ping"><?php echo TEXT_SITEMAPXML_CHOOSE_PARAMETERS_PING; ?></label>
                    <br class="clearBoth" />
                    <?php echo '<button type="submit">' . IMAGE_SEND . '</button>'; ?>
                  </form>
                </fieldset>

                <h3><?php echo TEXT_SITEMAPXML_FILE_LIST; ?></h3>
                <div style="border: solid 1px; padding: 4px;">
                  <table cellspacing="0px" cellpadding="3px" border="0px" width="100%">
                    <tr class="dataTableHeadingRow">
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FNAME; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FSIZE; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FTIME; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_FPERMS; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_TYPE; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_ITEMS; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_COMMENTS; ?></th>
                      <th class="dataTableHeadingContent"><?php echo TEXT_SITEMAPXML_FILE_LIST_TABLE_ACTION; ?></th>
                    </tr>
<?php
$indexFile = SITEMAPXML_SITEMAPINDEX . (SITEMAPXML_COMPRESS == 'true' ? '.xml.gz' : '.xml');
if (!($sitemapFiles = glob(DIR_FS_CATALOG . 'sitemap' . '*' . '.xml'))) $sitemapFiles = array();
if (!($sitemapFilesGZ = glob(DIR_FS_CATALOG . 'sitemap' . '*' . '.xml.gz'))) $sitemapFilesGZ = array();
$sitemapFiles = array_merge($sitemapFiles, $sitemapFilesGZ);
if (SITEMAPXML_DIR_WS != '') {
  $sitemapxml_dir_ws = SITEMAPXML_DIR_WS;
  $sitemapxml_dir_ws = trim($sitemapxml_dir_ws, '/');
  $sitemapxml_dir_ws .= '/';
  if (($files = glob(DIR_FS_CATALOG . $sitemapxml_dir_ws . 'sitemap' . '*' . '.xml'))) $sitemapFiles = array_merge($sitemapFiles, $files);
  if (($files = glob(DIR_FS_CATALOG . $sitemapxml_dir_ws . 'sitemap' . '*' . '.xml.gz'))) $sitemapFiles = array_merge($sitemapFiles, $files);
}
sort($sitemapFiles);
//echo '<pre>';var_export($sitemapFiles);echo '</pre>';
if (in_array(DIR_FS_CATALOG . $indexFile, $sitemapFiles)) {
  $sitemapFiles = array_merge(array(DIR_FS_CATALOG . $indexFile), $sitemapFiles);
}
$sitemapFiles = array_unique($sitemapFiles);
clearstatcache();
$l = strlen(DIR_FS_CATALOG);
foreach ($sitemapFiles as $file) {
  $f['name'] = substr($file, $l);
  $f['size'] = filesize($file);
  $f['time'] = filemtime($file);
  $f['time'] = date(PHP_DATE_TIME_FORMAT, $f['time']);
  $f['perms'] = fileperms($file);
  $f['perms'] = substr(sprintf('%o', $f['perms']), -4);
  $class = '';
  $comments = '';
  $type = '';
  $items = '';
  if (!is_writable($file)) {
    $class .= ' alert';
    $comments .= ' ' . TEXT_SITEMAPXML_FILE_LIST_COMMENTS_READONLY;
  }
  if ($f['name'] == $indexFile) {
    $class .= ' index';
  }
  if ($f['size'] == 0) {
    $class .= ' zero';
    $comments .= ' ' . TEXT_SITEMAPXML_FILE_LIST_COMMENTS_IGNORED;
  }
  if ($f['size'] > 0) {
    if ($fp = fopen($file, 'r')) {
      $contents = '';
      while (!feof($fp)) {
        $contents .= fread($fp, 8192);
      }
      fclose($fp);
      if (strpos($contents, '</urlset>') !== false) {
        $type = TEXT_SITEMAPXML_FILE_LIST_TYPE_URLSET;
        $items = substr_count($contents, '</url>');
      } elseif (strpos($contents, '</sitemapindex>') !== false) {
        $type = TEXT_SITEMAPXML_FILE_LIST_TYPE_SITEMAPINDEX;
        $items = substr_count($contents, '</sitemap>');
      } else {
        $type = TEXT_SITEMAPXML_FILE_LIST_TYPE_UNDEFINE;
        $items = '';
      }
      unset($contents);
    } else {
      $items = '<span color="red">' . 'Error!!!' . '</span>';
    }
  }
?>
                    <tr class="dataTableRow <?php echo $class; ?>" onmouseout="rowOutEffect(this)" onmouseover="rowOverEffect(this)">
                      <td class="dataTableContent" align="left"><a href="<?php echo HTTP_CATALOG_SERVER . DIR_WS_CATALOG . $f['name']; ?>" target="_blank"><?php echo $f['name']; ?>&nbsp;<?php echo zen_image(DIR_WS_IMAGES . 'icon_popup.gif', '', '9', '9'); ?></a></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="right"><?php echo $f['size']; ?></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="center"><?php echo $f['time']; ?></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="center"><?php echo $f['perms']; ?></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="center"><?php echo $type; ?></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="right"><?php echo $items; ?></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="left"><?php echo trim($comments); ?></td>
                      <td class="dataTableContent <?php echo $class; ?>" align="right">
<?php
if ($f['size'] > 0) {
  echo '<a href="http://validator.w3.org/check?uri=' . urlencode(HTTP_CATALOG_SERVER . DIR_WS_CATALOG . $f['name']) . '&charset=utf-8&doctype=Inline&group=0&user-agent=W3C_Validator%2F1.2" target="_blank">' . '[W3C_Validator]' . '</a>';
  echo '<a href="http://www.validome.org/google/validate?url=' . urlencode(HTTP_CATALOG_SERVER . DIR_WS_CATALOG . $f['name']) . '&lang=en&googleTyp=SITEMAP" target="_blank">' . '[validome.org]' . '</a>';
  echo zen_draw_form('view_file', FILENAME_SITEMAPXML, '', 'post', 'target="_blank"') . zen_draw_hidden_field('action', 'view_file') . zen_draw_hidden_field('file', $f['name']) . '<input type="submit" value="' . TEXT_ACTION_VIEW_FILE . '" />' . '</form>';
  echo zen_draw_form('truncate_file', FILENAME_SITEMAPXML, '', 'post') . zen_draw_hidden_field('action', 'truncate_file') . zen_draw_hidden_field('file', $f['name']) . '<input type="submit" value="' . TEXT_ACTION_TRUNCATE_FILE . '" />' . '</form>';
}
echo zen_draw_form('delete_file', FILENAME_SITEMAPXML, '', 'post') . zen_draw_hidden_field('action', 'delete_file') . zen_draw_hidden_field('file', $f['name']) . '<input type="submit" value="' . TEXT_ACTION_DELETE_FILE . '" />' . '</form>';
?>
                      </td>
                    </tr>
<?php
}
?>
                  </table>
                  <u><a href="javascript: window.location.reload()">Reload Window</a></u>
                </div>

                <table border="0" width="100%" cellspacing="2" cellpadding="2">
                  <tr>
                     <td width="50%" valign="top">
                <h3><?php echo TEXT_SITEMAPXML_OVERVIEW_HEAD; ?></h3>
                <div style="border: solid 1px; padding: 4px;"><?php echo TEXT_SITEMAPXML_OVERVIEW_TEXT; ?></div>
                    </td>
                     <td width="50%" valign="top">
                <h3><?php echo TEXT_SITEMAPXML_TIPS_HEAD; ?></h3>
                <div style="border: solid 1px; padding: 4px;"><?php echo TEXT_SITEMAPXML_TIPS_TEXT; ?></div>
                  </tr>
                </table>

              </td>
            </tr>
<?php
/*
    if (!($robots_txt = @file_get_contents($this->savepath . 'robots.txt'))) {
      echo '<b>File "robots.txt" not found in save path - "' . $this->savepath . 'robots.txt"</b>' . '<br />';
    } elseif (!preg_match("@Sitemap:\s*(.*)\n@i", $robots_txt . "\n", $m)) {
      echo '<b>Sitemap location don\'t specify in robots.txt</b>' . '<br />';
    } elseif (trim($m[1]) != $this->base_url . $this->sitemapindex) {
      echo '<b>Sitemap location specified in robots.txt "' . trim($m[1]) . '" another than "' . $this->base_url . $this->sitemapindex . '"</b>' . '<br />';
    }
*/
?>
            <tr>
              <td width="100%" align="left" valign="top">
                <div style="border: padding: 4px;"><br /><?php echo zen_draw_form('uninstall', FILENAME_SITEMAPXML, '', 'post') . zen_draw_hidden_field('action', 'uninstall') . '<input type="submit" value="' . TEXT_UNINSTALL . '" />' . '</form>'; ?></div>
              </td>
            </tr>
<?php
}
?>
          </table>
        </td>
      </tr>
      <tr><td class="smallText" align="center">Copyright &copy; 2004-<?php echo date('Y'); ?> <a href="http://ecommerce-service.com" target="_blank">eCommerce-Service</a></td></tr><!-- body_text_eof //-->
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
