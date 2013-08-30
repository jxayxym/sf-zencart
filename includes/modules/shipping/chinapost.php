<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
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
// $Id: zones.php 1038 2005-03-18 07:09:17Z ajeh $
//
/*

  Note:
   China Post provides both domestic and international express mail service(EMS). 
  The rates are zone based. For international EMS, there are 11 zones 
  defined by China Post, each of them is a group of countries/areas. For domestic EMS, 
  the zones are not clearly defined by China Post and the rates may vary from area to area. 
  As an example, The domestic zones and rates published by GuangZhou Post on their website 
   are used in the module.
  
  They define 4 domestic zones, each of them is a  group of provinces. Therefore, 
  the module comes with support for 15 zones, 4 domestic and 11 international. 
  This can be easily changed by editing the 2 lines below in the zones constructor 
  that defines $this->num_domestic_zones and $this->num_inter_zones.

  The country codes of some countries/areas in zone 13 are nowhere to find, 
   so they are not inculded in the list: Canary Islands, Channel Islands, Curacao, Saipan, Jersey, St. Barthelemy,
   St. Eustatius, Tahiti, etc. 
  This module is based on zones.php, from which you can get more info on how it works and its limitations.

*/

  class chinapost {
    var $code, $title, $description, $enabled, $num_domestic_zones, $num_inter_zones, $num_zones;

// class constructor
    function chinapost() {
      $this->code = 'chinapost';
      $this->title = MODULE_SHIPPING_CHINAPOST_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_CHINAPOST_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_CHINAPOST_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/emszones/ems.png';
      $this->tax_class = MODULE_SHIPPING_CHINAPOST_TAX_CLASS;
      // disable only when entire cart is free shipping
      if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_CHINAPOST_STATUS == 'True') ? true : false);
      }

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_domestic_zones = 4;
      $this->num_inter_zones = 11;
      $this->num_zones = $this->num_domestic_zones + $this->num_inter_zones;
    }

