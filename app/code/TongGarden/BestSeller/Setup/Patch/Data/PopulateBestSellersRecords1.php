<?php

namespace TongGarden\BestSeller\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use TongGarden\BestSeller\Model\ResourceModel\Sales\BestSellers as BestSellersResourceModel;
use TongGarden\BestSeller\Model\Sales\Bestsellers as BestSellersModel;
use TongGarden\BestSeller\Model\Sales\BestsellersFactory;

class PopulateBestSellersRecords1 implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface  */
    protected $moduleDataSetup;

    /** @var BestSellersResourceModel  */
    protected $bestSellerResource;

    /** @var BestsellersFactory  */
    protected $bestSellersFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BestSellersResourceModel $bestSellerResource,
        BestsellersFactory $bestSellersFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->bestSellerResource = $bestSellerResource;
        $this->bestSellersFactory = $bestSellersFactory;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();

        /** @var BestSellersModel $bestSeller */
        $bestSeller = $this->bestSellersFactory->create();
        $data = [
            'id' => 5,
            'is_featured' => true
        ];
        $bestSeller->setData($data);
        $this->bestSellerResource->save($bestSeller);

        /* $setup = $this->moduleDataSetup;
         $setup->startSetup();
         $table = $setup->getTable(BestSellersResourceModel::MAIN_TABLE);
         $setup->getConnection()->insert($table, [
             'id' => 1,
             'is_featured' => true
         ]);
         $setup->getConnection()->insert($table, [
             'id' => 3,
             'is_featured' => true
         ]);*/

        $setup->endSetup();
    }
}
