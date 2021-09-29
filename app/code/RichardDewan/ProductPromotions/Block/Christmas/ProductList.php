<?php

namespace RichardDewan\ProductPromotions\Block\Christmas;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Directory\Model\Currency;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory as AttributeSetCollection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class ProductList extends Template
{

    /** @var CollectionFactory  $productCollectionFactory*/
    protected $productCollectionFactory;
    protected $imageHelper;
    protected $productFactory;
    protected $productRepository;
    protected $storeManager;
    protected $currency;
    protected $stockItemRepository;
    protected $listProductBlock;
    protected $attributeSetCollection;
    protected $productAttributeRepository;

    public function __construct(
        Template\Context $context,
        Image $imageHelper,
        ProductFactory $productFactory,
        CollectionFactory $productCollectionFactory,
        ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        Currency $currency,
        StockItemRepository $stockItemRepository,
        ListProduct $listProductBlock,
        AttributeSetCollection $attributeSetCollection,
        Repository $productAttributeRepository,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
        $this->imageHelper = $imageHelper;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->currency = $currency;
        $this->stockItemRepository = $stockItemRepository;
        $this->listProductBlock = $listProductBlock;
        $this->attributeSetCollection = $attributeSetCollection;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function getProductCollection(): Collection
    {
        //get values of current page
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 24;

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        //$collection->addAttributeToFilter('visibility', Visibility::VISIBILITY_IN_CATALOG);
        //$collection->addAttributeToFilter('status',Status::STATUS_ENABLED);
        $attribute = $this->getOptionIdByLabel('promotions', 'christmas');
        $collection->addAttributeToFilter('promotions', ['eq'=>$attribute]);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        /*var_dump($collection->load()->getSelect()->__toString());
        die();*/

        return $collection;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        //$this->pageConfig->getTitle()->set(__('Christmas Promotion'));

        try {
            if ($this->getProductCollection()) {
                $toolbar = $this->getLayout()
                    ->createBlock(
                        'Magento\Catalog\Block\Product\ProductList\Toolbar',
                        'product_list_toolbar'
                    )
                    ->setTemplate('RichardDewan_ProductPromotions::toolbar.phtml')
                    ->setCollection($this->getProductCollection());

                $pager = $this->getLayout()->createBlock(
                    'Magento\Theme\Block\Html\Pager',
                    'richarddewan.promotions.products.pager'
                )->setAvailableLimit([24=>24,36=>36,48=>48])
                    ->setShowPerPage(true)
                    ->setCollection(
                        $this->getProductCollection()
                    );

                $this->setChild('pager', $pager);
                $this->setChild('toolbar', $toolbar);
                $this->getProductCollection()->load();
            }
        } catch (LocalizedException $e) {
            return  $e->getMessage();
        }

        return $this;
    }

    public function getPagerHtml(): string
    {
        return $this->getChildHtml('pager');
    }

    public function getToolbarHtml(): string
    {
        return $this->getChildHtml('toolbar');
    }

    public function getMode()
    {
        return $this->getChildBlock('toolbar')->getCurrentMode();
    }

    public function getProductImageUrl($id): string
    {
        $base_image = 'product_base_image';  //For getting the base image
        $small_image = 'product_small_image';  //For getting the small image
        $thumbnail_image = 'product_thumbnail_image';//For getting the thumbnail image

        try {
            $product = $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return $this->imageHelper->init($product, $base_image)->getUrl();
    }

    public function getProductPrice($id): string
    {
        try {
            $product = $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return number_format($product->getPrice(), 2, '.', '') ?: 0.00;
    }

    public function getSpecialProductPrice($id): string
    {
        try {
            $product = $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return number_format($product->getSpecialPrice(), 2, '.', '') ?: 0.00;
    }

    public function getProduct($id)
    {
        try {
            $product = $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return $product;
    }

    public function getProductUrl($id): string
    {
        try {
            $product = $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return $product->getProductUrl();
    }

    public function isProductSalable($sku): string
    {
        try {
            $product = $this->productRepository->get($sku);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return $product->isInStock();
    }

    public function getProductQty($sku): string
    {
        try {
            $product = $this->productRepository->get($sku);
        } catch (NoSuchEntityException $e) {
            return 'Required product not found';
        }

        return $product->getQty();
    }

    /**
     * Get store base currency code
     * USD MYR SGD
     * @return string
     */
    public function getBaseCurrencyCode(): string
    {
        try {
            return $this->storeManager->getStore()->getBaseCurrencyCode();
        } catch (NoSuchEntityException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get currency symbol for current locale and currency code
     *
     * @return string
     */
    public function getCurrentCurrencySymbol(): string
    {
        return $this->currency->getCurrencySymbol();
    }

    /*
     * get stock by product id
     */
    public function getStockItem($productId)
    {
        try {
            return $this->stockItemRepository->get($productId);
        } catch (NoSuchEntityException $e) {
            return $e->getMessage();
        }
    }

    /*
     * get add to cart url
     */
    public function getAddToCartUrl($product): string
    {
        return $this->listProductBlock->getAddToCartUrl($product);
    }

    /* Get Option id by Option Label */
    public function getOptionIdByLabel($attributeCode, $optionLabel)
    {
        $product = $this->productFactory->create();
        $isAttributeExist = $product->getResource()->getAttribute($attributeCode);
        $optionId = 0;
        if ($isAttributeExist && $isAttributeExist->usesSource()) {
            $optionId = $isAttributeExist->getSource()->getOptionId($optionLabel);
        }

        return $optionId;
    }
}
