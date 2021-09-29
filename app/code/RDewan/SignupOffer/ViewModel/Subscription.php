<?php

namespace RDewan\SignupOffer\ViewModel;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Newsletter\Model\SubscriptionManagerInterface;

class Subscription
{
    /** @var SubscriptionManagerInterface */
    protected $subscriptionManager;

    /** @var DateTime */
    protected $dateTime;

    public function __construct(SubscriptionManagerInterface $subscriptionManager, DateTime $dateTime)
    {
        $this->subscriptionManager= $subscriptionManager;
        $this->dateTime = $dateTime;
    }

    public function addSubscriber($email, $storeId)
    {
        $this->subscriptionManager->subscribe($email, (int) $storeId);
    }
}
