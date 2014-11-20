<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiResponse;

/**
 * This interface describes low-level API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Client
 * @author  Etki <etki@etki.name>
 */
interface LowLevelClientInterface
{
    /**
     * Creates new customer.
     *
     * @param Customer $customer Customer instance.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function createCustomer(Customer $customer);

    /**
     * Saves customer address.
     *
     * @param Address $address Address to save.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function addAddress(Address $address);

    /**
     * Approves customer by his ID.
     *
     * @param int  $customerId Customer ID.
     * @param bool $status     New customer status.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function setIdApproved($customerId, $status);

    /**
     * Searches MSISDNs.
     *
     * @param MsisdnSearchCriteria $criteria Search criteria.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function searchMsisdn(MsisdnSearchCriteria $criteria);

    /**
     * Assigns new sim card to customer.
     *
     * @param SimCard $simCard Sim card data.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function assignNewSim(SimCard $simCard);

    /**
     * Activates initial subscription.
     *
     * @param string $msisdn MSISDN to activate.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function activateInitialSubscription($msisdn);
    /**
     * Recharges sim card balance.
     *
     * @param string $msisdn      Sim card MSISDN.
     * @param int    $amount      Amount of money to recharge with.
     * @param int    $serviceCode Service code specifying
     * @param null   $message     Custom message to attach. mau be overwritten
     *                            by service.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function recharge($msisdn, $amount, $serviceCode, $message = null);
}
