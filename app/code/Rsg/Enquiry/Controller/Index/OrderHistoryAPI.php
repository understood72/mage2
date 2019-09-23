<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class OrderHistoryAPI extends \Magento\Framework\App\Action\Action
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

        /*
        $orderid = 2;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderid);
         
        //fetch whole order information
        print_r($order->getData());
         
        //Or fetch specific information
        echo $order->IncrementId();
        echo $order->getGrandTotal();
        echo $order->getSubtotal();

        */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        $myArray = array();

        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        if($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getId(); 
            $myArray['status'] = "200";
            $myArray['isLoggedIn'] = "Yes";
            $myArray['message'] = 'Order History List';

            //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $lastyear = date('Y-m-d', strtotime("-1 year"));
            $orderCollection = $objectManager->create('\Magento\Sales\Model\ResourceModel\Order\Collection');
            $orderCollection->addAttributeToFilter('customer_id',$customerId)
                        //->addAttributeToFilter('status','complete')
                        //->addAttributeToFilter('created_at', array('gteq'  => $lastyear))
                        ->load();
            $i=0;             
            foreach ($orderCollection->getData() as $key => $value) {
                $myArray['order_list'][$i] = array(
                                            'id'                => $value['entity_id'], 
                                            //'product_name'    => $value['entity_id'], 
                                            'total_price'       => $value['grand_total'], 
                                            'status'            => $value['status'], 
                                            'total_quantity'    => $value['total_qty_ordered'], 
                                            );
                //echo $value['entity_id'];
                //echo $value['status'];
                //echo $value['grand_total'];
                //echo $value['total_qty_ordered'];
                $i++;
            }


            echo json_encode($myArray);
            //echo "<pre>";print_r($orderCollection->getData()); 
            exit;
        }else{
            $myArray['status'] = "400";
            $myArray['isLoggedIn'] = "No";
            $myArray['message'] = 'Please login again.';
            echo json_encode($myArray);
        }

        die;
        $orderid = 4;
         
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderid);
         
        $myArray = array();
        $myArray['status'] = "200";

        //if($customerSession->isLoggedIn()) {
            $myArray['isLoggedIn'] = "Yes";
            $myArray['message'] = 'Order History List';
            

            //Loop through each item and fetch data
            $i=0;
            foreach ($order->getAllItems() as $item)
            {
                //fetch whole item information
                echo "<pre>"; print_r($item->getData());
                $myArray[$i]['order_list']['id'] = $item->getId();
                $myArray[$i]['order_list']['name'] = $item->getName();
                $myArray[$i]['order_list']['image'] = $item->getData('image');
                $myArray[$i]['order_list']['total_price'] = $item->getPrice();
                $myArray[$i]['order_list']['quantity'] = $item->getQtyOrdered();
                $myArray[$i]['order_list']['status'] = "pending";
                //Or fetch specific item information
                //echo $item->getId();
                //echo $item->getProductType();
                //echo $item->getQtyOrdered();
                //echo $item->getPrice(); 
                $i++;
            }

            echo json_encode($myArray);
        //}else{
        //    $myArray['isLoggedIn'] = "No";
        //    $myArray['message'] = 'Please login again.';
        //    echo json_encode($myArray);
        //}
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