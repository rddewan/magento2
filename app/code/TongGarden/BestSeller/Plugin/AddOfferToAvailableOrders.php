<?php


namespace TongGarden\BestSeller\Plugin;


use Magento\Catalog\Block\Product\ProductList\Toolbar;

class AddOfferToAvailableOrders
{
    public function afterGetAvailableOrders(Toolbar $subject, $result)
    {
        $result['offer'] = 'Offer';
        return $result;
        /*echo '<pre>';
        var_dump($result);
        die();*/
    }
}
