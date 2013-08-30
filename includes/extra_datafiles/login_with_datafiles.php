<?php
//谷歌API登录
define('GOOGLE_END_POINT', 'https://accounts.google.com/o/oauth2/auth');
define('GOOGLE_RESPONSE_TYPE', 'token');
define('GOOGLE_REDIRECT_URI',urlencode(HTTP_SERVER.DIR_WS_CATALOG.'index.php?main_page=token_receive&js=1'));
define('GOOGLE_SCOPE', urlencode('https://www.googleapis.com/auth/userinfo.profile').'+'.urlencode('https://www.googleapis.com/auth/userinfo.email'));
define('GOOGLE_CLIENT_ID','523236125459.apps.googleusercontent.com');
define('GOOGLE_TOKENINFO_URI', 'https://www.googleapis.com/oauth2/v1/tokeninfo');
define('GOOGLE_USERINFO_URI','https://www.googleapis.com/oauth2/v1/userinfo');
define('GOOGLE_STATE', 'hi_google');

define('GOOGLE_ACCOUNT_LOGIN_URI',GOOGLE_END_POINT.'?scope='.GOOGLE_SCOPE.'&redirect_uri='.GOOGLE_REDIRECT_URI.'&client_id='.GOOGLE_CLIENT_ID.'&response_type='.GOOGLE_RESPONSE_TYPE.'&state='.GOOGLE_STATE.'&approval_prompt=force');

//FACEBOOK
define('FACEBOOK_APP_ID', '458335730855524');
define('FACEBOOK_CLIENT_SECRET','5f8b239878eb4a46785e0a0db81083f7');
define('FACEBOOK_REDIRECT_URI',urlencode(HTTP_SERVER.DIR_WS_CATALOG.'index.php?main_page=token_receive'));
define('FACEBOOK_STATE', 'hi_facebook');
define('FACEBOOK_END_POINT', 'https://www.facebook.com/dialog/oauth');
define('FACEBOOK_USERINFO_URI', 'https://graph.facebook.com/me');
define('FACEBOOK_TOKEN_URI','https://graph.facebook.com/oauth/access_token?client_id='.FACEBOOK_APP_ID.'&redirect_uri='.FACEBOOK_REDIRECT_URI.'&client_secret='.FACEBOOK_CLIENT_SECRET);
//https://www.facebook.com/dialog/oauth?client_id=458335730855524&redirect_uri=http://www.dodohandbag.com/
//https://graph.facebook.com/oauth/access_token?client_id=458335730855524&redirect_uri=http://www.dodohandbag.com/&client_secret=5f8b239878eb4a46785e0a0db81083f7&code=AQCgr2vNBjb8HrY1OfKHMV6t13czwehxE5xzlF7wIgn1SKABxmXVQP_3EYRvO4BLiTh7YcHvc8IvwOFKw1U5IjhaEbd7jHC_Og7yAG1ABzXPP4qTFky70FPQSCHXKWWIvI_tZucZNPeWFaw2kI5QhSvWI4y2DMjCYoAqhR-kX3UBdaF3-pmPynizxn96QZreuT9kTI9XxHffEmHvS_yxopMv
define('FACEBOOK_ACCOUNT_LOGIN_URI', FACEBOOK_END_POINT.'?client_id='.FACEBOOK_APP_ID.'&state='.FACEBOOK_STATE.'&redirect_uri='.FACEBOOK_REDIRECT_URI);

//Hotmail
define('HOTMAIL_CLIENT_ID', '000000004C0CC042');
define('HOTMAIL_REDIRECT_URI', urlencode(HTTP_SERVER.DIR_WS_CATALOG.'index.php?main_page=token_receive&js=1'));
define('HOTMAIL_CLIENT_SECRET', 'aGJZMHhtG4S7jrmSvJydB1eVRtlMT8QL');
define('HOTMAIL_SCOPE', 'wl.emails');
define('HOTMAIL_RESPONSE_TYPE', 'token');
define('HOTMAIL_END_POINT', 'https://login.live.com/oauth20_authorize.srf');
define('HOTMAIL_USERINFO_URI', 'https://apis.live.net/v5.0/me');
define('HOTMAIL_TOKEN_URI','https://login.live.com/oauth20_token.srf');
define('HOTMAIL_STATE', 'hi_hotmail');
define('HOTMAIL_ACCOUNT_LOGIN_URI', HOTMAIL_END_POINT.'?client_id='.HOTMAIL_CLIENT_ID.'&scope='.HOTMAIL_SCOPE.'&response_type='.HOTMAIL_RESPONSE_TYPE.'&redirect_uri='.HOTMAIL_REDIRECT_URI.'&state='.HOTMAIL_STATE);

