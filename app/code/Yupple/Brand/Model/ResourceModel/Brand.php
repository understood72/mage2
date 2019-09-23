<?php 
namespace Yupple\Brand\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Brand extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('brand', 'brand_id');
    }
}
