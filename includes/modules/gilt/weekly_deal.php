<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
          from (" . TABLE_PRODUCTS . " p
          join " . TABLE_EXT_WEEKLY_DEAL . " wd on p.products_id = wd.products_id
          left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
          where p.products_id = wd.products_id
          and p.products_id = pd.products_id
          and p.products_status = 1 and wd.status = 1
          and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' limit 0,6";
$weakly_deal_items = $db->Execute($query);
require DIR_WS_TEMPLATE.'templates/tpl_module_weekly_deal.php';