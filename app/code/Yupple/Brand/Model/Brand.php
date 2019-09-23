<?php 
namespace Yupple\Brand\Model;

use Magento\Cron\Exception;
use Magento\Framework\Model\AbstractModel;

class Brand extends AbstractModel
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $_dateTime;

    /**
     * @return void
     */
    protected function _construct()
    {
       // check it is work ? $this->_init('Yupple\Brand\Model\ResourceModel\Brand');
        $this->_init(\Yupple\Brand\Model\ResourceModel\Brand::class);
    }
    
}
