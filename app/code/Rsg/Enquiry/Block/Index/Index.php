<?php
 
namespace Rsg\Enquiry\Block\Index;

class Index extends \Magento\Framework\View\Element\Template
{
	public function __construct(\Magento\Framework\View\Element\Template\Context $context)
	{
		parent::__construct($context);
	}

	public function sayHello()
	{
		return __('Hello World');
	}
}
/*use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use \Magento\Framework\Mail\Template\TransportBuilder;
use \Magento\Framework\Translate\Inline\StateInterface; 
 
class Index extends \Magento\Framework\View\Element\Template {
 
    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = []) {
 
        parent::__construct($context, $data);
 
    }
 
 
    protected function _prepareLayout()
    {
        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId());
		$templateVars = array(
		                    'store' => $this->storeManager->getStore(),
		                    'customer_name' => 'John Doe',
		                    'message'   => 'Hello World!!.'
		                );
		$from = array('email' => "ramshankar5july@gmail.com", 'name' => 'Name of Sender');
		//$this->inlineTranslation->suspend();
		$to = array('developer3@kairali.com');
		$transport = $this->_transportBuilder->setTemplateIdentifier('hello_template')
		                ->setTemplateOptions($templateOptions)
		                ->setTemplateVars($templateVars)
		                ->setFrom($from)
		                ->addTo($to)
		                ->getTransport();
		$transport->sendMessage();
		//$this->inlineTranslation->resume();
        return parent::_prepareLayout();
    }
 
}*/