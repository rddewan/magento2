<?php
namespace TongGarden\BestSeller\Controller\Me;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action implements HttpGetActionInterface
{
    /** @var Session  $customerSession*/
    protected $customerSession;

    public function __construct(Context $context, Session $customerSession)
    {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /*public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $customerId =  0;
        $result->setContents("customer_id: $customerId");
        return $result;
    }*/

    /*public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        //$objectManager = ObjectManager::getInstance();
        //$customerSession = $objectManager->get('Magento\Customer\Model\Session');
        $customerId = $this->customerSession->getCustomerId();
        $result->setContents("customer_id: $customerId");
        return $result;
    }*/

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        //$objectManager = ObjectManager::getInstance();
        //$customerSession = $objectManager->get('Magento\Customer\Model\Session');
        $customerId = $this->customerSession->getCustomerId();
        $this->_eventManager->dispatch('customer_views_bestselling_me_index',['customer_id' => $customerId]);

        $result->setContents("customer_id: $customerId");
        return $result;
    }
}
