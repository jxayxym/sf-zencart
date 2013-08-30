<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: meta_tags.php 18697 2011-05-04 14:35:20Z wilt $
 */

// page title
define('TITLE', 'luxury-exchange.co');

// Site Tagline
define('SITE_TAGLINE', '');

// Custom Keywords
define('CUSTOM_KEYWORDS', '');

// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', '100% Authentic Handbags, Jewelry, Watches and Accessories. The worlds leading Full Service Luxury Brokerage Company in the purchase and sale of the finest and most opulent authentic luxury goods. Buy Sell and Consign authentic Hermes, Louis Vuitton, Chanel, Goyard, Bottega Veneta, Balenciaga, Tiffany, Cartier, Bvlgari and more.');
  define('HOME_PAGE_META_KEYWORDS', 'Luxury Exchange &trade;, luxury exchange, handbag consignment, luxury auctions, luxury auction, luxury auctions, sell bags, luxury consignment, bag consignment,  sell my bag, sell my bags, consign my bags, consign my bag, consign handbags,  sell my luxury, sell my watch, sell luxury, honolulu consignment, sell my lv, sell my louis vuitton, sell my chanel, sell my birkin, sell my hermes, sell my kelly, sell my jewlery, sell my luxury goods, luxury consign,  Honolulu consignment store, honolulu consignment shop, buy sell consign honolulu, birkin, kelly, buy sell trade honolulu, honolulu consignment, second hand honolulu, hawaii buy sell, sell bags honolulu, consignment hawaii consignment, hawaii consignments, honolulu consignments, hawaii consignment store,  luxury consignment, luxury consignments, consign bags, sell bags, sell my bags, sell purse, sell my purse, sell my bag, sell bags, sell my bags, cash for bags, sell my watch, sell my watches, consign designer bag, sell my bag, get cash for my bag, luxury consignment, sell luxury goods, resell my bag, cash out, exchange luxury, sell bag online, free consignment, designer goods consignment, free mailing consignment, mail my bag, send my bag, get cash for bag, online bag sale, mail in consignment, exchange luxury, sell luxury, sell designer goods, trusted consignment, mail my bag,  resell luggage, consign online, online consignment, cash for bag, sell authentic bag, Hermes, lv, Louis Vuitton,  Vuitton, Cartier, Tiffany, Bottega Veneta, Fendi, Yves Saint Laurent, Miu Miu, Bvlgari, sell bags online, consign my bag online');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', 'LUXURY EXCHANGE &trade; Authentic Luxury Marketplace'); // usually best left blank


// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it.
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_EZPAGE_#','');
  define('META_TAG_KEYWORDS_EZPAGE_#','');
  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_page_name','');
  define('META_TAG_KEYWORDS_page_name','');
  define('META_TAG_TITLE_page_name', '');

// Review Page can have a lead in:
  define('META_TAGS_REVIEW', 'Reviews: ');

// separators for meta tag definitions
// Define Primary Section Output
  define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ', ');

// Define divider ... usually just a space or a comma plus a space
  define('METATAGS_DIVIDER', ' ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
  define('ROBOTS_PAGES_TO_SKIP','login,logoff,create_account,account,account_edit,account_history,account_history_info,account_newsletters,account_notifications,account_password,address_book,advanced_search,advanced_search_result,checkout_success,checkout_process,checkout_shipping,checkout_payment,checkout_confirmation,cookie_usage,create_account_success,contact_us,download,download_timeout,customers_authorization,down_for_maintenance,password_forgotten,time_out,unsubscribe,info_shopping_cart,popup_image,popup_image_additional,product_reviews_write,ssl_check,shopping_cart');


// favicon setting
// There is usually NO need to enable this unless you need to specify a path and/or a different filename
//  define('FAVICON','favicon.ico');

