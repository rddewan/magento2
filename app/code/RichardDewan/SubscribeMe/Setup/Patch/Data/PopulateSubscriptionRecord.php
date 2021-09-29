<?php

namespace RichardDewan\SubscribeMe\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use RichardDewan\SubscribeMe\Model\ResourceModel\Subscription as SubscriptionResourceModel;

class PopulateSubscriptionRecord implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    protected $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /*
     * get the array of patches that have to be executed prior to this
     * example
     * [
     *      RichardDewan\SubscribeMe\Setup\Patch\Data\Patch1::class
     *      RichardDewan\SubscribeMe\Setup\Patch\Data\Patch2::class
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /*
     * get aliases (previous names) for the patch
     * provide a old class name if the class name change
     */
    public function getAliases(): array
    {
        return [];
    }

    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();

        $table = $setup->getTable(SubscriptionResourceModel::TABLE_NAME);
        $setup->getConnection()->insert($table, [
            'name' => 'Richard Dewan',
            'email' => 'richarddewan@hotmail.com',
            'dob' => '2020-05-30',
            'sex' => 'Male'
        ]);

        $setup->endSetup();
    }
}
