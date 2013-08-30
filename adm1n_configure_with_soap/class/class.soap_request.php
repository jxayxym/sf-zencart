<?php
class Soap_Request extends SoapClient{
	
	function __construct($uri='',$location=''){
		parent::__construct(null,
							array(
								'location'=>$location,
								'uri'=>$uri,
								'compression'=>'',
								'connection_timeout'=>5,
// 								'trace'=>1,
// 								'encoding'=>'utf-8'	
								)
							);
	}
	
}