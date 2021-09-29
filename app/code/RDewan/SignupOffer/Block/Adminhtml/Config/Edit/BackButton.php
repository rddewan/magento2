<?php


namespace RDewan\SignupOffer\Block\Adminhtml\Config\Edit;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use RDewan\SignupOffer\Block\Adminhtml\Config\GenericButton;

class BackButton extends GenericButton implements ButtonProviderInterface
{

    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
