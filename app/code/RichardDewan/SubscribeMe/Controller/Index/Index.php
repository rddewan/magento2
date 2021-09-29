<?php
namespace RichardDewan\SubscribeMe\Controller\Index;

 use Magento\Framework\App\Action\HttpGetActionInterface;
 use Magento\Framework\App\RequestInterface;
 use Magento\Framework\Controller\ResultFactory;

 class Index implements HttpGetActionInterface
 {
     /** @var RequestInterface */
     private $request;

     /** @var ResultFactory */
     private $resultFactory;

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
