<?php

namespace RichardDewan\SubscribeMe\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription as SubscriptionResourceModel;
use RichardDewan\SubscribeMe\Model\Subscription as SubscriptionModel;
use RichardDewan\SubscribeMe\Model\SubscriptionFactory;


class Save extends Action implements HttpGetActionInterface
{
    /** @var SubscriptionFactory  */
    protected $subscriptionFactory;

    /** @var SubscriptionResourceModel  */
    protected $subscriptionResourceModel;

    public function __construct(
        Context $context,
        SubscriptionResourceModel $subscriptionResourceModel,
        SubscriptionFactory $subscriptionFactory
    ) {
        $this->subscriptionResourceModel = $subscriptionResourceModel;
        $this->subscriptionFactory = $subscriptionFactory;
        parent::__construct($context);
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        /** @var SubscriptionModel $subscriptionModel */
        $subscriptionModel = $this->subscriptionFactory->create();
        $data = [
            'name' => 'Test Dewan',
            'email' => 'test@hotmail.com',
            'dob' => '2020-05-30',
            'sex' => 'Male'
        ];
        $subscriptionModel->setData($data);
        if ($this->subscriptionResourceModel->save($subscriptionModel)) {
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        } else {
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('subscribe-me');
        return $resultRedirect;
    }
}
