<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class CartlistAPI extends \Magento\Framework\App\Action\Action
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
        $customerEmail = $_GET['email1'];
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

       // $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        
        $customer = $objectManager->create('Magento\Customer\Model\Customer')
                                        ->setWebsiteId(1)
                                        ->loadByEmail($customerEmail);
                                        //->load($customerId);
             
                    $customerSession = $objectManager->create('Magento\Customer\Model\Session');
                    $customerSession->setCustomerAsLoggedIn($customer);
        $myArray = array();

        //if($customerSession->isLoggedIn()) {
    		$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 

    		// retrieve quote items collection
    		//$itemsCollection = $cart->getQuote()->getItemsCollection();

    		// get array of all items what can be display directly
    		//$itemsVisible = $cart->getQuote()->getAllVisibleItems();

    		// retrieve quote items array
    		$items = $cart->getQuote()->getAllItems();
            //$myArray = array();
            //$myArray['status'] = "200";
            //$myArray['message'] = 'Cart List';

            $totalItems = $cart->getQuote()->getItemsCount();
            $totalQuantity = $cart->getQuote()->getItemsQty();

            $i=0;
            $subTotal = 0;
            $saved_price = 0;
            $saved_price1 = 0;
            $aa = array();
            if(count($items) == 0){
            	$myArray['status'] = "400";
            	$myArray['message'] = 'Record not found.'.$customerEmail."end".$customerSession->getId();
            	$myArray['cart_list'] = $aa;
            }else{
            	$myArray['status'] = "200";
            	$myArray['message'] = 'Cart List';
    			foreach($items as $item) {
    			    //  echo 'ID: '.$item->getProductId().'<br />';
    			    //   echo 'Name: '.$item->getName().'<br />';
    			    //    echo 'Sku: '.$item->getSku().'<br />';
    			    //    echo 'Quantity: '.$item->getQty().'<br />';
    			    //   echo 'Price: '.$item->getPrice().'<br />';
    			    // echo "<br />"; 
    	            $product_id = $item->getProductId();
    	            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);

             
                    $allOptions = $item->getProduct()
                                              ->getTypeInstance(true)
                                              ->getOrderOptions($item->getProduct());
                    //echo "<pre>"; 
                    //print_r($allOptions);    

                    foreach ($allOptions as $key => $value1) {
                        //foreach ($value1 as $key => $value) {
                            //echo $value->product;
                            if( !empty( $value1['option_type_id'] ) ){
                                $option_type_id = $value1['option_type_id'];
                            }else{
                                //print_r($value1);
                            }
                        //}
                    }
        


                    foreach ($product->getOptions() as $options) {

                        $optionData = $options->getValues();
                        foreach ($optionData as $data) {
                            //echo "<pre>"; print_r($data->getData());
                            if($data['option_type_id'] == $option_type_id){
                                $optionsPrice = $data['price'];
                            }
                            //$titleArray[] = $data['title'];
                            //echo $optionDuration[] = $data->getTitle();
                        }
                        //$myArray['weight_title'] = $titleArray;
                        //$myArray['weight_price'] = $priceArray;
                    }
    	            
                    if(!empty($optionsPrice)){
                        $itemNewPrice = $optionsPrice;
                        //$newPrice = $item->getQty() * $itemNewPrice;
                    }else{
                        $itemNewPrice =$product->getFinalPrice();
                        //$newPrice = $item->getQty() * $product->getFinalPrice();
                    }

    	            $total =  $item->getQty() * $product->getPrice();
    	            $subTotal =  $subTotal + $total;

    	            $newPrice = $item->getQty() * $itemNewPrice;
    	            $saved_price = $saved_price + $newPrice;
    	            
    	            $saved_price1 = $subTotal - $saved_price;



    	            $myArray['cart_list'][$i] = array( 
    	                                    'id' => $item->getProductId(), 
    	                                    'name' => $item->getName(), 
    	                                    'sku' => $item->getSku(),
    	                                    'qty' => $item->getQty(),
    	                                    'image' => $product->getData('image'),
    	                                    'new_price' => $itemNewPrice, 
    	                                    'old_price' => $product->getPrice(), 
    	                                    'total' => $newPrice, 
    	                                    //'short_escription' => strip_tags($product->getShortDescription()) 
    	                                ); 
    	            $i++;       
    			}
    		}

            if($saved_price1>0){ $tt =  $saved_price1; }else{ $tt = 0; }
            $myArray['saved_price'] = $tt;
            $myArray['subTotal'] = $saved_price;

            //echo "<pre>"; print_r($myArray); echo "</pre>";
            echo json_encode($myArray);
         /*}else{

            $myArray['status'] = "400";
            $myArray['isLoggedIn'] = "No";
            $myArray['message'] = 'Please login again!';
            echo json_encode($myArray);
        }*/


    	//echo "ram..."; 
    	die;
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
        
        $mediaURL = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $mediaURL.'catalog/product';

        //$appState = $objectManager->get('\Magento\Framework\App\State');
        //$appState->setAreaCode('frontend');
        
        $product_id = $_GET['id'];
        $i=0;
        $myArray = array();
        if(isset($product_id)){
            $myArray['status'] = "200";
            $myArray['message'] = 'Product Detail';
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);                  
            if($product->getId()==''){
                $myArray['status'] = "400";
                $myArray['message'] = 'Record not found.';
            }else{
                //foreach ($product as $value) {
                    $myArray['Product_listDetail'] = array( 
                                                'id' => $product->getId(), 
                                                'name' => $product->getName(), 
                                                'image' => $product->getData('image'),
                                                'price' => $product->getPrice(), 
                                                'description' => strip_tags($product->getDescription()), 
                                                'short_escription' => strip_tags($product->getShortDescription()) 
                                            );
                    $i++;
                    //print_r($product->getData());
                    // printing category name and url
                    //echo $product->getName() . ' - ' . $product->getProductUrl() . '<br />';
                //}
                //echo "<pre>"; print_r($myArray); echo "</pre>";
            }
        }else{
            $myArray['status'] = "400";
            $myArray['message'] = 'Record not found.';
        }
        echo json_encode($myArray);
    }
}