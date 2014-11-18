<?php

namespace Etki\MvnoApiClient;

use Etki\MvnoApiClient\Exception\ApiRequestFailureException;
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
class ApiClient implements ClientInterface
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
     * @return array Response data.
     * @since 0.1.0
     */
    public function callMethod($name, array $data)
    {
        $request = new ApiRequest;
        $request->setData($data);
        $request->setMethodName($name);
        $request->setCredentials($this->credentials);
        $httpRequest = $request->createHttpRequest();
        $response = $this->transport->sendRequest($httpRequest);
        $data = $response->getData();
        if (isset($data['exception'])) {
            $message = sprintf(
                'API request has failed. Returned response: [exception: %s, ' .
                    'origin: %s]',
                $data['exception'],
                $data['fault']
            );
            throw new ApiRequestFailureException($message, $data['fault']);
        }
        return $response;
    }
}
