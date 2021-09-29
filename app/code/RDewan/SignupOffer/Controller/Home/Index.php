<?php

namespace RDewan\SignupOffer\Controller\Home;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;

class Index implements HttpGetActionInterface
{
    /* @var ResultFactory */
    protected $resultFactory;

    /* @var RequestInterface */
    protected $request;

    public function __construct(RequestInterface $request, ResultFactory $resultFactory)
    {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
