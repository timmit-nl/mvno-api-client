<?php

namespace Etki\MvnoApiClient;

use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Entity\Customer;

/**
 * Lightweight interface for realizing current tasks. Should be removed from
 * repository in near future.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
interface LightweightApiClientInterface
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
     * @param int $id Customer ID.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function approveCustomer($id);

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
}
