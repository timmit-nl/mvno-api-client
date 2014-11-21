<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\Exception\ApiOperationFailureException;
use Etki\MvnoApiClient\Transport\TransportInterface;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Exception\ApiRequestFailureException;
use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;

/**
 * This is low-level API that directly implements methods specified by API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Client
 * @author  Etki <etki@etki.name>
 */
class LowLevelApiClient extends AbstractApiClient implements
    LowLevelApiClientInterface
{
    /**
     * Creates customer,
     *
     * @param Customer $customer Customer structure.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function createCustomer(Customer $customer)
    {
        $customer->assertAllPropertiesSetExcept('id');
        $data = array(
            'email' => $customer->getEmail(),
            'password' => $customer->getPassword(),
            'title' => $customer->getTitle(),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'language' => $customer->getLanguage(),
            'identificationNumber' => $customer->getIdentificationNumber(),
            'identificationType' => $customer->getIdentificationType(),
            'nationality' => $customer->getNationality(),
            'birthDate' => $customer->getBirthDate(),
            'confirmed' => $customer->getConfirmed(),
        );
        return $this->callMethod('addCustomer', $data);
    }

    /**
     * Sets customer approve status.
     *
     * @param int|Customer  $customerId Customer ID.
     * @param bool          $status     Approve status (true/false).
     *
     * @throws ApiOperationFailureException Thrown in case API hasn't report
     *                                      successful operation.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function setIdApproved($customerId, $status)
    {
        if ($customerId instanceof Customer) {
            $customerId = $customerId->getId();
        }
        $data = array(
            'customerId' => $customerId,
            'approved' => $status,
        );
        $response = $this->callMethod('setIdApproved', $data);
        $data = $response->getData();
        if (!$data['responseStatus']) {
            throw new ApiOperationFailureException;
        }
        return $response;
    }

    /**
     * Activates initial customer subscription.
     *
     * @param string $msisdn Sim card MSISDN.
     *
     * @return ApiResponse Response
     * @since 0.1.0
     */
    public function activateInitialSubscription($msisdn)
    {
        $data = array('msisdn' => $msisdn,);
        return $this->callMethod('activateInitialSubscription', $data);
    }

    /**
     * Adds new customer address.
     *
     * @param Address $address Address to add.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function addAddress(Address $address)
    {
        $excludedProperties = array('id',);
        $address->assertAllPropertiesSetExcept($excludedProperties);
        $data = array(
            'customerId' => $address->getCustomerId(),
            'email' => $address->getEmail(),
            'title' => $address->getTitle(),
            'firstName' => $address->getFirstName(),
            'lastName' => $address->getLastName(),
            'company' => $address->getCompany(),
            'street' => $address->getStreet(),
            'poBox' => $address->getPostOfficeBox(),
            'postCode' => $address->getPostCode(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'additional' => $address->getAdditionalInformation(),
            'country' => $address->getCountryCode(),
            'phone' => $address->getPhone(),
            'fax' => $address->getFax(),
        );
        return $this->callMethod('addAddress', $data);
    }

    /**
     * Performs MSISDN search according to criteria.
     *
     * @param MsisdnSearchCriteria $criteria Criteria that describes what to
     *                                       search.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function searchMsisdn(MsisdnSearchCriteria $criteria)
    {
        $data = $criteria->getProperties();
        return $this->callMethod('searchMsisdn', $data);
    }

    /**
     * Assigns new sim card to customer.
     *
     * @param SimCard $simCard Sim card definition.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function assignNewSim(SimCard $simCard)
    {
        $simCard->assertAllPropertiesSet();
        $data = array(
            'customerId' => $simCard->getCustomerId(),
            'msisdn' => $simCard->getMsisdn(),
            'iccid' => $simCard->getIccid(),
            'puk' => $simCard->getPuk(),
            'verifyOnly' => $simCard->getVerifyOnly(),
        );
        return $this->callMethod('assignNewSim', $data);
    }

    /**
     * Recharges sim card balance.
     *
     * @param string $msisdn      Sim card MSISDN.
     * @param int    $amount      Amount of money, in 10000th of measure unit
     *                            (ex.: 0.01 euro = 100, 1 = 0.0001 euro)
     * @param int    $serviceCode Service code specifying the source and purpose
     *                            of the message.
     * @param string $message     Optional message.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function recharge(
        $msisdn,
        $amount,
        $serviceCode,
        $message = null
    ) {
        $data = array(
            'msisdn' => $msisdn,
            'amount' => $amount,
            'serviceCode' => $serviceCode,
            'message' => $message,
        );
        return $this->callMethod('recharge', $data);
    }

    /**
     * Retrieves rates for calling from one country to another.
     *
     * @param string $fromCountry 3-letter country code.
     * @param string $toCountry   3-letter country code.
     *
     * @return ApiResponse API response.
     * @since 0,1,0
     */
    public function getRate($fromCountry, $toCountry) {}
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
    public function getRoamingRate($msisdn, $msrn, $destination) {}
    /**
     * {@inheritdoc}
     *
     * @param string[] $includedFeatures Features that sim card should have.
     * @param string[] $excludedFeatures Features that sim card must not have.
     *
     * @return ApiResponse API response.
     * @since 0.1.0
     */
    public function dispatchCard(
        array $includedFeatures,
        array $excludedFeatures
    ) {}
}
