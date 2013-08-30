<?php
/**
 *功能：91Hpay公共log函数库
 *详细：用于订单日志的打印
 *版本：1.0.0
 *修改日期：2012.12.20
 '说明：
 '以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 '该代码仅供学习和研究91Hpay接口使用，只是提供一个参考。
 */
date_default_timezone_set('PRC');
function write_log($msg) {
	if(MODULE_PAYMENT_HPAY_DEBUG==true) {
		error_log(date("[Y-m-d H:i:s]")."\t" .$msg ."\r\n", 3, './logs/91Hpayreturn'.date("Y-m-d").'.log');
	}
	return true;
}
?>