//yahoo
define('YAHOO_CONSUMER_KEY', 'dj0yJmk9dmE4b0lZbmNYNk4wJmQ9WVdrOWFUZGxiVmh0TXpJbWNHbzlNVEEyTlRJME5UQTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD1kNA--');
define('YAHOO_CONSUMER_SECRET', '783c3e559d6e5bd6c798e0ace3f68b2cd341074f%26');
define('YAHOO_OAUTH_CALLBACK', urlencode(HTTP_SERVER.DIR_WS_CATALOG.'index.php?main_page=token_receive'));
define('YAHOO_END_POINT', 'https://api.login.yahoo.com/oauth/v2/get_request_token');
define('YAHOO_OAUTH_SIGNATURE_METHOD', 'plaintext');
define('YAHOO_OAUTH_VERSION', '1.0');
define('YAHOO_XOAUTH_LANG_PREF','en-us');
define('YAHOO_OAUTH_NONCE',mt_rand());
define('YAHOO_OAUTH_TIMESTAMP',time());
define('YAHOO_ACCOUNT_LOGIN_URI', YAHOO_END_POINT."?oauth_nonce=".YAHOO_OAUTH_NONCE."&oauth_timestamp=".YAHOO_OAUTH_TIMESTAMP."&oauth_consumer_key=".YAHOO_CONSUMER_KEY."&oauth_signature_method=".YAHOO_OAUTH_SIGNATURE_METHOD."&oauth_signature=".YAHOO_CONSUMER_SECRET."&oauth_version=".YAHOO_OAUTH_VERSION."&xoauth_lang_pref=".YAHOO_XOAUTH_LANG_PREF."&oauth_callback=".YAHOO_OAUTH_CALLBACK);

//twitter
define('TWITTER_CONSUMER_KEY', '9qvjA0UD3oKKPsySc7ksA');
define('TWITTER_CONSUMER_SECRET', 'nSbbpdX6psAt7ic6f32WLeJUfUUpmG3jVUEH6lBnQ');
define('TWITTER_OAUTH_TOKEN', '');
define('TWITTER_REQUEST_TOKEN_URL', 'https://api.twitter.com/oauth/request_token');
define('TWITTER_OAUTH_CALLBACK',urlencode(HTTP_SERVER.DIR_WS_CATALOG.'index.php?main_page=token_receive'));
define('TWITTER_OAUTH_NONCE', mt_rand());
define('TWITTER_OAUTH_SIGNATURE_METHOD', 'HMAC-SHA1');
define('TWITTER_OAUTH_TIMESTAMP',time());
define('TWITTER_OAUTH_VERSION', '1.0');
define('TWITTER_ACCOUNT_LOGIN_URI', TWITTER_REQUEST_TOKEN_URL.'?oauth_callback='.TWITTER_OAUTH_CALLBACK.'&oauth_consumer_key='.TWITTER_CONSUMER_KEY.'&oauth_nonce='.TWITTER_OAUTH_NONCE.'&oauth_signature='.TWITTER_CONSUMER_SECRET.'&oauth_signature_method='.TWITTER_OAUTH_SIGNATURE_METHOD.'&oauth_timestamp='.TWITTER_OAUTH_TIMESTAMP.'&oauth_version='.TWITTER_OAUTH_VERSION);

define('FILENAME_TOKEN_RECEIVE', 'token_receive');

define('TABLE_CUSTOMERS_LOGIN_WITH', DB_PREFIX . 'ext_customers_login_with');
//https://login.live.com/oauth20_authorize.srf?client_id=000000004C0CC042&scope=wl.emails&response_type=taken&redirect_uri=http://www.cheapheremshandbagsonline.com/