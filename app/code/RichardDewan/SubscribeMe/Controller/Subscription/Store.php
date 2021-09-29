<?php

namespace RichardDewan\SubscribeMe\Controller\Subscription;


use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription as SubscriptionResourceModel;
use RichardDewan\SubscribeMe\Model\Subscription as SubscriptionModel;
use RichardDewan\SubscribeMe\Model\SubscriptionFactory;

class Store implements HttpPostActionInterface
{
    /** @var RequestInterface */
    private $request;

    /** @var ResultFactory */
    private $resultFactory;

    /** @var SubscriptionFactory  */
    protected $subscriptionFactory;

    /** @var SubscriptionResourceModel  */
    protected $subscriptionResourceModel;

    /** @var ManagerInterface  */
    protected $messageManager;

    /**
     * Store constructor.
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param ManagerInterface $messageManager
     * @param SubscriptionResourceModel $subscriptionResourceModel
     * @param SubscriptionFactory $subscriptionFactory
     */
    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        ManagerInterface $messageManager,
        SubscriptionResourceModel $subscriptionResourceModel,
        SubscriptionFactory $subscriptionFactory
    ) {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
        $this->subscriptionResourceModel = $subscriptionResourceModel;
        $this->subscriptionFactory = $subscriptionFactory;
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        /* get request pram */
        $data = [
            'name' => $this->request->getParam('name'),
            'email' => $this->request->getParam('email'),
            'dob' => $this->request->getParam('dob'),
            'sex' => $this->request->getParam('sex'),
        ];

        /** @var SubscriptionModel */
        $subscriptionModel = $this->subscriptionFactory->create();
        $subscriptionModel->setData($data);

        if ($this->subscriptionResourceModel->save($subscriptionModel)) {
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        } else {
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('subscribe-me/thankyou/index');
        return $resultRedirect;
    }
}
