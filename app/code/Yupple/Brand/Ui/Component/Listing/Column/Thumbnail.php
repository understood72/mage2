<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Yupple\Brand\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Asset\Repository;
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $storeManager;

     /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    private $assetRepo;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        Repository $assetRepo,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->assetRepo = $assetRepo;
        $this->storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
      // this function create priview image path
      
      if(isset($dataSource['data']['items'])) {
            $path = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ).'brand/tmp/brand/';
             $baseImage = $this->assetRepo->createAsset('Yupple_Brand::images/defaultbrand.png')->getUrl(); // why it is not working
    //        $baseImage = $this->storeManager->getStore()->getBaseUrl()."images/defaultbrand.png";
            $fieldName = $this->getData('name');           
            foreach ($dataSource['data']['items'] as & $item) {   
                if($item['image']) {    
                   //  die($path.$item['image']);       
                    $item[$fieldName . '_src'] = $path.$item['image'];
                    $item[$fieldName . '_alt'] ="";               
                    $item[$fieldName . '_orig_src'] = $path.$item['image'];
                }else{
                    $item[$fieldName . '_src'] = $baseImage;
                    $item[$fieldName . '_alt'] ="";               
                    $item[$fieldName . '_orig_src'] = $baseImage;   

                }
            }
        }

        return $dataSource;
    }   
}