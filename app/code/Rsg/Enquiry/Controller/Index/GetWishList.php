<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
//use Magento\Wishlist\Model\Wishlist;
use Magento\Framework\View\Result\PageFactory;

class GetWishList extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    
    private $wishlist;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
        //Wishlist $wishlist
 
    ) {
        //$this->wishlist = $wishlist;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
 
    }
 
    public function execute()
    {   

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');

        $myArray = array();
        
        if($customerSession->isLoggedIn()) {
            $myArray['status'] = "200";
            $myArray['isLoggedIn'] = "Yes";
            $myArray['message'] = 'Wish List';

            $customer_id = $customerSession->getCustomer()->getId();
            //$wishlist_collection = $objectManager->wishlist->loadByCustomerId($customer_id, true)->getItemCollection();

            //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist');
            $wishlist_collection = $wishlist->loadByCustomerId($customer_id, true)->getItemCollection(); 

            $i=0;
            $wish_list = array();
            if( count($wishlist_collection) == 0 ){
                $wish_list = array();
            }else{
                foreach ($wishlist_collection as $item) {
                   // $wishlistItems = array();
                    //$wishlistItems[]
                    
                    $myArray['wish_list'][$i] =array( 
                                        'id' => $item->getProduct()->getId(), 
                                        'name' => $item->getProduct()->getName(),
                                        'image' => $item->getProduct()->getData('image'),
                                        'new_price' => $item->getProduct()->getFinalPrice(), 
                                        'old_price' => $item->getProduct()->getPice(), 
                                        'short_escription' => $item->getProduct()->getShortDiscription()
                                    ); 
                    //$wish_list['id']= $item->getProduct()->getId();
                    //$wish_list['name']= $item->getProduct()->getName();
                    //$wish_list['image']= $item->getProduct()->getData('image');
                    //$wish_list['new_price']= $item->getProduct()->getFinalPrice();
                    //$wish_list['old_price']= $item->getProduct()->getPice();
                    //$wish_list['short_discrtion']= $item->getProduct()->getShortDiscription();

                    //print_r($item->getProduct()->getName());
                    $i++;
                }
            }
            //$myArray['wish_list']=  $wish_list;
            echo json_encode($myArray);
        }else{
            $myArray['status'] = "400";
            $myArray['isLoggedIn'] = "No";
            $myArray['message'] = 'Please login again.';
            echo json_encode($myArray);
        }

        die();
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