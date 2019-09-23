<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class ProductlistAPI extends \Magento\Framework\App\Action\Action
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
    {   //echo "ram..."; die;
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
        $categoryFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');

        $mediaURL = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $mediaURL.'catalog/product';

        //$appState = $objectManager->get('\Magento\Framework\App\State');
        //$appState->setAreaCode('frontend');
        
        // if(isset($_GET['cat_id'])){
        //     $categoryId1 = $_GET['cat_id']; 
        // }else{
        //     $categoryId1 = 2;
        // }

        $categoryId1 = $_GET['cat_id']; // YOUR CATEGORY ID
        $myArray = array();

        if( isset($categoryId1) ){
            $category1 = $categoryFactory->create()->load($categoryId1);
             
            $categoryProducts1 = $category1->getProductCollection()
                                         ->addAttributeToSelect('*');
            $j=0; 
            if(count($categoryProducts1)>0){ 
                $myArray['status'] = 200;
                $myArray['message'] = 'Product List';
                foreach ($categoryProducts1 as $product1) {
                    //echo $product1->getName();
                    //print_r($product->getData());
                    // printing category name and url
                    $myArray['product_list'][$j] = array( 
                                                'id' => $product1->getId(), 
                                                'name' => $product1->getName(), 
                                                'image' => $product1->getData('image'),
                                                'price' => $product1->getPrice() 
                                            );
                    $j++;
                    //$items[$j++] = $product1->getName();
                    //array_push($items1[], $product1->getName());
                    //echo $product1->getName() . ' - ' . $product1->getProductUrl() . '<br />';
                }
            }else{ 
                $myArray['status'] = 400;
                $myArray['message'] = 'Record not found.';
            }
            //echo "<pre> 1"; print_r($myArray); echo "</pre>";
        }else{
            $myArray['status'] = 400;
            $myArray['message'] = 'Record not found.';
        }                           
        //$product_id = $_GET['id']; die;
        //$i=0;
        //$myArray = array();
        //$myArray['status'] = "200";
        //$myArray['message'] = 'Product Detail';
        //$product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);                  
       
        //foreach ($product as $value) {
           /* $myArray['Product_listDetail'] = array( 'id' => $product->getId(), 
                                        'name' => $product->getName(), 
                                        'image' => $product->getData('image'),
                                        'price' => $product->getPrice(), 
                                        'description' => strip_tags($product->getDescription()), 
                                        'short_escription' => strip_tags($product->getShortDescription()) 
                                    );
            $i++;*/
            //print_r($product->getData());
            // printing category name and url
            //echo $product->getName() . ' - ' . $product->getProductUrl() . '<br />';
        //}
        //echo "<pre>"; print_r($myArray); echo "</pre>";
        //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 

        // retrieve quote items collection
        $items = $cart->getQuote()->getAllItems();
        //echo count($items);
        $myArray['CartQTY'] = count($items);
        
        echo json_encode($myArray);
        die;
    }
}