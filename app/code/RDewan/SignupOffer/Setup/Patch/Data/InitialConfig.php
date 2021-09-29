<?php declare(strict_types=1);

namespace RDewan\SignupOffer\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use RDewan\SignupOffer\Model\ResourceModel\SignupOffer;

class InitialConfig implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    protected $moduleDataSetup;

    /** @var  ResourceConnection*/
    protected $resourceConnection;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, ResourceConnection $resourceConnection)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->resourceConnection = $resourceConnection;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply(): self
    {
        $connection  = $this->resourceConnection->getConnection();
        $data = [
            [
                'api_key' => 'Mailchimp Api Key',
                'server' => 'us6',
                'list_id' => 'Mailchimp List Id',
                'coupon_discount_amount' => 10.0,
                'coupon_amount_txt' => '$50'
            ]
        ];

        $connection->insertMultiple(SignupOffer::MAIN_TABLE, $data);
        return $this;
    }
}
