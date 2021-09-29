<?php

namespace TongGarden\BestSeller\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\HTTP\PhpEnvironment\Request;

class Index extends Action implements HttpGetActionInterface
{
    /*public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        //$result->setContents('Index');

        // @var Request $request
        $request = $this->getRequest();
        $result->setContents($request->getControllerName());
        return $result;
    }*/

    /*
     * return a blank page
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
