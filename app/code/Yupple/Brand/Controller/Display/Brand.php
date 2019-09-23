<?php
namespace Yupple\Brand\Controller\Display;
class Brand extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
       $this->_view->loadLayout();
       $this->_view->renderLayout();
       
       /*  For view working
        * $contactModel = $this->_objectManager->create('Yupple\Brand\Model\Brand');
        $collection = $contactModel->getCollection()->addFieldToFilter('bname', array('like'=> '%Paul%'));
        foreach($collection as $contact) {
            var_dump($contact->getData());
        } */
    }
}
