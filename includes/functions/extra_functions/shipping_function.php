<?php
/**
 * @package admin
 * @license http://www.zen-cart.cn
 * @author Morrowind  
 * @contact 752979972@qq.com / hnsytcg@163.com
 * @version $Id: shipping_4px.php 15881 2011-06-22 16:32:39Z wilt $
 */
 
class Shipping_4px{ //此类自动加载 调用此类的方法，先实例化即可
/**
*获得汇率值
*function :get_currencies_value()
*参数说明：（货币代码）
*返回汇率值
*/
  public function get_currencies_value($code){
    global $db;
	$sql_statement    = "select value from ".TABLE_CURRENCIES."  where code='".$code."'";
	$get_result       = $db->Execute($sql_statement);
	return $get_result->fields['value'];
  }
/**
*获得物流例表运费
*function :get_list_shipping_estimates()
*参数说明：(国家ID , 实际重量 , 当前货币代码);
*返回物流运费例表形式
*/
  public function get_list_shipping_estimates($country_id,$actual_weight,$currency_code='USD'){
    $get_shipping_list  = $this->get_shipping_info();
		if(empty($get_shipping_list)) return false;
	foreach($get_shipping_list as $key=>$value){
	  $return_info[]    = $this->get_one_shipping_estimates($get_shipping_list[$key]['pr_id'],$country_id,$actual_weight,$currency_code);
	}
	return $return_info;
  }
 
/**
*获得递四方国家ID 
*function :get_4px_country_id()
*参数说明：(zen-cart国家ID，zen-cart国家代码可不填);
*返回递四方国家ID
*/
public function get_4px_country_id($zen_country_id,$zen_code=null){
	global $db;
	 $sql_zen = "select countries_id,countries_iso_code_2 from countries where countries_id='".$zen_country_id."'";
	 $result_zen = $db->Execute($sql_zen);
	 $zen_code = $result_zen->fields['countries_iso_code_2'];
	 if($zen_code){
		 $sql_statement  =  "select countries_id from shipping_country where country_code='".$zen_code."'";
	   $get_result     =  $db->Execute($sql_statement);
	 }
   return $get_result->fields['countries_id'];
}
/**
*获得单个物流运费
*function :get_one_shipping_estimates()
*参数说明：(物流产品ID , 国家ID , 实际重量 , 当前货币代码);
*返回单个物流运费信息
*/

public function  get_one_shipping_estimates($shipping_id,$country_id,$actual_weight,$currency_code='USD'){
  $country_id         = $this->get_4px_country_id($country_id);
	$default_currency   = $this->get_currencies_value('CNY')?$this->get_currencies_value('CNY'):1;
  $get_shipping_list  = $this->get_shipping_info($shipping_id);
	$pk_code            = $get_shipping_list['pk_code'];
	$pr_name            = $get_shipping_list['pr_name'];
	$perc_price         = $get_shipping_list['perc_price']>0?$get_shipping_list['perc_price']/100:1;
	$incr_price         = $get_shipping_list['incr_price'];
	$weight_type        = $get_shipping_list['weight_type'];
	$shipping_logo      = $get_shipping_list['shipping_logo'];
	$remark             = $get_shipping_list['remark'];
	$get_area_id        = $this->get_area_id($shipping_id,$country_id);
	if(!$get_area_id){
		return false;
	}
	$get_currency_value = $this->get_currencies_value($currency_code);
	$get_value_info     = $this->get_calculation_price_value($shipping_id,$get_area_id,$actual_weight);
	$wk_code            = $get_value_info['wk_code'];
	$fv_unitweight      = $get_value_info['fv_unitweight'];
	$price_value        = $get_value_info['price_value'];
	$get_price_value    = $this->get_shipping_calculation_methods($price_value,$actual_weight,$wk_code,$fv_unitweight);
	$final_price_value  = $get_price_value?$get_price_value*$perc_price+$incr_price:0;
	unset($perc_price,$incr_price);
	$IncidentalPrice    = $this->getIncidentalPrice($shipping_id,$actual_weight,$final_price_value);
	$return_info        = array('pr_id'=>$shipping_id,
	                            'pk_code'=>$pk_code,
								'pr_name'=>$pr_name,
								'shipping_logo'=>$shipping_logo,
								'remark'=>$remark,
								'shipping_price'=>$final_price_value/$default_currency,
								'shipping_fuel'=>$IncidentalPrice['fuel']/$default_currency,
								'shipping_other'=>$IncidentalPrice['other']/$default_currency
								);
	return $return_info;
  }

/**
*获得区域ID
*function :get_area_id()
*参数说明：（物流方式ID , 国家ID）
*返回区域ID
*/
 public function get_area_id($shipping_id,$countries_id){
   global $db;
   $sql_statement  =  "select area_id from shipping_freightpricearea where countries_id='".$countries_id."' and pr_id='".$shipping_id."'";
   $get_result     = $db->Execute($sql_statement);
   return $get_result->fields['area_id'];
 }
 
/**
*获得物流价格属性
*function :get_calculation_price_value()
*参数说明：（物流方式ID , 国家ID）
*返回物流价格属性值、计算标识、计算单位
*/
 public function get_calculation_price_value($shipping_id,$area_id,$weight_interval){
   global $db;
   $sql_statement                 =  "select wk_code,fv_unitweight,price_value from shipping_freightpricevalue where pr_id ='".$shipping_id."' and area_id ='".$area_id."' and weight_start<='".$weight_interval."' and '".$weight_interval."'<weight_end ";
   $get_result                    = $db->Execute($sql_statement);
   $return_info['wk_code']        = $get_result->fields['wk_code'];
   $return_info['fv_unitweight']  = $get_result->fields['fv_unitweight'];
   $return_info['price_value']    = $get_result->fields['price_value'];
   return $return_info;
 }
 
/**
*获得物流信息例表,或单个信息
*function :get_shipping_info()
*参数说明：（物流产品ID）  -->  可填可不填 
*如果有参数，返回单个物流信息；如果有多个，返回物流例表信息
*/
  public function get_shipping_info($shipping_id=null){
    global $db;
	$condition         = $shipping_id?" and pr_id='".$shipping_id."' ":null;
	$sql_statement     = "select * from shipping_pricerule where status=1 ".$condition." order by sort_index,pr_id";
	$return_result     = $db->Execute($sql_statement);
	$i                 = 0;
	while(!$return_result->EOF){
	  $return[$i]['pr_id']           = $return_result->fields['pr_id'];
	  $return[$i]['pk_code']         = $return_result->fields['pk_code'];
	  $return[$i]['pr_name']         = $return_result->fields['pr_name'];
	  $return[$i]['perc_price']      = $return_result->fields['perc_price'];
	  $return[$i]['incr_price']      = $return_result->fields['incr_price'];
	  $return[$i]['weight_type']     = $return_result->fields['weight_type'];
	  $return[$i]['shipping_logo']   = $return_result->fields['shipping_logo'];
	  $return[$i]['remark'] 	     = $return_result->fields['remark'];
	  $i++;
	  $return_result->MoveNext();
	}
	$return_info                     =  $shipping_id?$return[0]:$return;
	return $return_info;
  }


  
/**
*获得物流计算方法
*function :get_shipping_calculation_methods()
*参数说明：（单位价格 , 重量，标志 , 计算单位 ）
*返回计算价格
*/
  public function get_shipping_calculation_methods($price_value,$weight,$wk_code,$fv_unitweight){
    if($wk_code==2){//单价计算方法
      $last_weight           = ($fv_unitweight<=0 or $weight<=0)?0:$weight/$fv_unitweight;
      $final_weight          = ceil($last_weight)*$fv_unitweight;
      $final_price           = $final_weight!=0?$final_weight*$price_value/$fv_unitweight:0;
    }else{//总价计算
      $final_price           = $price_value;
    }
    return $final_price;
  }
 
/**
*获得附件费用
*function :getIncidentalPrice()
*参数说明：（物流方式ID , 总的重量 , 最终的价格 , 货币汇率 ）
*返回燃油费、其他杂费
*/
  public function getIncidentalPrice($pr_id,$total_weight,$final_price){
    global $db;
	$sql_statement    = "select * from shipping_incidentalprice  where pr_id='".$pr_id."'";
	$get_result       = $db->Execute($sql_statement);
	while(!$get_result->EOF){
	  $fk_code 	      = $get_result->fields['fk_code'];
	  $ut_code 	      = $get_result->fields['ut_code'];
	  $pricevalue 	  = $get_result->fields['pricevalue'];
	  $max_value 	  = $get_result->fields['max_value'];
	  $min_value 	  = $get_result->fields['min_value'];
	   if($ut_code==1){
	    $pricevalue           = $pricevalue/100;
	    $price                = $final_price*$pricevalue;
	  }elseif($ut_code==3){
	    $price                = $pricevalue*$total_weight;
	  }else{
	    $price                = $pricevalue;
	  }
	  if($fk_code==1){
	    $fuel_price[$i]       = $price<$min_value?$min_value:($price<$max_value?$price:$max_value);
	  }else{
	    $other_price[$i]      = $price<$min_value?$min_value:($price<$max_value?$price:$max_value);
	  }
	  unset($max_value,$min_value);
	  $get_result->MoveNext();
	}
	unset($return_price_value);
	$return_price_value['fuel']   = empty($fuel_price)?0:array_sum($fuel_price);
	$return_price_value['other']  = empty($other_price)?0:array_sum($other_price);
	return $return_price_value;
  }
  
/**
*获得运输方式运输最大重量
*function :get_shipping_max_weight()
*参数说明：（物流方式ID  ）
*返回最大重量
*/
  public function get_shipping_max_weight($shipping_id){
    global $db;
	$sql_statement ="SELECT max(weight_end) FROM shipping_freightpricevalue WHERE pr_id='".$shipping_id."'";
	$get_result    = $db->Execute($sql_statement);
	return $get_result->fields['max(weight_end)'];
  }

}

function checking_whether_fee_shipping($product_array,$product_total_weight){
		global $db;
		$total_weight=0;
		if(is_array($product_array)){
			foreach($product_array as $key=>$value){
				$sql_statement    = "select products_weight,product_is_always_free_shipping from ".TABLE_PRODUCTS."  where products_id='".$key."'";
				$get_result       = $db->Execute($sql_statement);
				$product_is_always_free_shipping = $get_result->fields['product_is_always_free_shipping'];
				$products_weight   = $product_is_always_free_shipping==false?$get_result->fields['products_weight']:0;
				$total_weight      = $total_weight+$products_weight*$value['qty'];
			}
		}
		return $total_weight;
}
?>