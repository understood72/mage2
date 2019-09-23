<?php
namespace Yupple\Brand\Controller\Adminhtml\Brandlist;
use Magento\Framework\Exception\LocalizedException as FrameworkException;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Yupple\Brand\Model\brandFactory
     */
    protected $_brandFactory;
        /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Yupple\Brand\Model\BrandFactory $brandFactory
     */


    private $dataPersistor;
    protected $uploaderFactory;
    protected $imageModel;

    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Yupple\Brand\Model\Brand\Image $imageModel,
        \Magento\Backend\App\Action\Context $context,
        \Yupple\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->uploaderFactory = $uploaderFactory;
        $this->imageModel = $imageModel;
        $this->_brandFactory = $brandFactory;
        parent::__construct($context);
    }
    public function execute()
    {       
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('yuppple_brand/brandlist/add');
            return;
        }
        try {  
            /* echo "<pre>";
            print_r($data['image'][0]['name']);
            die; */
            if(isset($data['brand_id'])){        
                $rowData = $this->_brandFactory->create()->load($data['brand_id']);
                if (!$rowData->getBrandId()) {
                    $this->messageManager->addError(__('Brand data no longer exist.'));
                    $this->_redirect('*/*/index');
                    return;
                }
              
             }else{
                $rowData = $this->_brandFactory->create();
             }  
             $data = $this->_filterBrandData($data);      
            $rowData->setData($data);          
            $rowData->save();
           // if (!$this->dataProcessor->validate($data)) {
           //     $this->_redirect('*/*/edit', ['brand_id' => $model->getBrandId(), '_current' => true]);
           //     return;
           //  }
            $this->messageManager->addSuccess(__('Brand data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }catch (\Exception $e) {
            $this->messageManager
            ->addExceptionMessage($e, __('Something went wrong while saving the Faqgroup.'));
        }
        $this->_redirect('*/*/index');
    }
    public function _filterBrandData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yupple_Brand::save');
    }
    public function uploadFileAndGetName($input, $destinationFolder, $data){
    try {
        if (isset($data[$input]['delete'])) {
            return '';
        } else {
            $uploader = $this->uploaderFactory->create(['fileId' => $input]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            $result = $uploader->save($destinationFolder);
            return $result['file'];
        }
    } catch (\Exception $e) {
        if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
            throw new FrameworkException($e->getMessage());
        } else {
            if (isset($data[$input]['value'])) {
                return $data[$input]['value'];
            }
        }
    }
    return '';
}
    
}