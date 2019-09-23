<?php 
namespace Yupple\Brand\Block\Adminhtml\Brand\Edit\Form;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface; 

class DeleteButton extends GenericButton implements ButtonProviderInterface { 
public function getButtonData()
{ 
return [ 
'label' => __('Delete Contact'), 
'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete this contact ?') . '\', \'' . $this->getDeleteUrl() . '\')', 
'class' => 'delete', 
'sort_order' => 20 
]; 
} 

public function getDeleteUrl() { 
$id = $this->request->getParam('id');
return $this->getUrl('*/*/delete', ['id' => $id]); 
} 
}
