<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\CustomerSearchParameter;
use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\Credentials;

/**
 * This interface describes MVNO API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Uprock\MvnoApi
 * @author  Etki <etki@etki.name>
 */
interface RequestGeneratorInterface
{
    /**
     * Creates new customer.
     *
     * @param Customer $customer Customer instance.
     *
     * @return Request Ready API request.
     * @since 0.1.0
     */
    public function createCustomer(Customer $customer);

    /**
     *
     *
     * @param Customer $customer
     *
     * @return Request Ready API request.
     * @since 0.1.0
     */
    public function modifyCustomer(Customer $customer);
    public function deleteCustomer($id, $detachSims = true);
    public function addAddress(Address $address);
    public function modifyAddress(Address $address);
    public function deleteAddress(Address $address);
    public function assignNewSim(
        $customerId,
        SimCard $simCard,
        $autoRetry = true
    );
    public function getCustomer(CustomerSearchParameter $parameter);
    public function getCustomers($query);
    public function approveCustomer($id);
    public function disapproveCustomer($id);
    public function blockSim($msisdn);
    public function unblockSim($msisdn);
    public function setSimLanguage($language);
    public function modifySimCard(SimCard $simCard);
    public function deleteSimCard(SimCard $simCard);
}
