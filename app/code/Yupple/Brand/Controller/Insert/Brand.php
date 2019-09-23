<?php
namespace Yupple\Brand\Controller\Insert;
class Brand extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {   
        $brand = $this->_objectManager->create('Yupple\Brand\Model\Brand');
        $brand->setBname('Paul Dupond');
        $brand->setImage('Paul image');
        $brand->setDescription('Paul bdesc');
        $brand->setEmail('paul@gmail.com');
        $brand->save();
        $brand = $this->_objectManager->create('Yupple\Brand\Model\Brand');
        $brand->setBname('Vaibhav Vaibhav');
        $brand->setImage('Vaibhav image');
        $brand->setDescription('Vaibhav bdesc');
        $brand->setEmail('vaibahv@gmail.com');
        $brand->save();
        die('test');
    }
}
