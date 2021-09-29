<?php

namespace RichardDewan\SubscribeMe\Model\ResourceModel\Subscription;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription as SubscriptionResourceModel;
use RichardDewan\SubscribeMe\Model\Subscription as SubscriptionModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(SubscriptionModel::class, SubscriptionResourceModel::class);
    }
}
