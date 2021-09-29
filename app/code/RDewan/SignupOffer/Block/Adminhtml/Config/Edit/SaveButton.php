<?php


namespace RDewan\SignupOffer\Block\Adminhtml\Config\Edit;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use RDewan\SignupOffer\Block\Adminhtml\Config\GenericButton;

class SaveButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save Contact'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }

}