// class methods
    function quote($method = '') {
      global $order, $shipping_weight;

      $dest_country = $order->delivery['country']['iso_code_2'];
      $dest_province = $order->delivery['state'];
      $dest_zone_id;

	// A zone inside china is a group of provinces.
	if($dest_country == "CN") {
	   $dest_zone_id = $dest_province;
	} else {
	   $dest_zone_id = $dest_country;
	}

      $dest_zone = 0;
      $error = false;
      $err_msg;

      for ($i=1; $i<=$this->num_zones; $i++) {
        $zones_table = constant('MODULE_SHIPPING_CHINAPOST_ZONES_' . $i);
        $zones = split("[,]", $zones_table);
        if (in_array($dest_zone_id, $zones)) {
          $dest_zone = $i;
          break;
        }
      }

      if ($dest_zone == 0) {
        $error = true;
        $err_msg = MODULE_SHIPPING_CHINAPOST_INVALID_ZONE;
      } else {
        $shipping = -1;
        $zones_cost = constant('MODULE_SHIPPING_CHINAPOST_COST_' . $dest_zone);

        $cost_table = split("[:,]" , $zones_cost);
        $size = sizeof($cost_table);
        for ($i=0; $i<$size; $i+=2) {
          if ($shipping_weight <= $cost_table[$i]) {
            $shipping = $cost_table[$i+1];
            $shipping_method = MODULE_SHIPPING_CHINAPOST_TEXT_WAY . ' ' . $dest_zone_id . ' : ' . $shipping_weight . ' ' . MODULE_SHIPPING_CHINAPOST_TEXT_UNITS;
            break;
          }
        }

        if ($shipping == -1) {
          //$shipping_cost = 0;
          //$shipping_method = MODULE_SHIPPING_CHINAPOST_UNDEFINED_RATE;
          $error = true;
          $err_msg = MODULE_SHIPPING_CHINAPOST_UNDEFINED_RATE.$shipping_weight.$cost_table[0].$cost_table[2].$cost_table[4];
        } else {
          $shipping_cost = ($shipping + constant('MODULE_SHIPPING_CHINAPOST_HANDLING_' . $dest_zone));
        }
      }

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_CHINAPOST_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (zen_not_null($this->icon)) $this->quotes['icon'] = '<img src="'.$this->icon.'" alt="'.$this->title.'" />';

      if ($error == true) $this->quotes['error'] = $err_msg;//MODULE_SHIPPING_CHINAPOST_INVALID_ZONE;

      return $this->quotes;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_CHINAPOST_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $ems_zones[0] = array('广东','0.5:20,1.0:26,1.5:32,2.0:38,2.5:44,3.0:50,3.5:56,4.0:62,4.5:68,5.0:74','0');
      $ems_zones[1] = array('河南,安徽,江苏,上海,湖北,浙江,江西,湖南,福建,四川,重庆,
贵州,广西,云南,海南','0.5:20,1.0:26,1.5:32,2.0:38,2.5:44,3.0:50,3.5:56,4.0:62,4.5:68,5.0:74', '0');
      $ems_zones[2] = array('北京,天津,河北,山西,山东,内蒙古,陕西,宁夏,甘肃,青海','0.5:20,1.0:29,1.5:38,2.0:47,2.5:56,3.0:65,3.5:74,4.0:83,4.5:92,5.0:101', '0');
      $ems_zones[3] = array('辽宁,吉林,黑龙江,新疆,西藏','0.5:20,1.0:35,1.5:40,2.0:55,2.5:70,3.0:85,3.5:100,4.0:115,4.5:130,5.0:145', '0');
      $ems_zones[4] = array('香港,澳门','0.5:150,1.0:180','0');
      $ems_zones[5] = array('JP,KR,MN,KP','0.5:145,1.0:218','0');
      $ems_zones[6] = array('KH,MY,SG,TH,VN,ID,PH','0.5:145,1.0:200','0');
      $ems_zones[7] = array('AU,NZ,PG,BN,NC','0.5:245,1.0:295','0');
      $ems_zones[8] = array('BE,DK,FI,GR,DE,IE,IT,LU,MT,NL,NO,PT,SE,CH,GB,AT,FR,ES,VU,FJ','0.5:285,1.0:365','0');
      $ems_zones[9] = array('US,CA','0.5:240,1.0:295','0');
      $ems_zones[10] = array('LA,NP,PK,LK,TR,BD,IN,GI,LI,MC','0.5:265,1.0:340','0');
      $ems_zones[11] = array('BR,CU,GY,AR,CO,MX,PA,PE,BS,BB,BO,CL,CR,UY,DM,DO,EC,PY,SV,GD,GT,HT,HN,JM,TT,VE','0.5:370,1.0:460','0');
      $ems_zones[12] = array('BH,CI,DJ,IR,IQ,IL,JO,KE,KW,MG,OM,QA,SN,SY,TN,UG,AE,BW,BF,GH,CY,EG,ET,GA,GL,TD,GN,ML,ZR,MA,MZ,NE,NG,CG,RW,DZ,AO,BZ,BJ,BT,BI,MW,CM,CV,CF,GQ,TG,GM,GW,LB,LS,LR,LY,MV,MR,MU,NA,NI,SA,SC,SL,SO,ZA,SD,SR,SZ,TZ,ZM,YZ,ZW','0.5:485,1.0:640','0');
      $ems_zones[13] = array('BY,KY,CZ,KZ,LV,RU,HR,EZ,HU,PL,RO,UA,AF,AL,AS,AD,AI,AG,AM,AW,AZ,NR,BM,BG,MK,KM,CK,GF,GE,GP,GU,IS,TV,LT,MH,MQ,YT,MD,MS,AN,RE,PR,WS,ST,SK,SI,SB,KN,LC,VC,TJ,TO,TM,TC,UZ,VG,VI,YU','0.5:457,1.0:577','0');
      $ems_zones[14] = array('台湾','0.5:180,1.0:220','0'); 

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('中国邮政EMS配送模块', 'MODULE_SHIPPING_CHINAPOST_STATUS', 'True', '你想提供中国邮政EMS配送服务吗?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('税率种类', 'MODULE_SHIPPING_CHINAPOST_TAX_CLASS', '0', '按以下税类对邮费收税。', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('排序顺序', 'MODULE_SHIPPING_CHINAPOST_SORT_ORDER', '0', '中国邮政EMS的显示顺序。', '6', '0', now())");
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        $zone_name = ' ';
        $zone_desc1 = ' ';
        $zone_desc2 = ' ';

        if ($i <= $this->num_domestic_zones) {
          $zone_name = '国内邮区 '. $i;
          $zone_desc1 = $zone_name . ' 省/市/自治区';
          $zone_desc2 = '列出该区所属省/市/自治区简称，并用逗号分开。';
        } else {
          $j = $i - $this->num_domestic_zones;
          $zone_name = '国际邮区 ' . $j;
          $zone_desc1 = $zone_name . ' 国家/地区';
          $zone_desc2 =  '列出该区所属国家/地区的2位ISO代码，并用逗号分开。';
        }

        $k = $i - 1;

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $zone_desc1 . "', 'MODULE_SHIPPING_CHINAPOST_ZONES_" . $i ."', '" . $ems_zones[$k][0] . "', '" . $zone_desc2 . " ', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('". $zone_name ." 资费表', 'MODULE_SHIPPING_CHINAPOST_COST_" . $i ."', '" . $ems_zones[$k][1]  ." ', '例如：3:8.50,7:10.50,... 重量小于等于3则邮费为8.5。', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('". $zone_name ." 手续费', 'MODULE_SHIPPING_CHINAPOST_HANDLING_" . $i."', '". $ems_zones[$k][2] ." ', '" . $zone_name . " 送货的手续费。', '6', '0', now())");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_CHINAPOST_STATUS', 'MODULE_SHIPPING_CHINAPOST_TAX_CLASS', 'MODULE_SHIPPING_CHINAPOST_SORT_ORDER');

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_CHINAPOST_ZONES_' . $i;
        $keys[] = 'MODULE_SHIPPING_CHINAPOST_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_CHINAPOST_HANDLING_' . $i;
      }

      return $keys;
    }
  }
?>