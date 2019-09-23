<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class HomeAPI extends \Magento\Framework\App\Action\Action
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
        
        $mediaURL = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $mediaURL.'catalog/category/';

        //$appState = $objectManager->get('\Magento\Framework\App\State');
        //$appState->setAreaCode('frontend');
         
        $categoryFactory = $objectManager->create('\Magento\Catalog\Model\CategoryFactory');
        //$categoryHelper = $objectManager->get('\Magento\Catalog\Helper\Category');
        //$categoryRepository = $objectManager->get('\Magento\Catalog\Model\CategoryRepository');
         
        $categoryId1 = 24; // YOUR CATEGORY ID
        $category1 = $categoryFactory->create()->load($categoryId1);
         
        $categoryProducts1 = $category1->getProductCollection()
                                     ->addAttributeToSelect('*');
        
        $myArray = array();
        $myArray['status'] = "200";
        $myArray['message'] = 'home page listing';
        $j=0; 
        foreach ($categoryProducts1 as $product1) {
            //echo $product1->getName();
            //print_r($product->getData());
            // printing category name and url
            $myArray['new_product'][$j] = array( 
                                        'id' => $product1->getId(), 
                                        'name' => $product1->getName(), 
                                        'image' => $product1->getData('image'),
                                        'old_price' => $product1->getPrice(), 
                                        'new_price' => $product1->getFinalPrice() 
                                    );
            $j++;
            //$items[$j++] = $product1->getName();
            //array_push($items1[], $product1->getName());
            //echo $product1->getName() . ' - ' . $product1->getProductUrl() . '<br />';
        }
        //echo "<pre> 1"; print_r($myArray); echo "</pre>"; die;

        $categoryId2 = 113; // YOUR CATEGORY ID
        $category2 = $categoryFactory->create()->load($categoryId2);
         
        $categoryProducts2 = $category2->getProductCollection()
                                     ->addAttributeToSelect('*');
        $i=0;                             
        foreach ($categoryProducts2 as $product2) {
            $myArray['best_seller'][$i] = array( 
                                        'id' => $product2->getId(), 
                                        'name' => $product2->getName(), 
                                        'image' => $product2->getData('image'),
                                        'old_price' => $product2->getPrice(), 
                                        'new_price' => $product2->getFinalPrice() 
                                    );
            $i++;
            //print_r($product->getData());
            // printing category name and url
            //echo $product->getName() . ' - ' . $product->getProductUrl() . '<br />';
        }
        //echo "<pre> 2"; print_r($myArray); echo "</pre>";


        $categoryId3 = 112; // YOUR CATEGORY ID
        $category3 = $categoryFactory->create()->load($categoryId3);
         
        $categoryProducts3 = $category3->getProductCollection()
                                     ->addAttributeToSelect('*');
        $k=0;                             
        foreach ($categoryProducts3 as $product3) {
            $myArray['Most_Popular'][$k] = array( 
                                        'id' => $product3->getId(), 
                                        'name' => $product3->getName(), 
                                        'image' => $product3->getData('image'),
                                        'old_price' => $product3->getPrice(), 
                                        'new_price' => $product3->getFinalPrice() 
                                    );
            $k++;
            //print_r($product->getData());
            // printing category name and url
            //echo $product->getName() . ' - ' . $product->getProductUrl() . '<br />';
        }
        //echo "<pre> 3"; print_r($myArray); echo "</pre>";
        //echo json_encode($myArray);

        $categoryId4 = 110; // YOUR CATEGORY ID
        $category4 = $categoryFactory->create()->load($categoryId4);
         
        $categoryProducts4 = $category4->getProductCollection()
                                     ->addAttributeToSelect('*');        
        $l=0;                             
        foreach ($categoryProducts4 as $product4) {
            $myArray['Hot_Product'][$l] = array( 
                                        'id' => $product4->getId(), 
                                        'name' => $product4->getName(), 
                                        'image' => $product4->getData('image'),
                                        'old_price' => $product4->getPrice(), 
                                        'new_price' => $product4->getFinalPrice() 
                                    );
            $l++;
            //print_r($product->getData());
            // printing category name and url
            //echo $product->getName() . ' - ' . $product->getProductUrl() . '<br />';
        }

        /*
        $categoryId = 3;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $category = $objectManager->create('Magento\Catalog\Model\Category')
        ->load($categoryId);
        //echo $category->getName();
        
        $myArray['MainCatList'] = array( 
                        'id' => $category->getId(), 
                        'name' => $category->getName(), 
                        'image' => $category->getData('image'),
                        //'description' => strip_tags($category->getDescription())
                    );

        //echo "<pre>"; print_r($myArray); echo "</pre>";
        */
        $catId = 3;  //Parent Category ID            
    	$subcategory = $objectManager->create('Magento\Catalog\Model\Category')->load($catId);
        $subCats = $subcategory->getChildrenCategories();
        //$_helper = $this->helper('Magento\Catalog\Helper\Output');
        $i=0;
        
        $myArray['status'] = "200";
        $myArray['message'] = 'category list';
        foreach ($subCats as $subcat) {
            $_category = $objectManager->create('Magento\Catalog\Model\Category')->load($subcat->getId());
            
            //$_imgHtml = '';
            //echo $_category->getImageUrl();
            // if ($_imgUrl = $_category->getImageUrl()) {
            //     $_imgHtml = '<img src="' . $_imgUrl . '" />';
            //     $_imgHtml = $_helper->categoryAttribute($_category, $_imgHtml, 'image');
            // }  
            // echo $_imgHtml;
            //echo $subcat->getId(); 
            //echo "<--->";
            //echo $subcat->getName(); 
            //echo "<--->";
            //echo $subcat->getData('image'); 
            //echo "<br/>";

            $myArray['MainCatList'][$i] = array( 
            			'id' => $subcat->getId(), 
                        'name' => $subcat->getName(), 
                        'image' => $imageUrl.$_category->getData('image'),
                        //'image1' => $_category->getImageUrl()
                        //'price' => $subcat->getPrice(), 
                        //'description' => strip_tags($subcat->getDescription()), 
                        //'short_escription' => strip_tags($subcat->getShortDescription()) 
                    );
            $i++;
        }

        //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 

        // retrieve quote items collection
        $items = $cart->getQuote()->getAllItems();
        //echo count($items);
        $myArray['CartQTY'] = count($items);

        //echo "<pre>"; print_r($myArray); echo "</pre>";
        echo json_encode($myArray);
        die;
    }
}