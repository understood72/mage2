<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class OrderCreateAPI extends \Magento\Framework\App\Action\Action
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
        //use Magento\Framework\App\Bootstrap;
 
/**
 * If your external file is in root folder
 */
//require __DIR__ . '/app/bootstrap.php';
 
/**
 * If your external file is NOT in root folder
 * Let's suppose, your file is inside a folder named 'xyz'
 *
 * And, let's suppose, your root directory path is
 * /var/www/html/magento2
 */
// $rootDirectoryPath = '/var/www/html/magento2';
// require $rootDirectoryPath . '/app/bootstrap.php';
 
//$params = $_SERVER;
 
//$bootstrap = Bootstrap::create(BP, $params);
 
$om = \Magento\Framework\App\ObjectManager::getInstance();
$customerSession    = $om->get('Magento\Customer\Model\Session');

$myArray = array(); 

if($customerSession->isLoggedIn()) {
    $customerId = $customerSession->getId(); 
    $customer = $om->create('Magento\Customer\Model\Customer')
                    ->setWebsiteId(1)
                    //->loadByEmail($customerEmail);
                    ->load($customerId); 

$street = $customer->getPrimaryBillingAddress()->getStreet();
//echo $street[0]; 
//echo $customer->getPrimaryBillingAddress()->getRegionId(); 
//echo $customer->getPrimaryBillingAddress()->getRegion();
//$obj = $bootstrap->getObjectManager();
 
//$state = $obj->get('Magento\Framework\App\State');
//$state->setAreaCode('frontend');
 
//$om = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $om->get('Psr\Log\LoggerInterface');
$storeManager->info('Magecomp Log');
 
$storeManager=$om->get('Magento\Store\Model\StoreManagerInterface');
$product=$om->get('Magento\Catalog\Model\Product');
$quote=$om->get('Magento\Quote\Model\QuoteFactory');
$quoteManagement=$om->get('Magento\Quote\Model\QuoteManagement');
$customerFactory=$om->get('Magento\Customer\Model\CustomerFactory');
$customerRepository=$om->get('Magento\Customer\Api\CustomerRepositoryInterface');
$orderService=$om->get('Magento\Sales\Model\Service\OrderService');
$cart=$om->get('Magento\Checkout\Model\Cart');
$productFactory=$om->get('Magento\Catalog\Model\ProductFactory');
$cartRepositoryInterface = $om->get('Magento\Quote\Api\CartRepositoryInterface');
$cartManagementInterface = $om->get('Magento\Quote\Api\CartManagementInterface');
 
/*
$orderData =[
    'currency_id'  => 'USD',
    'email'        => 'test.magecomp@gmail.com', //buyer email id
    'shipping_address' =>[
        'firstname'    => 'John', //address Details
        'lastname'     => 'Deo',
        'street' => 'Main Street',
        'city' => 'Pheonix',
        'country_id' => 'US',
        'region' => 'Arizona',
        'postcode' => '85001',
        'telephone' => '823322565',
        'fax' => '3245845623',
        'save_in_address_book' => 1
    ],
    'items'=> [
        //array of product which order you want to create
        ['product_id'=>'1','qty'=>2],
        ['product_id'=>'5','qty'=>2]
    ]
];
*/

$cart = $om->get('\Magento\Checkout\Model\Cart');
$items = $cart->getQuote()->getAllItems();
if(count($items) == 0){
    $myArray['status'] = "400";
    $myArray['message'] = 'Record not found.';
    echo "blank;";
}else{
    foreach($items as $item) {
        $product_id = $item->getProductId();
        $product_qty = $item->getQty();
    }
}

$orderData =[
        'currency_id'  => 'INR',
        //'email'        => 'ramshankar5july@gmail.cobjectManager', //buyer email id
        'email'        => $customer->getEmail(), //buyer email id
        'shipping_address' =>[
            'firstname'    => $customer->getPrimaryBillingAddress()->getFirstname(), //'Ram', //address Details
            'lastname'     => $customer->getPrimaryBillingAddress()->getLastname(),  //'Gupta',
            'street' => $street[0], //'Main Street',
            'city' => $customer->getPrimaryBillingAddress()->getCity(),  //'Pheonix',
            'country_id' => $customer->getPrimaryBillingAddress()->getCountryId(), //'IN',
            'region' => $customer->getPrimaryBillingAddress()->getRegion(),   //'UP',
            'postcode' => $customer->getPrimaryBillingAddress()->getPostcode(), //'201301',
            'telephone' => $customer->getPrimaryBillingAddress()->getTelephone(), //'9540503081',
            'fax' => $customer->getPrimaryBillingAddress()->getTelephone(),       //'45454545',
            'save_in_address_book' => 1
        ],
        'items'=> [
            //array of product which order you want to create
            ['product_id'=> $product_id,
            'qty'=> $product_qty],
           // ['product_id'=>'5','qty'=>2]
        ]
    ];
 
$store=$storeManager->getStore();
$websiteId =$storeManager->getStore()->getWebsiteId();
$customer=$customerFactory->create();
$customer->setWebsiteId($websiteId);
$customer->loadByEmail($orderData['email']);// load customet by email address
if(!$customer->getEntityId()){
    //If not avilable then create this customer
    $customer->setWebsiteId($websiteId)
        ->setStore($store)
        ->setFirstname($orderData['shipping_address']['firstname'])
        ->setLastname($orderData['shipping_address']['lastname'])
        ->setEmail($orderData['email'])
        ->setPassword($orderData['email']);
    $customer->save();
}
$cart_id = $cartManagementInterface->createEmptyCart();
$cart = $cartRepositoryInterface->get($cart_id);
 
$cart->setStore($store);
 
// if you have already had the buyer id, you can load customer directly
$customer= $customerRepository->getById($customer->getEntityId());
$cart->setCurrency();
$cart->assignCustomer($customer); //Assign quote to customer
 
//add items in quote
foreach($orderData['items'] as $item){
    $product = $productFactory->create()->load($item['product_id']);
    $cart->addProduct(
        $product,
        intval($item['qty'])
    );
}
 
//Set Address to quote
//$quote->getBillingAddress()->addData($orderData['shipping_address']);
$cart->getBillingAddress()->addData($orderData['shipping_address']);
//$quote->getShippingAddress()->addData($orderData['shipping_address']);
$cart->getShippingAddress()->addData($orderData['shipping_address']);
 
/*$this->shippingRate
    ->setCode('freeshipping_freeshipping')
    ->getPrice(1);
*/
$shippingAddress = $cart->getShippingAddress();
 
$shippingAddress->setCollectShippingRates(true)
    ->collectShippingRates()
    ->setShippingMethod('freeshipping_freeshipping'); //shipping method
 
$cart->setPaymentMethod('cashondelivery'); //payment method
 
$cart->setInventoryProcessed(false);
 
// Set sales order payment
$cart->getPayment()->importData(['method' => 'cashondelivery']);
 
// Collect total and save
$cart->collectTotals();
 
// Submit the quote and create the order
$cart->save();
$cart = $cartRepositoryInterface->get($cart->getId());
$order_id = $cartManagementInterface->placeOrder($cart->getId());
 
//echo "Orde Created";
    //echo "Order Id: ".$order_id." Order Created";
            $myArray['status'] = "200";
            $myArray['isLoggedIn'] = "Yes";
            $myArray['message'] = "Order id: ".$order_id." created successfully";
            foreach($items as $item) {
                $item->delete();
            }
            echo json_encode($myArray);
        }else{           
            $myArray['status'] = "400";
            $myArray['isLoggedIn'] = "No";
            $myArray['message'] = 'Please login again!';
            echo json_encode($myArray);
        }  

        die;






        $objectManager      = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession    = $objectManager->get('Magento\Customer\Model\Session');

        $myArray = array();

        if($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getId(); 
            $customer = $objectManager->create('Magento\Customer\Model\Customer')
                                        ->setWebsiteId(1)
                                        //->loadByEmail($customerEmail);
                                        ->load($customerId);

            //echo $customer->getEmail();
            //echo $customer->getPrimaryBillingAddress()->getPostcode(); 
            $street = $customer->getPrimaryBillingAddress()->getStreet(); 
            //echo $street[0];
            //$custobjectManagererEmail11 = $_POST['email'];
            //use Magento\Framework\App\Bootstrap;
             
            /**
             * If your external file is in root folder
             */
            // require __DIR__ . '/app/bootstrap.php';
             
            /**
             * If your external file is NOT in root folder
             * Let's suppose, your file is inside a folder named 'xyz'
             *
             * And, let's suppose, your root directory path is
             * /var/www/html/magento2
             */
            // $rootDirectoryPath = '/var/www/html/magento2';
            // require $rootDirectoryPath . '/app/bootstrap.php';
             
            //$params = $_SERVER;
             
            //$bootstrap = Bootstrap::create(BP, $params);
             
            //$obj = $bootstrap->getObjectManager();
             
            //$state = $obj->get('Magento\Framework\App\State');
            //$state->setAreaCode('frontend');
             
           
            $storeManager = $objectManager->get('Psr\Log\LoggerInterface');
            $storeManager->info('MagecobjectManagerp Log');
             
            $storeManager=$objectManager->get('Magento\Store\Model\StoreManagerInterface');
            $product=$objectManager->get('Magento\Catalog\Model\Product');
            $quote=$objectManager->get('Magento\Quote\Model\QuoteFactory');
            $quoteManagement=$objectManager->get('Magento\Quote\Model\QuoteManagement');
            $custobjectManagererFactory=$objectManager->get('Magento\CustobjectManagerer\Model\CustobjectManagererFactory');
            $custobjectManagererRepository=$objectManager->get('Magento\CustobjectManagerer\Api\CustobjectManagererRepositoryInterface');
            $orderService=$objectManager->get('Magento\Sales\Model\Service\OrderService');
            $cart=$objectManager->get('Magento\Checkout\Model\Cart');
            $productFactory=$objectManager->get('Magento\Catalog\Model\ProductFactory');
            $cartRepositoryInterface = $objectManager->get('Magento\Quote\Api\CartRepositoryInterface');
            $cartManagementInterface = $objectManager->get('Magento\Quote\Api\CartManagementInterface');
             
            $orderData =[
                'currency_id'  => 'INR',
                //'email'        => 'ramshankar5july@gmail.cobjectManager', //buyer email id
                'email'        => $customer->getEmail(), //buyer email id
                'shipping_address' =>[
                    'firstname'    => $customer->getPrimaryBillingAddress()->getFirstname(), //'Ram', //address Details
                    'lastname'     => $customer->getPrimaryBillingAddress()->getLastname(),  //'Gupta',
                    'street' => $street[0], //'Main Street',
                    'city' => $customer->getPrimaryBillingAddress()->getCity(),  //'Pheonix',
                    'country_id' => $customer->getPrimaryBillingAddress()->getCountryId(), //'IN',
                    'region' => $customer->getPrimaryBillingAddress()->getRegionId(),   //'UP',
                    'postcode' => $customer->getPrimaryBillingAddress()->getPostcode(), //'201301',
                    'telephone' => $customer->getPrimaryBillingAddress()->getTelephone(), //'9540503081',
                    'fax' => $customer->getPrimaryBillingAddress()->getTelephone(),       //'45454545',
                    'save_in_address_book' => 1
                ],
                'items'=> [
                    //array of product which order you want to create
                    ['product_id'=>'115','qty'=>1],
                   // ['product_id'=>'5','qty'=>2]
                ]
            ];
             
            $store=$storeManager->getStore();
            $websiteId =$storeManager->getStore()->getWebsiteId();
            $custobjectManagerer=$custobjectManagererFactory->create();
            $custobjectManagerer->setWebsiteId($websiteId);
            $custobjectManagerer->loadByEmail($orderData['email']);// load custobjectManageret by email address

            if(!$custobjectManagerer->getEntityId()){
                //If not avilable then create this custobjectManagerer
                $custobjectManagerer->setWebsiteId($websiteId)
                    ->setStore($store)
                    ->setFirstname($orderData['shipping_address']['firstname'])
                    ->setLastname($orderData['shipping_address']['lastname'])
                    ->setEmail($orderData['email'])
                    ->setPassword($orderData['email']);
                $custobjectManagerer->save();
            }

            $cart_id = $cartManagementInterface->createEmptyCart();
            $cart = $cartRepositoryInterface->get($cart_id);
             
            $cart->setStore($store);
             
            // if you have already had the buyer id, you can load custobjectManagerer directly
            $custobjectManagerer= $custobjectManagererRepository->getById($custobjectManagerer->getEntityId());
            $cart->setCurrency();
            $cart->assignCustobjectManagerer($custobjectManagerer); //Assign quote to custobjectManagerer
             
            //add items in quote
            foreach($orderData['items'] as $item){
                $product = $productFactory->create()->load($item['product_id']);
                $cart->addProduct(
                    $product,
                    intval($item['qty'])
                );
            }
             
            //Set Address to quote
            //$quote->getBillingAddress()->addData($orderData['shipping_address']);
            $cart->getBillingAddress()->addData($orderData['shipping_address']);
            //$quote->getShippingAddress()->addData($orderData['shipping_address']);
            $cart->getShippingAddress()->addData($orderData['shipping_address']);
             
            /*$this->shippingRate
                ->setCode('freeshipping_freeshipping')
                ->getPrice(1);
            */
            $shippingAddress = $cart->getShippingAddress();
             
            $shippingAddress->setCollectShippingRates(true)
                ->collectShippingRates()
                ->setShippingMethod('freeshipping_freeshipping'); //shipping method
             
            $cart->setPaymentMethod('cashondelivery'); //payment method
             
            $cart->setInventoryProcessed(false);
             
            // Set sales order payment
            $cart->getPayment()->importData(['method' => 'cashondelivery']);
             
            // Collect total and save
            $cart->collectTotals();
             
            // Submit the quote and create the order
            $cart->save();
            $cart = $cartRepositoryInterface->get($cart->getId());
            $order_id = $cartManagementInterface->placeOrder($cart->getId());
             
            //echo "Order Id: ".$order_id." Order Created";
            $myArray['status'] = "200";
            $myArray['isLoggedIn'] = "Yes";
            $myArray['message'] = "Order id: ".$order_id." created successfully";
        }else{           
            $myArray['status'] = "400";
            $myArray['isLoggedIn'] = "No";
            $myArray['message'] = 'Please login again!';
            echo json_encode($myArray);
        }   

        /*
        die('ram...');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $custobjectManagererEmail = "akjs005@gmail.cobjectManager";
        // $CustobjectManagererModel = $objectManager->create('Magento\CustobjectManagerer\Model\CustobjectManagerer');
        // $CustobjectManagererModel->setWebsiteId(1); //Here 1 means Store ID**
        // $CustobjectManagererModel->loadByEmail($custobjectManagererEmail);
        // $userId = $CustobjectManagererModel->getId();
        // echo "CustobjectManagerer ID: ".$userId;

        $custobjectManagerer = $objectManager->create('Magento\CustobjectManagerer\Model\CustobjectManagerer')->setWebsiteId(1)->loadByEmail($custobjectManagererEmail);

        // Create custobjectManagerer session
        $custobjectManagererSession = $objectManager->create('Magento\CustobjectManagerer\Model\Session');
        $custobjectManagererSession->setCustobjectManagererAsLoggedIn($custobjectManagerer);

        if($custobjectManagererSession->isLoggedIn()) {
            echo "CustobjectManagerer Logged in Successfully";
        }else{
            echo "Unable to Login";
        }

        $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist'); $wishlist_collection = $wishlist->loadByCustobjectManagererId($custobjectManagerer->getId(), true)->getItemCollection();

        foreach ($wishlist as $key => $value) {
            print_r($value->getData());
        }
        */

        die;
    }
}