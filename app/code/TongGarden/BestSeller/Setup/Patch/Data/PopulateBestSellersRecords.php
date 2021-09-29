<?php

namespace TongGarden\BestSeller\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use TongGarden\BestSeller\Model\ResourceModel\Sales\BestSellers as BestSellersResourceModel;

class PopulateBestSellersRecords implements DataPatchInterface
{
    protected $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface  $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();
        $table= $setup->getTable(BestSellersResourceModel::MAIN_TABLE);
        $setup->getConnection()->insert($table, [
            'id' =>1,
            'is_featured' => true
        ]);
        $setup->getConnection()->insert($table, [
            'id' =>3,
            'is_featured' => true
        ]);

    }
}
