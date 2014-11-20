<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Credentials;
use Etki\MvnoApiClient\Transport\TransportInterface;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiResponse;

/**
 * This is low-level API that directly implements methods specified by API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Client
 * @author  Etki <etki@etki.name>
 */
class LowLevelApiClient implements LowLevelClientInterface
{
    protected $apiUrl;
    protected $credentials;
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
}
