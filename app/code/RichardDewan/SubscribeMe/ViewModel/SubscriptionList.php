<?php

namespace RichardDewan\SubscribeMe\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription\CollectionFactory as SubscriptionCollectionFactory;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription\Collection as SubscriptionCollection;

class SubscriptionList implements ArgumentInterface
{

    protected $subscriptionCollectionFactory;

    public function __construct(SubscriptionCollectionFactory $subscriptionCollectionFactory)
    {
        $this->subscriptionCollectionFactory = $subscriptionCollectionFactory;
    }

    public function getSubscriptionList()
    {
        /** @var SubscriptionCollection $subscriptionCollection */
        $subscriptionCollection = $this->subscriptionCollectionFactory->create();
        //$firstItem = $subscriptionCollection->getFirstItem();
        return $subscriptionCollection->getItems();
    }

    public function getFormPostRoute()
    {
        return 'subscribe-me/index/save';
    }

}
