<?php

namespace Etki\MvnoApiClient;

use Etki\MvnoApiClient\Entity\Address;
use Etki\MvnoApiClient\Entity\Customer;
use Etki\MvnoApiClient\Exception\ApiRequestFailureException;
use Etki\MvnoApiClient\SearchCriteria\MsisdnSearchCriteria;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Transport\ClientInterface;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\TransportInterface;

/**
 * The very very client.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class ApiClient implements LightweightApiClientInterface
{
    /**
     * Credentials required to perform API requests.
     *
     * @type Credentials
     * @since 0.1.0
     */
    protected $credentials;
    /**
     * HTTP transport.
     *
     * @type TransportInterface
     * @since 0.1.0
     */
    protected $transport;
    /**
     * URL which will be used to query the API.
     *
     * @type string
     * @since 0.1.0
     */
    protected $apiUrl = 'https://api.nakasolutions.com/mvno/json';

    /**
     * Initializes client.
     *
     * @param Credentials $credentials Connection credentials.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(Credentials $credentials = null)
    {
        if ($credentials) {
            $this->setCredentials($credentials);
        }
    }

    /**
     * Sets credentials.
     *
     * @param Credentials $credentials API connection credentials.
     *
     * @return void
     * @since 0.1.0
     */
    public function setCredentials(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }


    /**
     * Sets transport.
     *
     * @param TransportInterface $transport New transport.
     *
     * @return void
     * @since 0.1.0
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Calls method by it's name.
     *
     * @param string $name Method name.
     * @param array  $data Method parameters.
     *
     * @return ApiResponse Response data.
     * @since 0.1.0
     */
    public function callMethod($name, array $data)
    {
        $request = new ApiRequest;
        $data['apiKey'] = $this->credentials->getApiKey();
        $request->setData($data);
        $request->setMethodName($name);
        $request->setCredentials($this->credentials);
        $httpRequest = $request->createHttpRequest();
        $response = $this->transport->sendRequest($httpRequest);
        $apiResponse = ApiResponse::createFromHttpResponse($response);
        $data = $apiResponse->getData();
        if (isset($data['exception'])) {
            $message = sprintf(
                'API request has failed. Returned response: ' .
                    '[exception: `%s`, origin: `%s`]',
                $data['exception'],
                $data['fault']
            );
            throw new ApiRequestFailureException($message, $data['fault']);
        }
        return $apiResponse;
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
        $address->assertAllPropertiesSetExcept(array('id'));
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
    public function approveCustomer($customerId)
    {
        if ($customerId instanceof Customer) {
            $customerId = $customerId->getId();
        }
        $data = array(
            'customerId' => $customerId,
            'approved' => true,
        );
        return $this->callMethod('setIdApproved', $data);
    }

    public function searchMsisdn(MsisdnSearchCriteria $criteria)
    {
        $data = $criteria->getProperties();
        return $this->callMethod('searchMsisdn', $data);
    }
}
