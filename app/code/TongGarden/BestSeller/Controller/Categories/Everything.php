<?php

namespace TongGarden\BestSeller\Controller\Categories;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Everything extends Action implements HttpGetActionInterface
{
    public function execute()
    {
        return $this->_redirect('*/*', ['limit' => 1000]);
    }
}
