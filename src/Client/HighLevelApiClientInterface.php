<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\SearchCriteria\CustomerSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Exception\ApiOperationFailureException;

/**
 * This interface describes MVNO API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Uprock\MvnoApi
 * @author  Etki <etki@etki.name>
 */
interface HighLevelApiClientInterface
{
    /**
     * Creates new customer.
     *
     * @param Customer $customer Customer instance.
     * @param Address  $address Customer address.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function createCustomer(Customer $customer, Address $address);

    /**
     * Modifies customer with new data.
     *
     * @param Customer $customer Customer to be modified.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    //public function modifyCustomer(Customer $customer);

    /**
     * Deletes customer.
     *
     * @param int|Customer $id         Customer ID or customer instance.
     * @param bool         $detachSims Detach sim card before customer deletion.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function deleteCustomer($id, $detachSims = true);

    /**
     * Adds new address,
     *
     * @param Address $address Address to add.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function addAddress(Address $address);

    /**
     * Modify address.
     *
     * @param Address $address
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function modifyAddress(Address $address);

    /**
     * Delete address
     *
     * @param int|Address $id Address ID or address entity.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function deleteAddress($id);

    /**
     * Assigns new sim card to customer.
     *
     * @param SimCard $simCard Sim card entity instance.
     *
     * @throws ApiOperationFailureException
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function addCustomerSimCard(SimCard $simCard);

    /**
     * Detaches sim card.
     *
     * @param SimCard $simCard Sim card to detach.
     *
     * @return bool
     * @since 0.1.0
     */
    public function detachCustomerSimCard(SimCard $simCard);

    /**
     * Automatically assigns new sim card to customer.
     *
     * @param SimCard $simCard
     *
     * @return string New sim card MSISDN.
     * @since 0.1.0
     */
    public function autoAssignNewSim(SimCard $simCard);

    /**
     * Fetches customer data.
     *
     * @param int $customerId Customer id.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function getCustomer($customerId);

    /**
     * Fetches customer data using email.
     *
     * @param string $email Customer email.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function getCustomerByEmail($email);

    /**
     * Retrieves customer by MSISDN registered with him.
     *
     * @param string $msisdn Sim card MSISDN.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function getCustomerByMsisdn($msisdn);

    /**
     * Returns customers.
     *
     * @param string $query Search query, first name / last name / combined /
     *                      email address
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function getCustomers($query);

    /**
     * Approve customer by his ID.
     *
     * @param int|Customer $customerId Customer ID or customer instance.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function approveCustomer($customerId);

    /**
     * Revoke customer approval.
     *
     * @param int|Customer $customerId Customer ID or customer instance.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function disapproveCustomer($customerId);

    /**
     * Block sim card.
     *
     * @param string $msisdn Sim card's MSISDN.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function blockSimCard($msisdn);

    /**
     * Unblock sim card
     *
     * @param string $msisdn Sim card's MSISDN.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function unblockSimCard($msisdn);

    /**
     * Sets sim card language,
     *
     * @param string $language Language to set.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function setSimCardLanguage($language);

    /**
     * Modify sim card using provided data.
     *
     * @param SimCard $simCard Sim card instance.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function modifySimCard(SimCard $simCard);

    /**
     * Deletes sim card by it's ID.
     *
     * @param int|SimCard $simCardId Sim card ID or sim card instance containing
     *                               the ID.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    //public function deleteSimCard($simCardId);

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
     * Activates subscriptions. Should be run immediately after `addNewSim()`.
     *
     * @param string $msisdn
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function activateInitialSubscription($msisdn);

    /**
     * Retrieves new msisdn.
     *
     * @param MsisdnSearchCriteria $criteria Search criteria.
     *
     * @return string.
     * @since 0.1.0
     */
    public function getNewMsisdn(MsisdnSearchCriteria $criteria = null);
}
