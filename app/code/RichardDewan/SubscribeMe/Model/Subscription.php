<?php


namespace RichardDewan\SubscribeMe\Model;


use Magento\Framework\Model\AbstractModel;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription as SubscriptionResourceModel;

class Subscription extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(SubscriptionResourceModel::class);
    }

}
