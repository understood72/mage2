<?php
namespace Yupple\Brand\Controller\Adminhtml\Brandlist;
use Magento\Framework\Controller\ResultFactory;
class Add extends \Magento\Backend\App\Action {
        
    /**
          * @var \Magento\Framework\Registry
         
     */
        private $coreRegistry;
        protected $_brandFactory;
        
    /**
          * @param \Magento\Backend\App\Action\Context $context
          * @param \Magento\Framework\Registry $coreRegistry,
         
     */
        public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Yupple\Brand\Model\BrandFactory $brandFactory)      {
                parent::__construct($context);
                 $this->coreRegistry     = $coreRegistry;
                 $this->_brandFactory = $brandFactory;
            
        }
        
    /**
          * Mapped Grid List page.
          * @return \Magento\Backend\Model\View\Result\Page
         
     */
        public function execute(){
            $rowData = array();
                 $rowId = (int)$this->getRequest()->getParam('brand_id');
                
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
                if($rowId) {
                         $rowData = $this->_ticketsFactory->create()->load($rowId);
                        if(!$rowData->getBrandId()) {
                                 $this->messageManager->addError(__('Brand data no longer exist.'));
                                 $this->_redirect('yupple_brand/brand');
                                return;
                            
            }
                    
        }
                 $this->coreRegistry->register('row_data', $rowData);
                 $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
                 $title       = $rowId ? __('Edit Row Data ') : __('Brand Data');
                 $resultPage->getConfig()->getTitle()->prepend($title);
                return $resultPage;
            
    }
        protected function _isAllowed(){
                return $this->_authorization->isAllowed('Yupple_Brand::add');
            
    }
}