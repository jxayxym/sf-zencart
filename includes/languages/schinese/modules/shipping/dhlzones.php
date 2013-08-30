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
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
// $Id: dhlzones.php 290 2004-09-15 19:48:26Z wilt $
//

define('MODULE_SHIPPING_DHLZONES_TEXT_TITLE', 'DHL 运费');
define('MODULE_SHIPPING_DHLZONES_TEXT_DESCRIPTION', 'DHL 运费');
define('MODULE_SHIPPING_DHLZONES_TEXT_WAY', '发货到');
define('MODULE_SHIPPING_DHLZONES_TEXT_UNITS', '克');
define('MODULE_SHIPPING_DHLZONES_INVALID_ZONE', '无法发货到该国家或地区');
define('MODULE_SHIPPING_DHLZONES_UNDEFINED_RATE', '现在无法计算运费');

define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_1_1', 'DHL运费');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_1_2', '您要使用DHL运费模块吗?');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_2_1', '计算方法');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_2_2', '运费计算是基于重量、价格还是数量?');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_3_1', '税率种类');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_3_2', '计算运费使用的税率种类。');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_4_1', '税率基准');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_4_2', '计算运费税的基准。选项为<br />Shipping - 基于客户的交货人地址<br />Billing - 基于客户的帐单地址<br />Store - 如果帐单地址/送货地区和商店地区相同，则基于商店地址');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_5_1', '排序顺序');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_5_2', '显示的顺序。');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_6_1', '设置不能发货的国家或地区，请输入用逗号分隔的两位ISO国家或地区代码');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_6_2', '不适用以下国家或地区: ');

define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_1', '地区');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_2', '的国家或地区代码');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_3', '用逗号分开的两位ISO标准的国家或地区代码：地区');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_4', '。<br />设置为00代表所有未指定的两位ISO国家或地区代码。');

define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_1', '地区');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_2', '的标准运费');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_3', '地区');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_4', '的运费基于分组的订单重量/价格。例如: 3:8.50,7:10.50,... 重量/价格低于或等于 3 的，运费为 8.50，送货地区');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_5', '。<br />最后金额设置为 10000:7% 收取订单总额的 7%');

define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_9_1', '地区');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_9_2', '的手续费');
define('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_9_3', '该配送地区的手续费');
?>