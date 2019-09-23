<?php 
namespace Yupple\Brand\Block;
use Magento\Framework\View\Element\Template;
class Brandslist extends \Magento\Framework\View\Element\Template
{
	private $_brand; 
    public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
        \Yupple\Brand\Model\Brand $brand,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []){
               
        $this->_brand = $brand;
        $this->_resource = $resource;

        parent::__construct(
            $context,
            $data
        );
    }

    public function addContacts($count)
    {
        $_contacts = $this->getData('contacts');
        $actualNumber = count($_contacts);
        $names = array();
        for($i=$actualNumber;$i<($actualNumber+$count);$i++) {
            $_contacts[] = 'nom '.($i+1);
        }
        $this->setData('brands',$_contacts);
    }
     public function viewBrands()
    {
        $_brand = $this->getData('brand');
        $actualNumber = count($_brand);
        $names = array();
        for($i=$actualNumber;$i<($actualNumber+$count);$i++) {
            $_contacts[] = 'nom '.($i+1);
        }
        $this->setData('brands',$_contacts);
    }
   public function getBrands()
    {
        $collection = $this->_brand->getCollection()->addFieldToFilter('bname', array('like'=> '%Paul%'));
        return $collection;
    }
}
