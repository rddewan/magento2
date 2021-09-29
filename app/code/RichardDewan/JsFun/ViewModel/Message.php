<?php


namespace RichardDewan\JsFun\ViewModel;


use Magento\Framework\View\Element\Block\ArgumentInterface;

class Message implements ArgumentInterface
{
    public function getMessage(): string
    {
        return str_shuffle('Declarative Test From Vue using PHP');
    }

}
