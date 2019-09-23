<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class ProductAPI extends \Magento\Framework\App\Action\Action
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
            $images = $product->getMediaGalleryImages();
           
            $imageGallery = array();
            //echo count($images);
            $img = array();
            $i = 0;
            if( count($images) > 1 ){
                foreach($images as $child){
                    //$imageGallery[] = $child->getUrl();
                    $img[$i]['image'] = $child->getUrl();
                    $i++;
                } 
                $myArray['imageGallery'] =  $img;
            }else{
                $img[0]['image'] = $imageUrl.$product->getData('image');
                $myArray['imageGallery'] = $img;
            }

            //echo count($product->getOptions());
            $priceArray = array();
            $titleArray = array();

            if( count($product->getOptions() ) == 0){
                $myArray['weight_title'] = null;
                $myArray['weight_price'] = null;
            }else{
                
                foreach ($product->getOptions() as $options) {

                    $optionData = $options->getValues();
                    foreach ($optionData as $data) {
                        echo "<pre>"; print_r($data->getData());
                        $priceArray[] = $data['price'];
                        $titleArray[] = $data['title'];
                        //echo $optionDuration[] = $data->getTitle();
                    }
                    $myArray['weight_title'] = $titleArray;
                    $myArray['weight_price'] = $priceArray;
                }
            }

            if($product->getId()==''){
                $myArray['status'] = "400";
                $myArray['message'] = 'Record not found.';
            }else{
                //foreach ($product as $value) {
                    //echo $product->
                    $myArray['Product_listDetail'] = array( 
                                                'id' => $product->getId(), 
                                                'name' => $product->getName(), 
                                                //'image' => $product->getData('image'),
                                                //'image_gallery' => $imageGallery,
                                                'old_price' => $product->getPrice(), 
                                                //'special_price' => $product->getPrice('special_price'), 
                                                'new_price' => $product->getFinalPrice(), 
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