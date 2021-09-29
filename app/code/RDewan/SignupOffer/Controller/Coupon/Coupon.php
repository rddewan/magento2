<?php /** @noinspection ALL */

namespace RDewan\SignupOffer\Controller\Coupon;

use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroupCollection;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Model\ResourceModel\Rule as ResourceModelRule;
use Magento\SalesRule\Model\Rule;
use Magento\Store\Model\StoreManagerInterface;

class Coupon implements HttpPostActionInterface
{
    /** @var  RequestInterface */
    protected $request;

    /** @var  ResultFactory */
    protected $resultFactory;

    /** @var Rule */
    protected $shoppingCartRule;

    /** @var ResourceModelRule */
    protected $resourceModelRule;

    /** @var  CustomerGroupCollectionFactory */
    protected $customerGroupCollectionFactory;

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        Rule $rule,
        ResourceModelRule $resourceModelRule,
        CustomerGroupCollectionFactory $customerGroupCollectionFactory,
        StoreManagerInterface $storeManager
    )
    {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->shoppingCartRule = $rule;
        $this->resourceModelRule = $resourceModelRule;
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
        $this->storeManager = $storeManager;

    }

    /**
     * Execute action based on request and return result
     *
     */
    public function execute()
    {
        $resultResponse = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $subscriber_hash = $this->request->getParam('subscriber_hash');

        /**
         * check if the required param is passes in the post request
         * return error if the required param are not passed
         */
        if (!empty($subscriber_hash)) {

            $result = $this->createCouponCode();
            /**
             * check if the coupon code creation was success
             */
            if ($result !== null) {
                return $resultResponse->setData([
                    'success' => true,
                    'message' => 'Thank you for your subscription',
                    'coupon' => $result
                ]);
            }

            return $resultResponse->setHttpResponseCode(400)
                ->setData([
                    'success' => false,
                    'message' => 'Sorry there was some error while creating coupon. Please contact our support team'
                ]);
        }


        return $resultResponse->setHttpResponseCode(401)
            ->setData([
                'success' => false,
                'message' => 'This page cannot cannot be accessed. Please contact our support team'
            ]);
    }

    /**
     * Create a coupon code
     * TODO : Create coupon code discount amount base on cart amount eg: buy 100$ get 5$  / buy 200$ get 10$
     *
     */
    public function createCouponCode()
    {
        $randStr = $this->generateRandomString();
        $coupon = [];
        //rule name
        $coupon['name'] = "COUPON ".$randStr;
        //coupon description
        $coupon['desc'] = "Signup Offer Coupon";
        //coupon start data
        $coupon['start'] = date('Y-m-d');
        //coupon end date
        $coupon['end'] = '';
        //single use coupon per customer
        $coupon['max_redemptions'] = 1;
        //how many times does a coupon can be used
        $coupon['use_per_coupon'] = 1;
        //discount type [ cart_fixed / by_percent ]
        $coupon['discount_type'] = 'cart_fixed';
        //discount amount / percent
        $coupon['discount_amount'] = 10;
        //is free shipping is allowed
        $coupon['flag_is_free_shipping'] = 0;
        //number of redemption.
        $coupon['redemptions'] = 1;
        //coupon code
        $coupon['code'] = $randStr;

        $this->shoppingCartRule->setName($coupon['name'])
            ->setDescription($coupon['desc'])
            ->setFromDate($coupon['start'])
            ->setToDate($coupon['end'])
            ->setIsActive(1)
            ->setUsesPerCustomer($coupon['max_redemptions'])
            ->setUsesPerCoupon($coupon['use_per_coupon'])
            ->setCustomerGroupIds($this->getAvailableCustomerGroupIds())
            ->setSimpleAction($coupon['discount_type'])
            ->setDiscountAmount($coupon['discount_amount'])
            ->setDiscountQty(1)
            ->setApplyToShipping($coupon['flag_is_free_shipping'])
            ->setTimesUsed($coupon['redemptions'])
            ->setWebsiteIds($this->getAvailableWebsiteIds())
            ->setCouponType(Rule::COUPON_TYPE_SPECIFIC)
            ->setCouponCode($coupon['code']);

        if ($this->resourceModelRule->save($this->shoppingCartRule)) {
            return $randStr;
        }

        return null;

    }

    /**
     * generate a random string for coupon code
     */
    public function generateRandomString()
    {
        $rex = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle($rex),0,8);
    }

    /**
     * Get all available customer group IDs
     *
     * @return int[]
     */
    protected function getAvailableCustomerGroupIds(): array
    {
        /** @var  CustomerGroupCollection $customerGroupCollection */
        $customerGroupCollection = $this->customerGroupCollectionFactory->create();
        $customerGroupCollection->addFieldToSelect('customer_group_id');
        return $customerGroupCollection->getAllIds();
    }

    /**
     * Get all available website IDs
     *
     * @return int[]
     */
    protected function getAvailableWebsiteIds(): array
    {
        $websiteIds = [];
        $websites = $this->storeManager->getWebsites();

        foreach ($websites as $website) {
            $websiteIds[] = $website->getId();
        }

        return $websiteIds;
    }
}
