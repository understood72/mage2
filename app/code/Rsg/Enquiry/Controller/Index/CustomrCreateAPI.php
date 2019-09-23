<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class CustomrCreateAPI extends \Magento\Framework\App\Action\Action
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

        $email      = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name  = $_POST['last_name'];
        $password   = $_POST['password'];
        $gender     = $_POST['gender'];
        $dob        = $_POST['dob'];
        $myArray    = array();

        //die('ram...');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        //$objectManager = $bootstrap->getObjectManager();
     
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
     
        //$state = $objectManager->get('\Magento\Framework\App\State');
     
        // $state->setAreaCode('frontend');
     
        // Customer Factory to Create Customer
     
        $customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
     
        $websiteId = $storeManager->getWebsite()->getWebsiteId();
     
        //try{
            /**** Instantiate customer and set the customer inforamtion **/
     
            $customer = $customerFactory->create();
     
            $customer->setWebsiteId($websiteId);
     
            //$customer->setEmail('ramshankar5july@gmail.com');
            $customer->setEmail($email);
     
            //$customer->setFirstname('FirstName');
            $customer->setFirstname($first_name);
     
            //$customer->setLastname('LastName');
            $customer->setLastname($last_name);
     
            //$customer->setPassword('12345');
            $customer->setPassword($password);
            
            $customer->setGender($gender);
            
            $customer->setDob($dob);

            $customer->save();
            
            /********Send email to customer********/
            // $customer->sendNewAccountEmail();
            
            /******** See the customer Id*****/
     
            //echo 'Create customer successfully'.$customer->getId();
            
        //}catch(Exception $e){
         //   echo $e->getMessage();
        //}

        $myArray['status'] = "200";
        $myArray['message'] = 'Create customer successfully.';
        
        echo json_encode($myArray);
        die;
        /*
        $customerEmail = "akjs005@gmail.com";
        // $CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
        // $CustomerModel->setWebsiteId(1); //Here 1 means Store ID**
        // $CustomerModel->loadByEmail($customerEmail);
        // $userId = $CustomerModel->getId();
        // echo "Customer ID: ".$userId;

        $customer = $objectManager->create('Magento\Customer\Model\Customer')->setWebsiteId(1)->loadByEmail($customerEmail);

        // Create customer session
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        $customerSession->setCustomerAsLoggedIn($customer);

        if($customerSession->isLoggedIn()) {
            echo "Customer Logged in Successfully";
        }else{
            echo "Unable to Login";
        }

        $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist'); $wishlist_collection = $wishlist->loadByCustomerId($customer->getId(), true)->getItemCollection();

        foreach ($wishlist as $key => $value) {
            print_r($value->getData());
        }
        */

        die;
    }
}