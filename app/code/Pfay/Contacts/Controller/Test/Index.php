<?php
namespace Pfay\Contacts\Controller\Test;
class Index extends \Magento\Framework\App\Action\Action
{
	
    public function execute()
    {
		$contactModel = $this->_objectManager->create('Pfay\Contacts\Model\Contact');
        $collection = $contactModel->getCollection()->addFieldToFilter('name', array('like'=> 'Paul Ricard'));
		print_r($collection);
		exit;
        foreach($collection as $contact) {
            var_dump($contact->getData());
        }  
        die('test');
    }
}
