<?php
/**
 * @package admin
 * @license http://www.zen-cart.cn
 * @author Morrowind  
 * @contact 752979972@qq.com / hnsytcg@163.com
 * @version $Id: shipping_4px.php 15881 2011-06-22 16:32:39Z wilt $
 */

class ExpressHawbOrderBean{
	private static $object;
	public $orderNo;
	public $customerOrderNo;
	public $trackingHawbCode;
	public $serviceKind;
	public $paymentMode;
	public $cargoType;
	public $countryCode;
	public $shipperName;
	public $shipperAddress;
	public $shipperCompanyName;
	public $shipperTelephone;
	public $consigneeName;
	public $consigneeAddress1;
	public $consigneeAddress2;
	public $consigneeAddress3;
	public $consigneeAddress4;
	public $consigneeAddress5;
	public $consigneeEMail;
	public $consigneeTelephone;
	public $consigneePostCode;
	public $insuranceType;
	public $insuranceValue;
	public $printSign;
	public $transactionID;
	public $totalPieces;
	public $objDI;
	public $buyeId;
	public function ExpressHawbOrderBean(){
	}
	public static function getObject($OrderNo,$CustomerOrderNo,$TrackingHawbCode,$ServiceKind,
	$PaymentMode,$CargoType,$CountryCode,$ShipperName,$ShipperAddress,$ShipperCompanyName,
	$ShipperTelephone,$ConsigneeName,$ConsigneeAddress1,$ConsigneeAddress2,$ConsigneeAddress3,$ConsigneeAddress4,$ConsigneeAddress5,
	$ConsigneeEMail,$ConsigneeTelephone,$ConsigneePostCode,$InsuranceType,$InsuranceValue,$PrintSign,$TransactionID,$TotalPieces,
	$objDI,$buyeId
	){
		//if(!self::$object){
			self::$object=new ExpressHawbOrderBean();			
		//}
		self::$object->orderNo                 = $OrderNo;
		self::$object->customerOrderNo         = $CustomerOrderNo;
		self::$object->trackingHawbCode        = $TrackingHawbCode;
		self::$object->serviceKind             = $ServiceKind;
		self::$object->paymentMode             = $PaymentMode;
		self::$object->cargoType               = $CargoType;
		self::$object->countryCode             = $CountryCode;
		self::$object->shipperName             = $ShipperName;
		self::$object->shipperAddress          = $ShipperAddress;
		self::$object->shipperCompanyName      = $ShipperCompanyName;
		self::$object->shipperTelephone        = $ShipperTelephone;
		self::$object->consigneeName           = $ConsigneeName;
		self::$object->consigneeAddress1       = $ConsigneeAddress1;
		self::$object->consigneeAddress2       = $ConsigneeAddress2;
		self::$object->consigneeAddress3       = $ConsigneeAddress3;
		self::$object->consigneeAddress4       = $ConsigneeAddress4;
		self::$object->consigneeAddress5       = $ConsigneeAddress5;
		self::$object->consigneeEMail          = $ConsigneeEMail;
		self::$object->consigneeTelephone      = $ConsigneeTelephone;
		self::$object->consigneePostCode       = $ConsigneePostCode;
		self::$object->insuranceType           = $InsuranceType;
		self::$object->insuranceValue          = $InsuranceValue;
		self::$object->printSign               = $PrintSign;
		self::$object->transactionID           = $TransactionID;
		self::$object->totalPieces             = $TotalPieces;
		self::$object->objDI                   = $objDI;
		self::$object->buyeId                  = $buyeId;
		return self::$object;
	}
}

class objDI{
	private static $object;
	public $declareEName;
	public $pieces;
	public $declarePrice;
	public $declareCurrency;
	public $declareCName;
	
	public function objDI(){
	}
	public static function getObject($DeclareEName,$Pieces,$DeclarePrice,$DeclareCurrency,$DeclareCName){
		//if(!self::$object){
			self::$object=new objDI();			
		//}
		self::$object->declareEName           = $DeclareEName;
		self::$object->pieces                 = $Pieces;
		self::$object->declarePrice           = $DeclarePrice;
		self::$object->declareCurrency        = $DeclareCurrency;
		self::$object->declareCName           = $DeclareCName;
		return self::$object;
	}
}


