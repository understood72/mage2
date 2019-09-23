<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class AddWishList extends \Magento\Framework\App\Action\Action
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

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        //$customerEmail = 'ramshankar5july@gmail.com';

        //$customer = $objectManager->create('Magento\Customer\Model\Customer')->setWebsiteId(1)->loadByEmail($customerEmail);

        //$customerSession = $objectManager->create('Magento\Customer\Model\Session');
        //$customerSession->setCustomerAsLoggedIn($customer);

        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        if($customerSession->isLoggedIn()) {
            
            $product_id = 115;
            $customer_id = $customerSession->getId();
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
            
            $wishlist = $objectManager->_wishlistRepository->create()->loadByCustomerId('customer_id', true);

            $wishlist->addNewItem($product);
            $wishlist->save();

            echo "Add product to wishlist Successfully";

            //get wishlist
            /*
            $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist'); 
            $wishlist_collection = $wishlist->loadByCustomerId($customer->getId(), true)->getItemCollection();

            foreach ($wishlist as $key => $value) {
                print_r($value->getData());
            } */

            //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            //$wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist');
            //$wishlist_collection = $wishlist->loadByCustomerId("customer_id", true)->getItemCollection();


                
        }else{
            $myArray = array();
                    $myArray['status'] = "200";
                    $myArray['isLoggedIn'] = "No";
                    $myArray['message'] = 'Invalid username or password';
        }

        die('ram...');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

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

        die;
    }
}