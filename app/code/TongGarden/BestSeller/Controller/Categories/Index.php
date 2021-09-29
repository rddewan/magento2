<?php
namespace TongGarden\BestSeller\Controller\Categories;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection as BestSellersCollection;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use TongGarden\BestSeller\Model\ResourceModel\Sales\BestSellers;

class Index extends Action implements HttpGetActionInterface
{
    protected $bestSellersCollectionFactory;

    public function __construct(Context $context, BestSellersCollectionFactory $bestSellersCollectionFactory)
    {
        $this->bestSellersCollectionFactory = $bestSellersCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        //$result->setContents("Category");

        /** @var Request $request */
        $request = $this->getRequest();
        $categoryId = $request->getParam('category_id');
        $limit = $request->getParam('limit');
        //$result->setContents($request->getControllerName());

        /** @var BestSellersCollection $bestSellersCollection */
        $bestSellersCollection = $this->bestSellersCollectionFactory->create();
        $tongGardenBesSellerTable = BestSellers::MAIN_TABLE;
        $bestSellersCollection->getSelect()
            ->joinLeft(
                $tongGardenBesSellerTable,
                "sales_bestsellers_aggregated_yearly.id = $tongGardenBesSellerTable.id",
                ['is_featured' => "SUM($tongGardenBesSellerTable.is_featured)"]
            )
            ->order('is_featured DESC');

        //var_dump($bestSellersCollection->load()->getSelect()->__toString());
        echo '<pre>';
        foreach ($bestSellersCollection as $item) {
            var_dump($item->getData());
        }
        die();

        /*$filteredBestSellersCollection = $bestSellersCollection->addFieldToFilter('qty_ordered', ['gt'=> 1]);
        $firstItem = $bestSellersCollection->getFirstItem();
        $allItems = $bestSellersCollection->getItems();
        $filteredAllItems = $filteredBestSellersCollection->getItems();

        echo '<pre>';
        var_dump($filteredBestSellersCollection->load()->getSelect()->__toString());
        foreach ($filteredAllItems as $item) {
            var_dump($item->getData());
        }
        die();*/

        /*
        echo '<pre>';
        foreach ($allItems as $item) {
            var_dump($item->getData());
        }
        die();
        */

        /*
         * echo '<pre>';
        var_dump($firstItem->getData());
        die();
        */

        $result->setContents("category_id: $categoryId, limit: $limit");
        return $result;
    }
}
