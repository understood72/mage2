<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class CategoryAPI extends \Magento\Framework\App\Action\Action
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
        //$categoryId = 3;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /*
        $category = $objectManager->create('Magento\Catalog\Model\Category')
        ->load($categoryId);
        //echo $category->getName();
        $myArray = array();

        $myArray['status'] = array( '200');
        $myArray['message'] = array( 'category list');

        $myArray['MainCatList'] = array( 'id' => $category->getId(), 
                        'name' => $category->getName(), 
                        'image' => $category->getData('image'),
                        'description' => strip_tags($category->getDescription())
                    );
        
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
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);                  
       
        //foreach ($product as $value) {
            $myArray = array( 'id' => $product->getId(), 
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
        */
        //echo $_GET['cat_id']; die;
        $catId = $_GET['cat_id'];  //Parent Category ID
        $subcategory = $objectManager->create('Magento\Catalog\Model\Category')->load($catId);
        $subCats = $subcategory->getChildrenCategories();
        //$_helper = $this->helper('Magento\Catalog\Helper\Output');
        $i=0;
        $myArray = array();
        $myArray['status'] = "200";
        $myArray['message'] = 'category list';
        foreach ($subCats as $subcat) {
            //$_category = $objectManager->create('Magento\Catalog\Model\Category')->load($subcat->getId());
            
            //$_imgHtml = '';

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

            $myArray['subCat_list'][$i] = array( 'id' => $subcat->getId(), 
                        'name' => $subcat->getName(), 
                        //'image' => $subcat->getData('image'),
                        //'price' => $subcat->getPrice(), 
                        //'description' => strip_tags($subcat->getDescription()), 
                        //'short_escription' => strip_tags($subcat->getShortDescription()) 
                    );
            $i++;
        }

        //echo "<pre>"; print_r($myArray); echo "</pre>";
        echo json_encode($myArray);
    }
}