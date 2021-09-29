<?php declare(strict_types=1);

namespace RDewan\SignupOffer\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use RDewan\SignupOffer\Model\ResourceModel\SignupOffer as SignupOfferResource;
use RDewan\SignupOffer\Model\SignupOffer;
use RDewan\SignupOffer\Model\SignupOfferFactory;

class Delete extends Action implements HttpGetActionInterface
{
    /** @var  SignupOfferFactory*/
    protected $signupOfferFactory;

    /** @var  SignupOfferResource */
    protected $signupOfferResource;

    const ADMIN_RESOURCE = 'RDewan_SignupOffer::config_delete';

    /**
     * Delete constructor.
     * @param Context $context
     * @param SignupOfferFactory $signupOfferFactory
     * @param SignupOfferResource $signupOfferResource
     */
    public function __construct(
        Context $context,
        SignupOfferFactory $signupOfferFactory,
        SignupOfferResource $signupOfferResource
    ) {
        $this->signupOfferFactory = $signupOfferFactory;
        $this->signupOfferResource = $signupOfferResource;
        parent::__construct($context);
    }

    public function execute() : Redirect
    {
        try {
            /**
             * get the parm id from request
             */
            $id = $this->getRequest()->getParam('id');
            /** @var SignupOffer $config */
            $config = $this->signupOfferFactory->create();
            /**
             * load config data with the given id to $config
             */
            $this->signupOfferResource->load($config, $id);
            /**
             * check if the record exist with the given id
             * delete if records exist
             */
            if ($config->getId()) {
                $this->signupOfferResource->delete($config);
                $this->messageManager->addSuccessMessage(__('The record has been deleted'));
            } else {
                $this->messageManager->addErrorMessage(__('The record does not exist'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('signup-offer/config');
    }
}
