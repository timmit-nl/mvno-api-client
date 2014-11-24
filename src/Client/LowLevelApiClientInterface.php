<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\SearchCriteria\CustomerSearchCriteria;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Exception\ApiOperationFailureException;

/**
 * This interface describes low-level API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Client
 * @author  Etki <etki@etki.name>
 */
interface LowLevelApiClientInterface
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
     * Deletes customer.
     *
     * @param int|Customer $customerId Customer ID or whole customer object.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function deleteCustomer($customerId);

    /**
     * Retrieves customer by search criteria.
     *
     * @param CustomerSearchCriteria $criteria Search criteria.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function getCustomer(CustomerSearchCriteria $criteria);

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
     * Deletes selected address.
     *
     * @param int|Address Address ID or Address ID-containing Address entity.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function deleteAddress($addressId);

    /**
     * Approves customer by his ID.
     *
     * @param int  $customerId Customer ID.
     * @param bool $status     New customer status.
     *
     * @throws ApiOperationFailureException Thrown in case operation hasn't
     * finished correctly.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function setIdApproved($customerId, $status);

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
     * Assigns existing sim card to customer.
     *
     * @param SimCard $simCard Sim card to add. Customer ID should be passed as
     *                         one of sim card fields.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function assignExistingSim(SimCard $simCard);

    /**
     * Removes sim card from customer.
     *
     * @param int|Customer   $customerId Customer ID or whole customer object.
     * @param string|SimCard $msisdn     MSISDN or sim card containing requested
     *                                   msisdn.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function removeSim($customerId, $msisdn);

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

    /**
     * Retrieves rates for calling from one country to another.
     *
     * @param string $fromCountry 3-letter country code.
     * @param string $toCountry   3-letter country code.
     *
     * @return ApiResponse API response,
     * @since 0.1.0
     */
    public function getRate($fromCountry, $toCountry);

    /**
     * Get roaming rates.
     *
     * @param string $msisdn      Sim card MSISDN.
     * @param string $msrn        Roaming zone (set as MSISDN, country code
     *                            prefix is required).
     * @param string $destination Destination number (set as MSISDN, country
     *                            code prefix is required).
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function getRoamingRate($msisdn, $msrn, $destination);

    /**
     * Dispatch (reserve?) sim card.
     *
     * @param string[] $includedFeatures Features that have to be present for
     *                                   sim card.
     * @param string[] $excludedFeatures Features that have to be not present
     *                                   for sim card.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function dispatchCard(
        array $includedFeatures,
        array $excludedFeatures
    );
}
