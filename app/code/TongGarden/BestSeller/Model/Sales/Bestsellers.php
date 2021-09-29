<?php

namespace TongGarden\BestSeller\Model\Sales;

use Magento\Framework\Model\AbstractModel;
use TongGarden\BestSeller\Model\ResourceModel\Sales\BestSellers as BestSellersResourceModel;

class Bestsellers extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(BestSellersResourceModel::class);
    }
}
