<?php
include 'configure.php';
require 'class/class.db.php';
require 'class/class.soap_service_secure.php';
require 'class/class.zencart.php';
require 'includes/init_db.php';

$zencart = new zencart();
$zencart_width_secure = new SOAP_Service_Secure($zencart);

$s = new SoapServer(null,array('uri'=>'soap_server.php'));

$s -> setObject($zencart_width_secure);
$s -> handle();