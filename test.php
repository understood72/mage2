<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('vendor/zendframework/zend-server/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client/Common.php');
$wsdlurl = 'http://localhost/magento2/soap/default?wsdl&services=dckapCustomapiV1';
$token = '5o17lavmorx6kulnr8320a5ph9ugf8bs';
$opts = ['http' => ['header' => "Authorization: Bearer ".$token]];
$context = stream_context_create($opts);
$soapClient = new \Zend\Soap\Client($wsdlurl);
$soapClient->setSoapVersion(SOAP_1_2);
$soapClient->setStreamContext($context);
$result = $soapClient->dckapCustomapiV1Name(array("name"=>"Sathishraj"));//array('searchCriteria' => $serviceArgs));
echo "<pre>"; print_r($result); 
?>
