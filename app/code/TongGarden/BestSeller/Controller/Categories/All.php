<?php

namespace TongGarden\BestSeller\Controller\Categories;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

class All extends Action implements HttpGetActionInterface
{
    public function execute()
    {
        return $this->_forward('index', null, null, ['limit' => 100]);
    }
}
