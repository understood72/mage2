<?php
namespace Yupple\Brand\Controller\Adminhtml\Brandlist;
use Magento\Framework\Controller\ResultFactory;
/**
 * Class Upload
 */
class Upload extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     *
     * @var \Yupple\Brand\Model\Brand\Image
     */
    public $imageUploader;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Yupple\Brand\Model\Brand\Image $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Yupple\Brand\Model\Brand\Image $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }
    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yupple_Brand::brand');
    }
    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image'); // here you also defind edit xml dataScope in  view/admin/ui_component/edit_fome.xml 
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }     
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}