<?php 
namespace Rsg\Enquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class AboutApp extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
 
    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
 
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
 
    }
 
    public function execute()
    {   

        $myArray = array();
        //$myArray['isLoggedIn'] = "Yes";
        $myArray['status'] = "200";
        $myArray['message'] = 'App List';
        
        // about us 
        $url1='http://options4u.in/index.php/rest/V1/cmsPage/5';
     
        $ch1 = curl_init();
        curl_setopt($ch1,CURLOPT_URL,$url1);
        curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
        $data1 = curl_exec($ch1);
        $character1 = json_decode($data1);
        $about_us = strip_tags($character1->content);
        curl_close($ch1);

        // term_and_condition
        $url2='http://options4u.in/index.php/rest/V1/cmsPage/5';
     
        $ch2 = curl_init();
        curl_setopt($ch2,CURLOPT_URL,$url2);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        $data2 = curl_exec($ch2);
        $character2 = json_decode($data2);
        $term_and_condition = strip_tags($character2->content);
        curl_close($ch2);

        // privacy policy      
        $url3='http://options4u.in/index.php/rest/V1/cmsPage/4';
     
        $ch3 = curl_init();
        curl_setopt($ch3,CURLOPT_URL,$url3);
        curl_setopt($ch3,CURLOPT_RETURNTRANSFER,1);
        $data3 = curl_exec($ch3);
        $character3 = json_decode($data3);
        //echo $character->title;
        //echo $character->content_heading;
        $privacy_policy = strip_tags($character3->content);
        //echo $character->active;
        //echo $character->identifier;
        //echo $character->id;
        //echo $character->meta_title;
        //print_r($character);
        curl_close($ch3);

        // delivery_and_returnPolicy
        $url4='http://options4u.in/index.php/rest/V1/cmsPage/5';
     
        $ch4 = curl_init();
        curl_setopt($ch4,CURLOPT_URL,$url4);
        curl_setopt($ch4,CURLOPT_RETURNTRANSFER,1);
        $data4 = curl_exec($ch4);
        $character4 = json_decode($data4);
        $delivery_and_returnPolicy = strip_tags($character4->content);
        curl_close($ch4);

        // contact_No
        //$url1='http://options4u.in/index.php/rest/V1/cmsPage/5';
        $url5='http://options4u.in/index.php/rest/V1/cmsBlock/2';
     
        $ch5 = curl_init();
        curl_setopt($ch5,CURLOPT_URL,$url5);
        curl_setopt($ch5,CURLOPT_RETURNTRANSFER,1);
        $data5 = curl_exec($ch5);
        $character5 = json_decode($data5);
        $contact_No = strip_tags($character5->content);
        curl_close($ch5);

        $about_list = array();
        $about_list['about_us'] = $about_us;
        $about_list['term_and_condition'] = '$term_and_condition';
        $about_list['privacy_policy'] = $privacy_policy;
        $about_list['delivery_and_returnPolicy'] = '$delivery_and_returnPolicy';
        $about_list['contact_No'] = $contact_No;        

        $myArray['about_list'] = $about_list;
        echo json_encode($myArray);

        die();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $customerEmail = "akjs005@gmail.com";
        // $CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
        // $CustomerModel->setWebsiteId(1); //Here 1 means Store ID**
        // $CustomerModel->loadByEmail($customerEmail);
        // $userId = $CustomerModel->getId();
        // echo "Customer ID: ".$userId;

        $customer = $objectManager->create('Magento\Customer\Model\Customer')->setWebsiteId(1)->loadByEmail($customerEmail);

        // Create customer session
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        $customerSession->setCustomerAsLoggedIn($customer);

        if($customerSession->isLoggedIn()) {
            echo "Customer Logged in Successfully";
        }else{
            echo "Unable to Login";
        }

        $wishlist = $objectManager->get('\Magento\Wishlist\Model\Wishlist'); $wishlist_collection = $wishlist->loadByCustomerId($customer->getId(), true)->getItemCollection();

        foreach ($wishlist as $key => $value) {
            print_r($value->getData());
        }

        die;
    }
}