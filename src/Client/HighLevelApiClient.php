<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\RateData;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\Entity\SimCardBalance;
use Etki\MvnoApiClient\Entity\Subscription;
use Etki\MvnoApiClient\Exception\Api\ApiOperationFailureException;
use Etki\MvnoApiClient\Log\ApiLoggerAwareInterface;
use Etki\MvnoApiClient\Log\ApiLoggerInterface;
use Etki\MvnoApiClient\SearchCriteria\CustomerSearchCriteria;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Transport\CurlTransport;
use Etki\MvnoApiClient\Transport\TransportInterface;

/**
 * The very very client.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class HighLevelApiClient implements
    HighLevelApiClientInterface,
    ApiLoggerAwareInterface
{
    /**
     * Low-level API handle.
     *
     * @type LowLevelApiClientInterface
     * @since 0.1.0
     */
    protected $lowLevelApi;

    /**
     * Initializes client.
     *
     * @param string             $apiUrl      API url.
     * @param Credentials        $credentials Connection credentials.
     * @param TransportInterface $transport   Transport to be used.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        $apiUrl,
        Credentials $credentials,
        TransportInterface $transport = null
    ) {
        $this->lowLevelApi = new LowLevelApiClient;
        $this->lowLevelApi->setCredentials($credentials);
        $this->lowLevelApi->setApiUrl($apiUrl);
        if (!$transport) {
            $transport = new CurlTransport;
        }
        $this->lowLevelApi->setTransport($transport);
    }

    /**
     * Adds new request logger.
     *
     * @param ApiLoggerInterface $logger Logger.
     *
     * @return void
     * @since 0.1.0
     */
    public function setRequestLogger(ApiLoggerInterface $logger)
    {
        $this->lowLevelApi->setRequestLogger($logger);
    }

    /**
     * Creates new customer.
     *
     * @param Customer $customer Customer entity.
     * @param Address  $address  Address entity.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function createCustomer(Customer $customer, Address $address)
    {
        $criteria = new CustomerSearchCriteria(
            CustomerSearchCriteria::SEARCH_PARAMETER_EMAIL,
            $customer->getEmail()
        );
        try {
            $apiResponse = $this->lowLevelApi->getCustomer($criteria);
        } catch (ApiOperationFailureException $e) {}
        if (!isset($apiResponse) || !$apiResponse->getDataItem('customer')) {
            $apiResponse = $this->lowLevelApi->createCustomer($customer);
        }
        $customerData = $apiResponse->getDataItem('customer');
        $address->setCustomerId($customerData['id']);
        $customer->setId($customerData['id']);
        $addressResponse = $this->addAddress($address);
        $approvalResponse = $this->approveCustomer($customerData['id']);
        return $customer;
    }

    /**
     * Deletes customer by his ID.
     *
     * @param Customer|int $customerId
     * @param bool         $detachSims
     *
     * @todo refactor, method is quite heavy.
     *
     * @return ApiResponse|void
     * @since 0.1.0
     */
    public function deleteCustomer($customerId, $detachSims = true)
    {
        if ($customerId instanceof Customer) {
            $customerId->assertPropertySet('id');
            $customerId = $customerId->getId();
        }
        if ($detachSims) {
            $response = $this->getCustomer($customerId);
            $customer = new Customer($response->getDataItem('customer'));
            if ($customer->getSims()) {
                foreach ($customer->getSims() as $msisdn) {
                    $data = array('msisdn' => $msisdn, 'customerId' => $customerId);
                    $simCard = new SimCard($data);
                    $this->detachCustomerSimCard($simCard);
                }
            }
        }
        return $this->lowLevelApi->deleteCustomer($customerId);
    }

    /**
     * Retrieves customer using his ID.
     *
     * @param int $customerId Customer ID.
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function getCustomer($customerId)
    {
        $criteria = new CustomerSearchCriteria(
            CustomerSearchCriteria::SEARCH_PARAMETER_ID,
            $customerId
        );
        return $this->lowLevelApi->getCustomer($criteria);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $email Customer email.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function getCustomerByEmail($email)
    {
        $criteria = new CustomerSearchCriteria(
            CustomerSearchCriteria::SEARCH_PARAMETER_EMAIL,
            $email
        );
        return $this->lowLevelApi->getCustomer($criteria);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $msisdn MSISDN to search with.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function getCustomerByMsisdn($msisdn)
    {
        $criteria = new CustomerSearchCriteria(
            CustomerSearchCriteria::SEARCH_PARAMETER_MSISDN,
            $msisdn
        );
        return $this->lowLevelApi->getCustomer($criteria);
    }

    /**
     * Saves customer as approved.
     *
     * @param Customer|int $customerId Customer ID or just customer instance.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function approveCustomer($customerId)
    {
        return $this->lowLevelApi->setIdApproved($customerId, true);
    }

    /**
     * Saves customer as customer without approved status.
     *
     * @param Customer|int $customerId Customer ID or just customer instance.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function disapproveCustomer($customerId)
    {
        return $this->lowLevelApi->setIdApproved($customerId, false);
    }

    /**
     * {@inheritdoc}
     *
     * @param SimCard $simCard Sim card definition.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function addCustomerSimCard(SimCard $simCard)
    {
        $simCard = clone $simCard;
        $simCard->setVerifyOnly(false);
        if ($simCard->getMsisdn()) {
            $msisdn = $simCard->getMsisdn();
            $this->lowLevelApi->assignNewSim($simCard);
        } else {
            $simCard = $this->autoAssignNewSim($simCard);
            $msisdn = $simCard->getMsisdn();
        }
        $this->lowLevelApi->activateInitialSubscription($msisdn);
        return $this->lowLevelApi->assignNewSim($simCard);
    }

    /**
     * Detaches sim card from customer.
     *
     * @param SimCard $simCard Sim card instance with `msisdn` and `customerId`.
     *
     * @return bool|ApiResponse
     * @since 0.1.0
     */
    public function detachCustomerSimCard(SimCard $simCard)
    {
        $simCard->assertPropertiesSet(array('customerId', 'msisdn'));
        return $this->lowLevelApi->removeSim(
            $simCard->getCustomerId(),
            $simCard->getMsisdn()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param SimCard $simCard Sim card to validate.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function validateNewSimAssignment(SimCard $simCard)
    {
        $simCard = clone $simCard;
        $simCard->setVerifyOnly(true);
        return $this->lowLevelApi->assignNewSim($simCard);
    }

    /**
     * Activates initial subscription.
     *
     * @param string $msisdn MSISDN to activate,
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function activateInitialSubscription($msisdn)
    {
        return $this->lowLevelApi->activateInitialSubscription($msisdn);
    }

    /**
     * {@inheritdoc}
     *
     * @param MsisdnSearchCriteria $criteria
     *
     * @return string New MSISDN.
     * @since 0.1.0
     */
    public function getNewMsisdn(MsisdnSearchCriteria $criteria = null)
    {
        if (!$criteria) {
            $criteria = new MsisdnSearchCriteria;
        }
        $criteria->setUnassigned(true);
        $response = $this->lowLevelApi->searchMsisdn($criteria);
        $data = $response->getData();
        $msisdns = $data['msisdns'];
        if (is_array($msisdns)) {
            return reset($msisdns);
        }
        throw new ApiOperationFailureException(
            'Couldn\'t find any sim matching provided criteria'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param SimCard $simCard Sim card instance.
     * @param int     $retries Number of retries. Set to negative to get
     *                         nearly-infinite retries.
     *
     * @throws ApiOperationFailureException Thrown if API couldn't assign random
     * msisdn in provided number of retries.
     *
     * @return SimCard Sim card instance.
     * @since 0.1.0
     */
    public function autoAssignNewSim(SimCard $simCard, $retries = 5)
    {
        $criteria = new MsisdnSearchCriteria();
        $msisdn = $this->getNewMsisdn($criteria);
        $simCard = clone $simCard;
        $initialRetries = $retries;
        while ($retries !== 0) {
            try {
                $simCard->setMsisdn($msisdn);
                $this->lowLevelApi->assignNewSim($simCard);
                return $simCard;
            } catch (ApiOperationFailureException $e) {
                $msisdn = $this->getNewMsisdn($criteria);
                $retries--;
            }
        }
        $message = sprintf(
            'Failed to assign new sim in `%d` retries',
            $initialRetries
        );
        throw new ApiOperationFailureException($message);
    }

    /**
     * {@inheritdoc}
     *
     * @param Address $address Address to add.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function addAddress(Address $address)
    {
        return $this->lowLevelApi->addAddress($address);
    }

    /**
     * Deletes provided address.
     *
     * @param Address|int $address Address ID.
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function deleteAddress($address)
    {
        return $this->lowLevelApi->deleteAddress($address);
    }

    /**
     * Recharges account balance.
     *
     * @param string $msisdn      Sim card MSISDN.
     * @param int    $amount      Money (in x10000 of nominal).
     * @param int    $serviceCode Service code.
     * @param null   $message     Additional message.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function recharge($msisdn, $amount, $serviceCode, $message = null)
    {
        return $this->lowLevelApi->recharge(
            $msisdn,
            $amount,
            $serviceCode,
            $message
        );
    }

    /**
     * Gets rates between two countries.
     *
     * @param string $fromCountry Country interactions are being made from.
     * @param string $toCountry   Country calls are made to.
     *
     * @return RateData[] List of rate data.
     * @since 0.1.0
     */
    public function getRate($fromCountry, $toCountry)
    {
        $response = $this->lowLevelApi->getRate($fromCountry, $toCountry);
        $data = array();
        $keys = array(
            'rate' => 'rate',
            'setup' => 'setup',
            'ratelocal' => 'rateLocal',
            'setuplocal' => 'setupLocal',
        );
        foreach ($keys as $apiKey => $appKey) {
            $data[$appKey] = null;
            if ($response->hasDataItem($apiKey)
                && $response->getDataItem($apiKey)
            ) {
                $data[$appKey] = new RateData($response->getDataItem($apiKey));
            }
        }
        return $data;
    }

    /**
     * Returns list of cross-rates for selected countries.
     *
     * @param string[] $countries List of country 3-letter ISO-3166 codes.
     *
     * @return array List of lists of rates for calls between two countries.
     * @since 0.1.0
     */
    public function getCrossRates(array $countries)
    {
        $length = 3; //sizeof($countries);
        $countries = array_unique($countries);
        $rates = array();
        $failedCountries = array();
        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j < $length; $j++) {
                if ($j === $i || in_array($i, $failedCountries)
                    || in_array($j, $failedCountries)
                ) {
                    continue;
                }
                $countryA = $countries[$i];
                $countryB = $countries[$j];
                $key = $countryA . ':' . $countryB;
                try {
                    $rates[$key] = array(
                        'from' => $countryA,
                        'to' => $countryB,
                        'rates' => $this->getRate($countryA, $countryB)
                    );
                    echo 'Successfully got rates for ' . $key . PHP_EOL;
                } catch (ApiOperationFailureException $e) {
                    // @todo add proper logging
                    echo 'Failed to get rates for ' . $key . PHP_EOL;
                }
            }
        }
        return $rates;
    }

    /**
     * Gets roaming rate.
     *
     * @param string $msisdn      Sim card MSISDN.
     * @param string $msrn        Partial (at least country code prefix) or complete roaming number.
     * @param string $destination Partial (at least country code prefix) or complete destination number.
     *
     * @return int Roaming rate.
     * @since 0.1.0
     */
    public function getRoamingRate($msisdn, $msrn, $destination)
    {
        $response = $this->lowLevelApi->getRoamingRate(
            $msisdn,
            $msrn,
            $destination
        );
        return $response->getDataItem('rate');
    }

    /**
     * Returns subscriptions for particular sim card.
     *
     * @param string $msisdn Sim card MSISDN.
     *
     * @todo refactor
     * @return Subscription[][] Subscribed / available / all subscriptions list.
     * @since 0.1.0
     */
    public function getSubscriptions($msisdn)
    {
        $response = $this->lowLevelApi->getSubscriptions($msisdn);
        $subscriptions = array(
            'available' => array(),
            'subscribed' => array(),
            'all' => array(),
        );
        if ($response->hasDataItem('subscribed')) {
            $subscribed = $response->getDataItem('subscribed');
            if ($subscribed) {
                foreach ($subscribed as $subscriptionData) {
                    $subscription = new Subscription($subscriptionData);
                    $subscriptions['subscribed'][] = $subscription;
                    $subscriptions['all'][] = $subscription;
                }

            }
        }
        if ($response->hasDataItem('available')) {
            $available = $response->getDataItem('available');
            if ($available) {
                foreach ($available as $subscriptionData) {
                    $subscription = new Subscription($subscriptionData);
                    $subscriptions['available'][] = $subscription;
                    $subscriptions['all'][] = $subscription;
                }
            }
        }
        return $subscriptions;
    }

    /**
     * Retrieves sim card balance
     *
     * @param string $msisdn Sim card MSISDN.
     *
     * @return SimCardBalance
     * @since 0.1.0
     */
    public function getBalance($msisdn)
    {
        $response = $this->lowLevelApi->getBalance($msisdn);
        $balance = new SimCardBalance;
        $balance->setBalance($response->getDataItem('balance'));
        $balance->setCurrency($response->getDataItem('currency'));
        $balance->setIsPostPaid($response->getDataItem('postpaid'));
        return $balance;
    }

    /**
     * Removes customer sim card.
     *
     * @param int    $customerId Customer ID.
     * @param string $msisdn     Sim card MSISDN.
     *
     * @return bool
     * @since 0.1.0
     */
    public function removeSim($customerId, $msisdn)
    {
        $response = $this->lowLevelApi->removeSim($customerId, $msisdn);
        return $response->isSuccessful();
    }

    /**
     * Sends lot of requests at once.
     *
     * @param ApiRequest[] $requests
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function combinedRequest(array $requests)
    {
        $payload = array();
        foreach ($requests as $request) {
            $payload[] = array(
                'method' => $request->getMethodName(),
                'parameters' => $request->getData(),
            );
        }
        return $this->lowLevelApi->combinedRequest($payload);
    }
}
