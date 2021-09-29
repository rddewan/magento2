<?php declare(strict_types=1);

namespace RDewan\SignupOffer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SignupOffer extends AbstractDb
{
    /** @var string main table name */
    const MAIN_TABLE = 'rdewan_signupoffer_config';

    /** @var string main tbale primary key field name */
    const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