function get_orders_info_mzt($orders_id){//获得订单资料信息
   global $db;
   $sql_statement    = "select * from ".TABLE_ORDERS." where orders_id='".$orders_id."'";
   $get_result       = $db->Execute($sql_statement);
   return $get_result->fields;
}
function get_orders_porducts_mzt($orders_id){//获得某订单的相信产品信息
  global $db;
  $sql_statement    = "select * from ".TABLE_ORDERS_PRODUCTS." where orders_id='".$orders_id."'";
  $get_result       = $db->Execute($sql_statement);
  while(!$get_result->EOF){
    $return_info[]  = $get_result->fields;
	$get_result->MoveNext();
  }
  return $return_info;
}
function get_orders_total_mzt($orders_id){//获得订单总价格信息
  global $db;
  $sql_statement   = "select * from ".TABLE_ORDERS_TOTAL." where orders_id='".$orders_id."'";
  $get_result      = $db->Execute($sql_statement);
  $return_info     = array();
  while(!$get_result->EOF){
    $get_result->fields['class']=='ot_subtotal'?$return_info['ot_subtotal'] = $get_result->fields['value']:null;
	$get_result->fields['class']=='ot_shipping'?$return_info['ot_shipping'] = $get_result->fields['value']:null;
	$get_result->fields['class']=='ot_total'?$return_info['ot_total']       = $get_result->fields['value']:null;
    $get_result->MoveNext();
  }
  return $return_info;
}
function get_billing_country_2code($country_name){//获得订单送货国家2位代码简称
  global $db;
  $get_result_countryCode       = $db->Execute("select countries_iso_code_2 from ".TABLE_COUNTRIES." where countries_name='".$country_name."'");
  return $get_result_countryCode->fields['countries_iso_code_2'];
}
function get_product_en_name($products_id){
  global $db;
  $get_result      = $db->Execute("select master_categories_id from ".TABLE_PRODUCTS." WHERE products_id='".$products_id."'");
  $master_categories_id  = $get_result->fields['master_categories_id'];
  $get_categor_result    = $db->Execute("select categories_name from ".TABLE_CATEGORIES_DESCRIPTION." where categories_id='".$master_categories_id."'  AND language_id=1");
  return $get_categor_result->fields['categories_name'];
}
function handle_orders_products_info($orders_id,$currency){
	$get_orders_products_info     = get_orders_porducts_mzt($orders_id);
	if(empty($get_orders_products_info)) return false;
	foreach($get_orders_products_info as $key=>$value){
	  $DeclareEName               = get_product_en_name($value['products_id']);
	  $de_products_name           = substr($value['products_name'],0,100);
	  $DeclareInvoiceBean[]       = objDI::getObject($DeclareEName,$value['products_quantity'],$value['final_price'],$currency,$de_products_name );
	}
	return $DeclareInvoiceBean;
}
function update_orders_forecast_status($orders_id){
  global $db;
  $sql_data_array = array('send_forecast_status' =>1);
  zen_db_perform(TABLE_ORDERS, $sql_data_array, 'update','id='.$orders_id);
}
function send_forecast_handle($ExpressHawbOrderBean){//通过接口提交预报信息
  $NusoapWSDL                     = SHIPPING_4PX_SOAP_URL;
  $client_company_id              = SHIPPING_4PX_COMPANY_ID;
try{
  $client                         = new SoapClient($NusoapWSDL, array(true));
  $param                          = array('in0'=>$client_company_id,'in1'=>$ExpressHawbOrderBean);
  $result                         = $client->__call('orderRegisterAndPrealertService',array($param));
}catch(SOAPFault $e) {
  print_r($e);
}
    $ReturnValueResult            = $result->out->ReturnValueResult;
	$return_string                ="";
	for($i=0;$i<sizeof($ReturnValueResult);$i++){
	  if(sizeof($ReturnValueResult)==1){
	    $ReturnValue_Result=$ReturnValueResult;
	  }else{
	    $ReturnValue_Result=$ReturnValueResult[$i];
	  }
	  $orderActionState           = $ReturnValue_Result->orderActionState;
	  $customerOrderNo            = $ReturnValue_Result->customerOrderNo;
	  if($orderActionState=='Y'){
	     update_orders_forecast_status($customerOrderNo);
		 $return_string          .= $customerOrderNo.':<b style="color:red;">Success!</b><br />';
	  }else{
	    $failuer_forecast         = $customerOrderNo;   
	    $Returnremark             = $ReturnValue_Result->remark;
		$return_string           .= $failuer_forecast.':<b style="color:red;">'.$Returnremark.'</b><br />';
		$failuer_forecast_array[] = $failuer_forecast;
		
	  }
	}
	$return_info_array           = array('fail_orders_id'=>$failuer_forecast_array,'message'=>$return_string);
	return $return_info_array;
}

