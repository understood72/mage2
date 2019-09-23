<?php
namespace Yupple\Brand\Block\Adminhtml\Brand\Edit;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Backend\Block\Widget\Form\Generic;
class Form extends Generic
{
    /**
     * @var \Yupple\Brand\Model\DemoFactory
     */
    protected $brandDataFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Yupple\Brand\Model\BrandDataFactory $brandDataFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Yupple\Brand\Model\BrandFactory $brandDataFactory,
        array $data = []
    ) {
        $this->brandDataFactory = $brandDataFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $brandId = $this->_coreRegistry->registry('current_brand_id');
        /** @var \Yupple\Brand\Model\BrandFactory $brandData */
        if ($brandId === null) {
            $brandData = $this->brandDataFactory->create();
        } else {
            $brandData = $this->brandDataFactory->create()->load($brandId);
        }
        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Basic Information')]);
        $fieldset->addField(
            'bname',
            'text',
            [
                'name' => 'bname',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'bdesc',
            'text',
            [
                'name' => 'bdesc',
                'label' => __('Description'),
                'title' => __('Description'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'title' => __('Email'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Image'),
                'title' => __('Image'),
                'required' => true
            ]
        );
        /*$fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Active'),
                'title' => __('Active'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $yesNo,
            ]
        );
        $fieldset->addField(
            'is_visible',
            'select',
            [
                'name' => 'is_visible',
                'label' => __('Visible'),
                'title' => __('Visible'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $yesNo,
            ]
        ); */
        $fieldset->addType('image', '\Yupple\Brand\Block\Adminhtml\Brand\Helper\Image');
        if ($brandData->getId() !== null) {
            // If edit add id
            $form->addField('brand_id', 'hidden', ['name' => 'brand_id', 'value' => $brandData->getBrandId()]);
        }
        if ($this->_backendSession->getBrandData()) {
            $form->addValues($this->_backendSession->getBrandData());
            $this->_backendSession->setBrandData(null);
        } else {
            $form->addValues(
                [
                  //  'brand_id' => $brandData->getBrandId(),
                    'bname' => $brandData->getBname(),
                    'bdesc' => $brandData->getBdesc(),
                    'image' => $brandData->getImage(),
                    'email' => $brandData->getEmail()
                 //   'is_active' => $brandData->getIsActive(),
                 //   'is_visible' => $brandData->getIsVisible(),
                ]
            );
        }
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }
}