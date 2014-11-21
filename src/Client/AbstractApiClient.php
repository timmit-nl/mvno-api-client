<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Credentials;
use Etki\MvnoApiClient\Exception\ApiOperationFailureException;
use Etki\MvnoApiClient\Transport\TransportInterface;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiResponse;
use Etki\MvnoApiClient\Exception\ApiRequestFailureException;
use DateTime;
use BadMethodCallException;

/**
 *
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Client
 * @author  Etki <etki@etki.name>
 */
abstract class AbstractApiClient
{
    /**
     * URL where requests should go.
     *
     * @type string
     * @since 0.1.0
     */
    protected $apiUrl;
    /**
     * API credentials.
     *
     * @type Credentials
     * @since 0.1.0
     */
    protected $credentials;
    /**
     * Requests transport.
     *
     * @type TransportInterface
     * @since 0.1.0
     */
    protected $transport;

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
     * Sets API url.
     *
     * @param string $apiUrl API url to set.
     *
     * @return void
     * @since 0.1.0
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
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
        $this->validateResponse($apiResponse);
        return $apiResponse;
    }

    /**
     * Validates response.
     *
     * @param ApiResponse $response Response to validate.
     *
     * @throws ApiRequestFailureException   Thrown if exception response is
     *                                      received.
     * @throws ApiOperationFailureException Thrown if unsuccessful response is
     *                                      received.
     *
     * @return void
     * @since 0.1.0
     */
    protected function validateResponse(ApiResponse $response)
    {
        if ($response->isExceptional()) {
            $origin = ApiRequestFailureException::ORIGIN_CLIENT;
            if ($response->isServerException()) {
                $origin = ApiRequestFailureException::ORIGIN_SERVER;
            }
            $message = sprintf(
                'API request has failed. Returned response: ' .
                '[exception: `%s`, origin: `%s`]',
                $response->getException(),
                $origin
            );
            throw new ApiRequestFailureException($message, $origin);
        }
        if (!$response->isSuccessful()) {
            $message = sprintf(
                'API operation failed with message `%s` on `%s`',
                $response->getResponseMessage(),
                $response->getDateTime()->format(DateTime::ISO8601)
            );
            throw new ApiOperationFailureException($message);
        }
    }

    /**
     * Asserts that credentials are set.
     *
     * @throws BadMethodCallException Thrown if credentials haven't been set.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertCredentialsAreSet()
    {
        if ($this->credentials) {
            $message = 'Cannot process operation: credentials haven\'t been ' .
                'set';
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Asserts that transport is set.
     *
     * @throws BadMethodCallException Thrown if transport hasn't been set.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertTransportIsSet()
    {
        if (!$this->transport) {
            $message = 'Cannot proceed: transport hasn\'t been set';
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Asserts that API url has been set.
     *
     * @throws BadMethodCallException Thrown if API url hasn't been set.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertApiUrlIsSet()
    {
        if (!$this->apiUrl) {
            $message = 'Cannot proceed: API url hasn\'t been set';
            throw new BadMethodCallException($message);
        }
    }
}
