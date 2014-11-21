<?php

namespace Etki\MvnoApiClient;

use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\Exception\ApiOperationFailureException;
use Etki\MvnoApiClient\Exception\ApiRequestFailureException;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Transport\FileGetContentsTransport;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\TransportInterface;
use Etki\MvnoApiClient\Client\LowLevelApiClientInterface;
use Etki\MvnoApiClient\Client\LowLevelApiClient;
use Etki\MvnoApiClient\Client\HighLevelApiClientInterface;
use BadMethodCallException;

/**
 * The very very client.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class HighLevelApiClient implements HighLevelApiClientInterface
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
     * @param string      $apiUrl      API url.
     * @param Credentials $credentials Connection credentials.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct($apiUrl, Credentials $credentials)
    {
        $this->lowLevelApi = new LowLevelApiClient;
        $this->lowLevelApi->setCredentials($credentials);
        $this->lowLevelApi->setApiUrl($apiUrl);
        $this->lowLevelApi->setTransport(new FileGetContentsTransport);
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
    public function addCustomerSim(SimCard $simCard)
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
     * @return void
     * @since 0.1.0
     */
    public function activateInitialSubscription($msisdn)
    {
        $this->lowLevelApi->activateInitialSubscription($msisdn);
    }

    /**
     * Creates nw customer.
     *
     * @param Customer $customer Customer entity.
     * @param Address  $address  Address entity.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function createCustomer(Customer $customer, Address $address)
    {
        $apiResponse = $this->lowLevelApi->createCustomer($customer);
        $customerData = $apiResponse->getDataItem('customer');
        $address->setCustomerId($customerData['id']);
        $this->addAddress($address);
        return $this->approveCustomer($customerData['id']);
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
        return reset($data);
    }

    /**
     * {@inheritdoc}
     *
     * @param SimCard $simCard
     * @param int     $retries
     *
     * @throws ApiOperationFailureException Thrown if API couldn't assign random
     * msisdn in provided number of retries.
     *
     * @return SimCard Sim card instance.
     * @since 0.1.0
     */
    public function autoAssignNewSim(SimCard $simCard, $retries = 5)
    {
        $msisdn = $this->getNewMsisdn();
        $simCard = clone $simCard;
        $initialRetries = $retries;
        while ($retries !== 0) {
            try {
                $simCard->setMsisdn($msisdn);
                $this->assignNewSim($simCard);
                return $simCard;
            } catch (ApiOperationFailureException $e) {
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
        return $this->lowLevelApi->recharge($msisdn, $amount, $serviceCode, $message);
    }
}
