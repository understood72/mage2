<?php

namespace Yupple\Brand\Model\Config\Product;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;


class Brandoption extends AbstractSource
{
    protected $optionFactory;
    protected $_options;
    protected $_resource;
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_resource = $resource;
    }    
    public function getTablefield()
    {
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $brandTable = $connection->getTableName('brand');
        /* you can change your magento dabase name below */
        $allField = $connection->fetchAll("SELECT brand_id,bname FROM ".$brandTable); //magento2 is database name
        //$allField = $connection->fetchAll("SELECT brand_id,bname FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'magento2' AND TABLE_NAME = '".$brandTable."'"); //magento2 is database name
        return $allField;
    }
    public function getAllOptions()
    {
        $this->_options = [];
        foreach ($this->getTablefield() as $field) {
            $options[] = ['label' => $field['bname'], 'value' => $field['brand_id']];
        }
        return $options;
    }
    /* public function getAllOptions()
    {
        $this->_options = [];
        $this->_options[] = ['label' => 'Label 1', 'value' => 'value 1'];
        $this->_options[] = ['label' => 'Label 2', 'value' => 'value 2'];
    
        return $this->_options;
    } */
}