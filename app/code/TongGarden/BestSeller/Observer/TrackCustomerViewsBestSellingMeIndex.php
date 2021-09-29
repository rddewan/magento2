<?php

namespace TongGarden\BestSeller\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class TrackCustomerViewsBestSellingMeIndex implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        if ($customerId = $observer->getData('customer_id')) {
            echo '<pre>';
            var_dump($customerId);
            die();
        }
    }
}
