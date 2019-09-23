<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class CustomrUpdateAddressAPI extends \Magento\Framework\App\Action\Action
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

        $state      =   $_POST['state'];
        $city       =   $_POST['city'];
        //$_POST['first_name'];
        //$_POST['first_name'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        //$customerEmail = "akjs005@gmail.com";
        
        // $CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
        // $CustomerModel->setWebsiteId(1); //Here 1 means Store ID**
        // $CustomerModel->loadByEmail($customerEmail);
        // $userId = $CustomerModel->getId();
        // echo "Customer ID: ".$userId;

        //$customer = $objectManager->create('Magento\Customer\Model\Customer')->setWebsiteId(1)->loadByEmail($customerEmail);

        // Create customer session
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        //$customerSession->setCustomerAsLoggedIn($customer);
        
        $myArray = array();

        if($customerSession->isLoggedIn()) {
            //echo "Customer Logged in Successfully";
            $customerID     =   $customerSession->getId();
            //print_r($customerSession->getData()); 

            $customerObj = $objectManager->get('Magento\Customer\Model\Customer')
            ->load($customerID);
            echo $customerName = $customerObj->getName();
            //echo $customerEmail1 = $customerObj->getEmail();
            $customerObj->setFirstName('test');
            $customerObj->save();
            die;

            /*
            //$billingAddressId =  $customerSession->getCustomer()->getDefaultBilling();

            $addresss = $objectManager->get('\Magento\Customer\Model\AddressFactory');
    
            $address = $addresss->create();
             
            $address->setCustomerId($customerSession->getId())
             
            ->setFirstname("FirstName")
             
            ->setLastname("LastName")
             
            ->setCountryId("IN")

            ->setRegionId('UP')
             
            ->setPostcode("201301")
             
            ->setCity("Noida")
             
            ->setTelephone(1234567890)
             
            ->setFax(123456789)
             
            ->setCompany("Company")
             
            ->setStreet("Street")
             
            ->setIsDefaultBilling('1')
             
            ->setIsDefaultShipping('1')
             
            ->setSaveInAddressBook('1');
             
            $address->save();

            $myArray['isLoggedIn'] = "Yes";
            $myArray['status'] = "200";
            $myArray['message'] = 'Address updated successfully.';
            echo json_encode($myArray);
            */
        }else{
            $myArray['isLoggedIn'] = "";
            $myArray['status'] = "400";
            $myArray['message'] = 'Please login again.';
            echo json_encode($myArray);
        }

        /*
        $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist'); $wishlist_collection = $wishlist->loadByCustomerId($customer->getId(), true)->getItemCollection();

        foreach ($wishlist as $key => $value) {
            print_r($value->getData());
        }
        */
        die;
    }
}