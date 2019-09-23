<?php
namespace Yupple\Brand\Controller\Index;
use Yupple\Brand\Block\Index\Collection;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends Action

{

/** @var PageFactory */

protected $pageFactory;

/** @var  \Magento\Catalog\Model\ResourceModel\Product\Collection */

protected $productCollection;

/** @var  \Yupple\Brand\Block\Index\Collection */

protected $collection;

public function __construct(

     Context $context,

     PageFactory $pageFactory,

        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory

    

){

     $this->pageFactory = $pageFactory;

     $this->productCollection = $collectionFactory->create();

     parent::__construct($context);

}
protected function _prepareLayout()
    {

        return parent::_prepareLayout();
    }
public function execute()
{
               
             // for post $post = $this->getRequest()->getPostValue();               
               $brand_id = $this->getRequest()->getParam('bid');
               $result = $this->pageFactory->create();
               $collection = $this->productCollection;
               $collection->addFieldToSelect('*');
               $collection->addAttributeToFilter('brand_option', array('finset' => $brand_id));
              // $categoriesId = [37];
             //  $collection->addCategoriesFilter(['in' => $categoriesId]); // Filter with category id
               $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
               $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED); // Filter enable product
               $list = $result->getLayout()->getBlock('brand.products.list');
               $list->setProductCollection($collection);
               return $result;

}
} 