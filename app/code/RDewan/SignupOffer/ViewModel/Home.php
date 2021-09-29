<?php

namespace RDewan\SignupOffer\ViewModel;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Home implements ArgumentInterface
{
    /* @var CollectionFactory */
    protected $collectionFactory;

    /* @var CategoryRepository */
    protected $categoryRepository;

    public function __construct(
        CollectionFactory $collectionFactory,
        CategoryRepository $categoryRepository
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Collection
     */
    private function getCategoryCollection(): Collection
    {
        return $this->collectionFactory->create();
    }

    /**
     *
     */
    public function getCategoryId($categoryName)
    {
        try {
            $collection = $this->getCategoryCollection()
                ->addAttributeToFilter('name', $categoryName);

            return $collection->getFirstItem()->getId();
        } catch (LocalizedException $e) {
            return ['response' => 'error:' . $e->getMessage()];
        }
    }

    /**
     *get category by category id
     * @param $categoryId (Integer)
     */
    public function getCategoryById($categoryId)
    {
        try {
            return $this->categoryRepository->get($categoryId);
        } catch (NoSuchEntityException $e) {
            return ['response' => 'error:' . $e->getMessage()];
        }
    }

    /**
     *get category name by category id
     * @param $categoryId (Integer)
     */
    public function getCategoryNameById($categoryId)
    {
        try {
            $category = $this->categoryRepository->get($categoryId);
            return $category->getName();
        } catch (NoSuchEntityException $e) {
            return ['response' => 'error:' . $e->getMessage()];
        }
    }
}
