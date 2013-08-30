<?php
class SOAP_Service_Secure
{
    protected $class_name    = '';
    protected $authenticated = false;

    public function __construct($class_name)
    {
        $this->class_name = $class_name;
    }

    public function AuthHeader($Header)
    {
        if($Header->username == 'xym' && $Header->password == '19871020')
            $this->authenticated = true;
    }

    public function __call($method_name, $arguments)
    {
        if(!method_exists($this->class_name, $method_name)){
        	throw new SoapFault('5','Method Not Found');
        }    
        $this->checkAuth();
        return call_user_func_array(array($this->class_name, $method_name), $arguments);
    }

    protected function checkAuth()
    {
        if(!$this->authenticated){
            throw new SoapFault('0','Authenticate failure!');
        }    
    }

}

?>