<?php declare(strict_types=1);

namespace RDewan\SignupOffer\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * Actions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        /** if no row are found then return the default value */
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        /** loop through the data $dataSource */
        foreach ($dataSource['data']['items'] as &$item) {
            /** check if it has a id  */
            if (!isset($item['id'])) {
                continue;
            }

            /** if have the id value then create a action column */
            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $this->urlBuilder->getUrl('signup-offer/config/edit', [
                        'id' => $item['id'],
                    ]),
                    'label' => __('Edit')
                ],
                'delete' => [
                    'href' => $this->urlBuilder->getUrl('signup-offer/config/delete', [
                        'id' => $item['id']
                    ]),
                    'label' => __('Delete'),
                    'conform' => [
                        'title' => __('Delete %1', $item['id']),
                        'message' => __('Are you sure you want to delete the %1 record?', $item['id']),
                    ]
                ]
            ];
        }
        return $dataSource;
    }
}
