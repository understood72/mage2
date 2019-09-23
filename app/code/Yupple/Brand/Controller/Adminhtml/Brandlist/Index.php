<?php
namespace Yupple\Brand\Controller\Adminhtml\Brandlist;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action as BackendAction;
class Index extends BackendAction
{
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yupple_Brand::manage_brand');
    }

   
     /**
     * @var PageFactory
     */    

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;        
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Yupple_Brand::manage_brand');
        $resultPage->addBreadcrumb(__('Brand'), __('Brand'));
        $resultPage->addBreadcrumb(__('Brand List'), __('Brand List'));
        $resultPage->getConfig()->getTitle()->prepend(__('Brand List'));
        return  $resultPage;
    }
    
    /*  public function execute()
    {       
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
   */
}
