<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
require('vendor/zendframework/zend-server/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client/Common.php');
class CustomerupdateApi extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
       // soap sample
       /*
        * below soap not working
        $request = new  \Zend\Soap\Client("http://localhost/magento2/soap/default?wsdl&services=integrationAdminTokenServiceV1");       
		$token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"admin", "password"=>"admin123"));

		$opts = array(
					'http'=>array(
						'header' => 'Authorization: Bearer '.json_decode($token->result)
					)
				);
		
		*/		
		//Authentication rest API magento2
		$adminUrl='http://127.0.0.1/magento2/index.php/rest/V1/integration/admin/token';
		$ch = curl_init();
		$data = array("username" => "admin", "password" => "admin123");                                                                    
		$data_string = json_encode($data);                       
		$ch = curl_init($adminUrl); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);       
		$token = curl_exec($ch);
		$token=  json_decode($token);
			$customerData = array(
                    'customer' => array(
                        'id' => (int)1,
                        'firstname' => 'Sharma',
                        'lastname' => 'Vaibhav',
                        'storeId' => 1,
                        'websiteId' => 1
                    )
                );      
		// working $wsdlUrl = "http://localhost/magento2/soap/default?wsdl&services=customerCustomerRepositoryV1";
		//$wsdlUrl = "http://localhost/magento2/soap/default?wsdl&services=customerAccountManagementV1";
		$wsdlUrl = "http://localhost/magento2/soap/default?wsdl&services=dckapCustomapiV1";
		$opts = ['http' => ['header' => "Authorization: Bearer ".$token]];
		$context = stream_context_create($opts);		
		$soapClient = new \Zend\Soap\Client($wsdlUrl);
		$soapClient->setSoapVersion(SOAP_1_2);
		$soapClient->setStreamContext($context);		
		// working $result = $soapClient->customerCustomerRepositoryV1GetById(array('customerId' => 1));
		//$result = $soapClient->dckapCustomapiV1Name(array('name' => 'vaibhav'));
		$result = $soapClient->dckapCustomapiV1Name(array('name' => 'vaibhav'));
		//$result = $soapClient->customerAccountManagementV1GetList($customerData);
		// http://localhost/magento2/soap/default?wsdl&services=dckapCustomapiV1	
		//$wsdlUrl = 'http://localhost/magento2sample/soap/default?wsdl&services=serviceName';
		
		echo "<pre>"; print_r($result); 
		
    }
}

