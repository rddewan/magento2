<?php declare(strict_types=1);

namespace RDewan\SignupOffer\Model\ResourceModel\SignupOffer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RDewan\SignupOffer\Model\SignupOffer;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(SignupOffer::class, \RDewan\SignupOffer\Model\ResourceModel\SignupOffer::class);
    }
}
