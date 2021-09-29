<?php /** @noinspection ALL */

namespace RDewan\SignupOffer\Controller\Home;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Serialize\Serializer\Json;
use MailchimpMarketing\ApiClient;

class Subscribe implements HttpPostActionInterface
{
    /** @var Json */
    protected $json;

    /** @var RequestInterface */
    protected $request;

    /** @var ResultFactory */
    protected $resultFactory;

    /** @var  ApiClient */
    protected $mailchimp;

    protected $list_id;

    public function __construct(RequestInterface $request, ResultFactory $resultFactory, ApiClient $mailchimp)
    {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->mailchimp = $mailchimp;

        $this->mailchimp->setConfig([
            'apiKey' => '569981c21389c55575bf3b1d89badaa7-us6',
            'server' => 'us6'
        ]);
        $this->list_id = '8d23424154';
    }

    public function execute()
    {
        $resultResponse = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        /**
         * create md5 hash from email
         */
        $subscriber_hash = md5(strtolower($this->request->getParam('email')));

        /**
         * catch the exception here. If email does not exist it will throw error
         */
        try {
            /** check the audience subscription status */
            $result = $this->mailchimp->lists->getListMember($this->list_id, $subscriber_hash);

            /** if response is unsubscribed update the audience to subscribe list*/
            if ($result->{'status'} === 'unsubscribed') {
                try {
                    /** update audience subscriber status */
                    $response = $this->mailchimp->lists
                        ->updateListMember($this->list_id, $subscriber_hash, ["status" => "subscribed"]);

                    /** update audience TAG */
                    try {
                        $this->mailchimp->lists->updateListMemberTags($this->list_id, $response->id, [
                            "tags" => [
                                [
                                    "name" => "SignupOffer",
                                    "status" => "active"
                                ]
                            ]
                        ]);

                        /** return success */
                        return $resultResponse->setHttpResponseCode(201)->setData([
                            'success' => true,
                            'message' => 'Thank you for your subscription',
                            'subscriber_hash' => $subscriber_hash
                        ]);
                    } catch (\Exception $e) {
                        return $resultResponse->setData(['success' => false, $e->getMessage()]);
                    }
                } catch (\Exception $e) {
                    return $resultResponse->setData(['success' => false, $e->getMessage()]);
                }
            } /** user was cleaned as a result of email bounce */
            elseif ($result->{'status'} === 'cleaned') {
                return $resultResponse->setHttpResponseCode(400)->setData(
                    [
                        "success" => false,
                        "message" => 'Sorry! The contact bounced and was removed from the list.'
                    ]
                );
            }

            /** user has already subscribed */
            return $resultResponse->setHttpResponseCode(400)->setData(
                [
                    "success" => false,
                    "message" => 'Sorry! You have already subscribed.'
                ]
            );
        } catch (\Exception $e) {
            if ($e->getCode() === 404) {
                try {
                    /** create new audience */
                    $response = $this->mailchimp->lists->addListMember($this->list_id, [
                        "email_address" => $this->request->getParam('email'),
                        "status" => "subscribed",
                        "merge_fields" => [
                            "FNAME" => $this->request->getParam('first_name'),
                            "LNAME" => $this->request->getParam('last_name'),
                            "BIRTHDAY" => $this->request->getParam('dob'),
                            "GENDER" => $this->request->getParam('gender'),
                        ]
                    ]);

                    try {
                        /** update audience TAG */
                        $this->mailchimp->lists->updateListMemberTags($this->list_id, $response->id, [
                            "tags" => [
                                [
                                    "name" => "SignupOffer",
                                    "status" => "active"
                                ]
                            ]
                        ]);

                        /** return success */
                        return $resultResponse->setHttpResponseCode(201)->setData([
                            'success' => true,
                            'message' => 'Thank you for your subscription',
                            'subscriber_hash' => $subscriber_hash
                        ]);
                    } catch (\Exception $e) {
                        return $resultResponse->setData(['success' => false, $e->getMessage()]);
                    }
                } catch (\Exception $e) {
                    /** if the audience was deleted permanently return custom error message */
                    if (strpos($e->getMessage(), 'was permanently deleted and cannot be')) {
                        $response = $resultResponse->setHttpResponseCode($e->getCode());
                        return $response->setData(
                            ['success' => false, 'message' => 'Email was permanently deleted and cannot be resubscribe']
                        );
                    }
                    return $resultResponse->setData(['success' => false, $e->getMessage()]);
                }
            } else {
                return $resultResponse->setData(['success' => false, '$e->getMessage()']);
            }
        }
    }

    /*
     * ping mailchimp server
     */
    public function pingMailchimpServer()
    {
        return $this->mailchimp->ping->get();
    }
}
