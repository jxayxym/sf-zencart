<?php
/**
 *���ܣ�91Hpay����log������
 *��ϸ�����ڶ�����־�Ĵ�ӡ
 *�汾��1.0.0
 *�޸����ڣ�2012.12.20
 '˵����
 '���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 '�ô������ѧϰ���о�91Hpay�ӿ�ʹ�ã�ֻ���ṩһ���ο���
 */
date_default_timezone_set('PRC');
function write_log($msg) {
	if(MODULE_PAYMENT_HPAY_DEBUG==true) {
		error_log(date("[Y-m-d H:i:s]")."\t" .$msg ."\r\n", 3, './logs/91Hpayreturn'.date("Y-m-d").'.log');
	}
	return true;
}
?>
