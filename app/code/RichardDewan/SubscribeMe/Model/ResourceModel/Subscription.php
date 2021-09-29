<?php

namespace RichardDewan\SubscribeMe\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Subscription extends AbstractDb
{
    const TABLE_NAME ='richarddewan_subscribeme_subscription';
    const ID = 'id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID);
    }
}
