<?php

namespace RDewan\SignupOffer\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use RDewan\SignupOffer\Model\ResourceModel\SignupOffer\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    /** @var array */
    protected $_loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $signupOfferCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $signupOfferCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $config) {
            $this->_loadedData[$config->getId()] = $config->getData();
        }

        return $this->_loadedData;
    }
}