function send_forecast_4px($orders_id_array){//发送预报到4px  参数是必须是数组形式：如 function_send_ (1,2,3);
  if(empty($orders_id_array)) return false;
  foreach($orders_id_array as $key=>$id_value){
    $get_orders_info              = get_orders_info_mzt($id_value);
	$get_orders_total_info        = get_orders_total_mzt($id_value);
	
	$OrderNo                      = $get_orders_info['orders_id'];
	$CustomerOrderNo              = $get_orders_info['orders_id'];
	$TrackingHawbCode             = $get_orders_info['orders_id'].$get_orders_info['customers_id'];
	$ServiceKind                  = $get_orders_info['shipping_module_code'];
	$PaymentMode                  = 'ACC';
	$CargoType                    = 'AWPX';
	$CountryCode                  = get_billing_country_2code($get_orders_info['billing_country']);
	$ShipperName                  = STORE_NAME;
	$ShipperAddress               = $ShipperAddress;
	$ShipperCompanyName           = $ShipperCompanyName;
	$ShipperTelephone             = $ShipperTelephone;
	$ConsigneeName                = $get_orders_info['billing_name'];
	$ConsigneeAddress1            = $get_orders_info['billing_street_address'].$get_orders_info['billing_suburb'];
	$ConsigneeAddress2            = $get_orders_info['billing_city'];
	$ConsigneeAddress3            = $get_orders_info['billing_country'];
	$ConsigneeAddress4            = $ConsigneeAddress4;
	$ConsigneeAddress5            = $ConsigneeAddress5;
	$ConsigneeEMail               = $get_orders_info['customers_email_address'];
	$ConsigneeTelephone           = $get_orders_info['billing_phone'];
	$ConsigneePostCode            = $get_orders_info['billing_postcode'];
	$InsuranceType                = $get_orders_total_info['ot_total']<100?'N':'Y';
	$InsuranceValue               = $get_orders_total_info['ot_total'];
	$PrintSign                    = 'Y';
	$TransactionID                = $TransactionID;
	$TotalPieces                  = 1;
	$DeclareInvoiceBean           = handle_orders_products_info($id_value,$get_orders_info['currency']);
	$buyeId                       = $buyeId;
	
	
	$ExpressHawbOrderBean[]     = ExpressHawbOrderBean::getObject($OrderNo,$CustomerOrderNo,$TrackingHawbCode,$ServiceKind,
	  $PaymentMode,$CargoType,$CountryCode,$ShipperName,$ShipperAddress,$ShipperCompanyName,
	  $ShipperTelephone,$ConsigneeName,$ConsigneeAddress1,$ConsigneeAddress2,$ConsigneeAddress3,$ConsigneeAddress4,$ConsigneeAddress5,
	  $ConsigneeEMail,$ConsigneeTelephone,$ConsigneePostCode,$InsuranceType,$InsuranceValue,$PrintSign,$TransactionID,$TotalPieces,
	  $DeclareInvoiceBean,$buyeId
	  );
  }
  $return_info                    = send_forecast_handle($ExpressHawbOrderBean);
  return $return_info;
}
?>