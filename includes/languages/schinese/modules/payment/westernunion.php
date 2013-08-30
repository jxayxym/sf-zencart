<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: westernunion.php,v 1.1 2008-03-20 Jack $
//
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', '收款人 ');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', '付款人 ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', '金额: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', '货币: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', '收款人名字: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', '收款人姓氏: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', '收款人地址: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', '收款人邮编: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', '收款人城市: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', '收款人国家: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', '收款人电话: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', '安全问题: ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', '安全答案: ');
  
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', '收款人名字');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', '收款人姓氏');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', '收款人地址');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', '收款人邮编');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', '收款人城市');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', '收款人国家');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', '收款人电话');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_1_1','打开西联汇款模块');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_1_2','您要使用西联汇款吗?');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_2_1','显示顺序');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_2_2','显示顺序：小的显示在前。'); 
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_3_1','设置订单状态');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_3_2','设置采用西联汇款的订单状态'); 
  
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_TITLE', '西联汇款');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', '请付款到:<br><br>' .  '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '<br>'  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '<br>'  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY .   '</b>'.  MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . '<br>'  .  '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '<br>'  .   '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '<br>' . '<font size=2 color="red"><b>请您付款之后，告知我们您的名字、姓氏、付款金额、付款币种、付款国别</b></font>');
  
  
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "请付款到:\n\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . " - " . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . "\n\n" . 
'<b>请您付款之后，告知我们您的名字、姓氏、付款金额、付款币种、付款国别</b>' . "\n\n" .  '<b>我们收到西联汇款的MTCN号后，订单才会处理。</b>');

  define('MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_IMG', DIR_WS_MODULES . '/payment/westernunion/westernunion.gif');
  define('MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_ALT', '西联汇款');
  define('MODULE_PAYMENT_WESTERNUNION_ACCEPTANCE_MARK_TEXT', '于世界各地汇款及取款');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_WESTERNUNION_ACCEPTANCE_MARK_TEXT . '</span>');

?>
