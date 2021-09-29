<?php declare(strict_types=1);

namespace RDewan\SignupOffer\Model;


use Magento\Framework\Model\AbstractModel;

class SignupOffer extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(ResourceModel\SignupOffer::class);
    }

}
