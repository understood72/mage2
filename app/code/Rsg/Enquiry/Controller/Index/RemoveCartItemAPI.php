<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class RemoveCartItemAPI extends \Magento\Framework\App\Action\Action
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
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        $items = $cart->getQuote()->getAllItems();
        $item_id = $_GET['product_id'];
        foreach($items as $item) {
            
            $itemId = $item->getItemId();//item id of particular item
            $productId = $item->getProductId();//item id of particular item
            if( $item_id == $productId){
                //$quoteItem=$this->getItemModel()->load($itemId);
                //load particular item which you want to delete by his item id
                $item->delete();//deletes the item
                echo "id = ".$item_id; 
            }
        }

        $myArray['status'] = "200";
        $myArray['message'] = "Cart item removed sucessfully!";
        echo json_encode($myArray);
        /*
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 

		// retrieve quote items collection
		$itemsCollection = $cart->getQuote()->getItemsCollection();

		// get array of all items what can be display directly
		$itemsVisible = $cart->getQuote()->getAllVisibleItems();

		// retrieve quote items array
		 $items = $cart->getQuote()->getAllItems();

		foreach($items as $item) {
		     echo 'ID: '.$item->getProductId().'<br />';
		      echo 'Name: '.$item->getName().'<br />';
		       echo 'Sku: '.$item->getSku().'<br />';
		       echo 'Quantity: '.$item->getQty().'<br />';
		      echo 'Price: '.$item->getPrice().'<br />';
		    echo "<br />";            
		  }
        */

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