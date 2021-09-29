<?php

namespace TongGarden\BestSeller\Model\ResourceModel\Sales\BestSellers;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TongGarden\BestSeller\Model\ResourceModel\Sales\BestSellers as BestSellerResourceModel;
use TongGarden\BestSeller\Model\Sales\Bestsellers as BestSellerModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BestSellerModel::class, BestSellerResourceModel::class);
    }
}
