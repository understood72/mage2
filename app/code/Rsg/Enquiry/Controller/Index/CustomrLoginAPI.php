<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class CustomrLoginAPI extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
 
    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
 
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
 
    }
 
    public function execute()
    {   
        //echo $_GET['remail'];
        //echo $_GET['rpass'];
        //die;
        /*
        $ch = curl_init("http://options4u.in/index.php/rest/V1/integration/admin/token");

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CUsRLOPT_POSTFIELDS, json_encode($userData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));
        
        echo $token = curl_exec($ch); 
        */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        // $CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
        // $CustomerModel->setWebsiteId(1); //Here 1 means Store ID**
        // $CustomerModel->loadByEmail($customerEmail);
        // $userId = $CustomerModel->getId();
        // echo "Customer ID: ".$userId;
        //if( !empty($_POST['email']) ){


            // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->get('Magento\Customer\Model\Session');

            if($customerSession->isLoggedIn()) {
                //echo "Ram...";
            	$customerId = $customerSession->getId();
            	$customer = $objectManager->create('Magento\Customer\Model\Customer')
            							->setWebsiteId(1)
            							//->loadByEmail($customerEmail);
            							->load($customerId);
             
                $myArray = array();
                $myArray['isLoggedIn'] = "Yes";
                $myArray['status'] = "200";
                $myArray['message'] = 'Customer Logged in Successfully.';
                $myArray['id'] = $customer->getId();
                $myArray['name'] = $customer->getName();
                $myArray['email'] = $customer->getEmail();
                $myArray['dob'] = $customer->getDob();
                if($customer->getPrimaryBillingAddress()){
                    $phone = $customer->getPrimaryBillingAddress()->getTelephone();
                }else{
                    $phone  =  '' ;
                }
                $myArray['phone'] = $phone;
                if($customer->getGender() == 1){
                    $gender = "Male";
                }else{
                    $gender = "Female";
                }
                $myArray['gender'] = $gender;

                echo json_encode($myArray);

            }else{

            	$customerEmail = trim($_POST['remail']);
        		$customerPassword = trim($_POST['rpass']);
                
                // $customerEmail = trim($_GET["email"]);
                // $customerPassword = trim($_GET["password"]);

                //$customerEmail = "ramshankar5july@gmail.com";
                //$customerPassword = "ram@12345";

                //$userData = array("username" => $customerEmail, "password" => $customerPassword);
                //print_r($userData);

                //API URL
                $url = "http://options4u.in/index.php/rest/V1/integration/customer/token/";

                //create a new cURL resource
                $ch = curl_init($url);
                $data = array();

                //setup request to send json via POST
                $data = array(
                    "username" => $customerEmail,
                    "password" => $customerPassword
                );
                //print_r($data); die();

                /*
                $data = array(
                    "username" => "ramshankar5july@gmail.com",
                    "password" => "ram@12345"
                );
                */
                //$payload = json_encode(array("user" => $data));
                //$payload = json_encode($data);

                //$data = array('username' => 'john@change.me', 'password' => 'abc123');
                $data_string = json_encode($data);

                //$ch = curl_init('http://magento2.ce/rest/V1/integration /customer/token');
                  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );

                //echo $result = curl_exec($ch);

                //attach encoded JSON string to the POST fields
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

                //set the content type to application/json
                //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

                //return response instead of outputting
                //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                //execute the POST request
                $result = curl_exec($ch);

                //close cURL resource
                curl_close($ch);
                //exit;

                if( !empty($result) ){
                    // Create customer session
                    $customer = $objectManager->create('Magento\Customer\Model\Customer')
            							->setWebsiteId(1)
            							->loadByEmail($customerEmail);
            							//->load($customerId);
             
                    $customerSession = $objectManager->create('Magento\Customer\Model\Session');
                    $customerSession->setCustomerAsLoggedIn($customer);
                    $myArray = array();
                    $myArray['status'] = "200";
                    $myArray['isLoggedIn'] = "Yes";
                    $myArray['message'] = 'Customer Logged in Successfully.';
                    $myArray['id'] = $customer->getId();
                    $myArray['name'] = $customer->getName();
                    $myArray['email'] = $customer->getEmail();
                    $myArray['dob'] = $customer->getDob();
                    
                    if($customer->getPrimaryBillingAddress()){
                        $phone = $customer->getPrimaryBillingAddress()->getTelephone();
                    }else{
                        $phone  =  '' ;
                    }
                    $myArray['phone'] = $phone;

                    if($customer->getGender() == 1){
                        $gender = "Male";
                    }else{
                        $gender = "Female";
                    }
                    $myArray['gender'] = $gender;

                    echo json_encode($myArray);
                }else{
                    $myArray = array();
                    $myArray['status'] = "400";
                    $myArray['isLoggedIn'] = "No";
                    $myArray['message'] = 'Invalid username or password';
                    echo json_encode($myArray);
                }
            }
        
        //}
        die;
        if($customerSession->isLoggedIn()) {
            echo "Customer Logged in Successfully";
            echo $customer->getId();
            echo $customer->getName();


            // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            // $customer = $objectManager->create('Magento\Customer\Model\Customer')->load(1);


        }else{
            echo "Unable to Login";
        }

        // $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist'); $wishlist_collection = $wishlist->loadByCustomerId($customer->getId(), true)->getItemCollection();

        // foreach ($wishlist as $key => $value) {
        //     print_r($value->getData());
        // }

        die;
    }
}