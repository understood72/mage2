<?php
namespace Yupple\Brand\Model\ResourceModel\Brand;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
	 public function _construct()
    {
        $this->_init('Yupple\Brand\Model\Brand', 'Yupple\Brand\Model\ResourceModel\Brand');
    }
}

