<?php
namespace Yupple\Brand\Model;

use Yupple\Brand\Model\ResourceModel\Brand\CollectionFactory;

// added after image 
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var  \Magento\Framework\App\Request\DataPersistorInterface
     */
    private $dataPersistor;
    private $storeManager;
    /**
     * @var array
     */
    protected $_loadedData;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bramdCollectionFactory
     * @param array $meta
     * @param array $data
     */
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bramdCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bramdCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
       
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
       
        foreach ($items as $brand) {
            $this->_loadedData[$brand->getBrandId()] = $brand->getData();

            // append for image in admin grid
            if ($brand->getImage()) {
                $m['image'][0]['name'] = $brand->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$brand->getImage();
                $fullData = $this->_loadedData;
                $this->_loadedData[$brand->getBrandId()] = array_merge($fullData[$brand->getBrandId()], $m);
            }
         
        }
        return $this->_loadedData;
    }
    // append for image in admin grid
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'brand/tmp/brand/';
        return $mediaUrl;
    }
}

