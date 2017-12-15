<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Entity\SimCard;
use Etki\MvnoApiClient\Exception\Api\ApiOperationFailureException;
use Etki\MvnoApiClient\SearchCriteria\CustomerSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiRequestCollection;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Entity\LocalMsisdn;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use InvalidArgumentException;

/**
 * This is low-level API that directly implements methods specified by API.
 *
 * @version 0.1.1
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
        $customer->assertAllPropertiesSetExcept(
            array('id', 'state', 'sims', 'properties',)
        );
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
        return $this->callMethod('createCustomer', $data);
    }

    /**
     * {@inheritdoc}
     *
     * @param Customer|int $customerId Customer ID.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function deleteCustomer($customerId)
    {
        if ($customerId instanceof Customer) {
            $customerId->assertPropertySet('id');
            $customerId = $customerId->getId();
        }
        $data = array('customerId' => $customerId,);
        return $this->callMethod('deleteCustomer', $data);
    }

    /**
     * Retrieves customer data.
     *
     * @param CustomerSearchCriteria $criteria Criteria required to search for
     *                                         customer.
     *
     * @return ApiResponse Response data.
     * @since 0.1.0
     */
    public function getCustomer(CustomerSearchCriteria $criteria)
    {
        switch ($criteria->getType()) {
            case CustomerSearchCriteria::SEARCH_PARAMETER_ID:
                $data = array('customerId' => $criteria->getValue());
                break;
            case CustomerSearchCriteria::SEARCH_PARAMETER_EMAIL:
                $data = array('email' => $criteria->getValue());
                break;
            case CustomerSearchCriteria::SEARCH_PARAMETER_MSISDN:
                $data = array('msisdn' => $criteria->getValue());
                break;
        }
        /** @noinspection PhpUndefinedVariableInspection */
        return $this->callMethod('getCustomer', $data);
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
        return $this->callMethod('setIdApproved', $data);
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
        $excludedProperties = array(
            'id',
            'additionalInformation',
            'fax',
            'phone',
            'postOfficeBox',
            'company',
            'state',
        );
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
     * {@inheritdoc}
     *
     * @param int|Address $addressId Address ID.
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function deleteAddress($addressId)
    {
        if ($addressId instanceof Address) {
            $addressId->assertPropertySet('id');
            $addressId = $addressId->getId();
        }
        $data = array('addressId' => $addressId);
        return $this->callMethod('deleteAddress', $data);
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
        if (empty($data['countryCode'])) {
            $data['countryCode'] = MsisdnSearchCriteria::DEFAULT_COUNTRY_CODE;
        }
        return $this->callMethod('searchMsisdn', $data);
    }

    /**
     * get puk code of simcard
     *
     * @param SimCard $simCard Sim card definition.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function getPukSimCard(SimCard $simCard)
    {
        $simCard->assertPropertiesSet(array('iccid',));
        $data = array(
            'iccid' => $simCard->getIccid(),
        );
        return $this->callMethod('getCard', $data);
    }

    /**
     * get puk code of simcard
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
     * Assigns existing sim card to customer.
     *
     * @param SimCard $simCard Sim card definition.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function assignExistingSim(SimCard $simCard)
    {
        $simCard->assertPropertiesSet(array('customerId', 'msisdn',));
        $data = array(
            'customerId' => $simCard->getCustomerId(),
            'msisdn' => $simCard->getMsisdn(),
        );
        return $this->callMethod('assignExistingSim', $data);
    }

    /**
     * {@inheritdoc}
     *
     * @param Customer|int   $customerId Customer ID.
     * @param SimCard|string $msisdn     Sim card MSISDN.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function removeSim($customerId, $msisdn)
    {
        if ($customerId instanceof Customer) {
            $customerId->assertPropertySet('id');
            $customerId = $customerId->getId();
        }
        if ($msisdn instanceof SimCard) {
            $msisdn->assertPropertySet('msisdn');
            $msisdn = $msisdn->getMsisdn();
        }
        $data = array('customerId' => $customerId, 'msisdn' => $msisdn);
        return $this->callMethod('removeSim', $data);
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
    public function getRate($fromCountry, $toCountry)
    {
        $data = array();
        foreach (array('fromCountry', 'toCountry') as $var) {
            if (strlen($$var) !== 3) {
                $message = sprintf(
                    'Parameter `%s` has to be three-letter country code ' .
                    '(got `%s` instead)',
                    $var,
                    $$var
                );
                throw new InvalidArgumentException($message);
            }
            $data[$var] = $$var;
        }
        return $this->callMethod('getRate', $data);
    }
    /**
     * Gets roaming rate.
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
    public function getRoamingRate($msisdn, $msrn, $destination)
    {
        $data = array(
            'msisdn' => $msisdn,
            'msrn' => $msrn,
            'destination' => $destination,
        );
        return $this->callMethod('getRoamingRate', $data);
    }
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
    ) {
        $data = array(
            'includeFeature' => $includedFeatures,
            'excludeFeature' => $excludedFeatures
        );
        return $this->callMethod('dispatchCard', $data);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $msisdn Sim card MSISDN.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function getSubscriptions($msisdn)
    {
        $data = array('msisdn' => $msisdn);
        return $this->callMethod('getSubscriptions', $data);
    }

    /**
     * Returns phone balance.
     *
     * @param string $msisdn Sim card MSISDN.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function getBalance($msisdn)
    {
        $data = array('msisdn' => $msisdn);
        return $this->callMethod('getBalance', $data);
    }

    /**
     * Performs combined request.
     *
     * @param array $requests Requests in [method => parameters] format.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function combinedRequest(array $requests)
    {
        $collection = new ApiRequestCollection;
        foreach ($requests as $tuple) {
            $request = new ApiRequest;
            $request->setMethodName($tuple['method']);
            $parameters = $tuple['parameters'] ? $tuple['parameters'] : array();
            $request->setData($parameters);
            $request->setRequestId($collection->getSize() + 1);
            $collection->addRequest($request);
        }
        return $this->makeBatchRequest($collection);
    }

    /**
     * Pings service.
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function ping()
    {
        return $this->callMethod('ping', array());
    }

    /**
     * {@inheritdoc}
     *
     * @param string $subscriptionName subscriptionName.
     * @param string $msisdn Sim card MSISDN.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function activateSubscription($msisdn,$subscriptionName)
    {
        $data = array(
            'msisdn' => $msisdn,
            'subscriptionName' => $subscriptionName,
            'packageId' => NULL,
        );
        return $this->callMethod('activateSubscription', $data);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $subscriptionName subscriptionName.
     * @param string $msisdn Sim card MSISDN.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function activatePackage($msisdn,$packageId)
    {
        $data = array(
            'msisdn' => $msisdn,
            'subscriptionName' => '',
            'packageId' => $packageId,
        );
        return $this->callMethod('activateSubscription', $data);
    }

    /**
     * Creates customer,
     *
     * @param Customer $customer Customer structure.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function addLocalMsisdn(LocalMsisdn $localMsisdn)
    {
        $data = array(
            'msisdn' => $localMsisdn->getMsisdn(),
            'countryCode' => $localMsisdn->getCountryCode(),
            'verifyOnly' => $localMsisdn->getVerifyOnly(),
        );
        if($localMsisdn->getLocalMsisdn()){
            $data['newMsisdn'] = $localMsisdn->getLocalMsisdn();
        }
        $data['newMsisdn'] = '';
        return $this->callMethod('addMsisdn', $data);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $msisdn Sim card MSISDN.
     * @param string $displayedMsisdn displayedMsisdn.
     * @param boolean $cliShow cliShow.
     *
     * @return ApiResponse Data.
     * @since 0.1.0
     */
    public function setCliShow($msisdn,$cliShow=true,$displayedMsisdn='')
    {
        $data = array(
            'msisdn' => $msisdn,
            'cliShow' => $cliShow,
            'displayedMsisdn' => $displayedMsisdn,
        );
        return $this->callMethod('setCliShow', $data);
    }

    /**
     * Clears cache,
     *
     * @param string $method.
     *
     * @return ApiResponse Response.
     * @since 0.1.0
     */
    public function clearCache($method)
    {
        $data = array(
            'method' => $method,
        );
        return $this->callMethod('clearCache', $data);
    }


}
