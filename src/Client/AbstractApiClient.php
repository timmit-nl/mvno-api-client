<?php

namespace Etki\MvnoApiClient\Client;

use Etki\MvnoApiClient\Exception\Api\MalformedApiResponseException;
use Etki\MvnoApiClient\Exception\Api\Manager;
use Etki\MvnoApiClient\Exception\Api\ApiOperationFailureException;
use Etki\MvnoApiClient\Exception\Api\ApiRequestFailureException;
use Etki\MvnoApiClient\Log\ApiLoggerAwareInterface;
use Etki\MvnoApiClient\Log\ApiLoggerInterface;
use Etki\MvnoApiClient\Transport\ApiRequestCollection;
use Etki\MvnoApiClient\Transport\ApiResponseCollection;
use Etki\MvnoApiClient\Transport\HttpRequest;
use Etki\MvnoApiClient\Transport\LayerConverter;
use Etki\MvnoApiClient\Transport\TransportInterface;
use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiResponse;
use BadMethodCallException;

/**
 * Base functionality for client.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Client
 * @author  Etki <etki@etki.name>
 */
abstract class AbstractApiClient implements ApiLoggerAwareInterface
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
     * List of attached loggers.
     *
     * @type ApiLoggerInterface[]
     * @since 0.1.0
     */
    protected $loggers = array();
    /**
     * Converter instance.
     *
     * @type LayerConverter
     * @since 0.1.0
     */
    protected $converter;

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
     * Attaches new logger.
     *
     * @param ApiLoggerInterface $logger Logger instance.
     *
     * @return void
     * @since 0.1.0
     */
    public function setRequestLogger(ApiLoggerInterface $logger)
    {
        $this->loggers[] = $logger;
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
        $request->setData($data);
        $request->setMethodName($name);
        return $this->makeRequest($request);
    }

    /**
     * Performs new request.
     *
     * @param ApiRequest $apiRequest
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function makeRequest(ApiRequest $apiRequest)
    {
        $apiRequest->setDataItem('apiKey', $this->credentials->getApiKey());
        $apiRequest->setRequestId(1);
        $converter = $this->getConverter();
        $jsonRpcRequest = $converter->createJsonRpcRequest($apiRequest);
        $httpRequest = $this->createRequestTemplate();
        $httpRequest->setPostBody(json_encode($jsonRpcRequest));
        $httpResponse = $this->transport->sendRequest($httpRequest);
        $jsonRpcResponse = json_decode($httpResponse->getBody(), true);
        if (!$jsonRpcResponse) {
            throw new MalformedApiResponseException($httpResponse->getBody());
        }
        $apiResponse = $converter->createApiResponse($jsonRpcResponse);
        foreach ($this->loggers as $logger) {
            $logger->log($apiRequest, $apiResponse);
        }
        $this->validateResponse($apiResponse);
        return $apiResponse;
    }

    /**
     * Performs batch request.
     *
     * @param ApiRequestCollection $requestCollection Request collection.
     *
     * @return ApiResponseCollection Responses.
     * @since 0.1.0
     */
    public function makeBatchRequest(ApiRequestCollection $requestCollection)
    {
        $converter = $this->getConverter();
        $requests = array();
        foreach ($requestCollection->getRequests() as $request) {
            $request->setDataItem('apiKey', $this->credentials->getApiKey());
            $jsonRpcRequest = $converter->createJsonRpcRequest($request);
            $requests[] = $jsonRpcRequest;
        }
        $httpRequest = $this->createRequestTemplate();
        $httpRequest->setPostBody(json_encode($requests));
        $httpResponse = $this->transport->sendRequest($httpRequest);
        $batchJsonRpcResponse = json_decode($httpResponse->getBody(), true);
        if (!$batchJsonRpcResponse) {
            throw new MalformedApiResponseException($httpResponse->getBody());
        }
        $responseCollection = new ApiResponseCollection;
        foreach ($batchJsonRpcResponse as $jsonRpcResponse) {
            $apiResponse = $converter->createApiResponse($jsonRpcResponse);
            $responseCollection->addResponse($apiResponse);
        }
        return $responseCollection;
    }

    /**
     * Creates request template.
     *
     * @return HttpRequest
     * @since 0.1.0
     */
    protected function createRequestTemplate()
    {
        $request = new HttpRequest;
        $contentType = 'application/x-www-form-urlencoded';
        $request->addHeader('Content-Type', $contentType);
        $username = $this->credentials->getUsername();
        $password = $this->credentials->getPassword();
        $auth = base64_encode($username . ':' . $password);
        $request->addHeader('Authorization', 'Basic ' . $auth);
        $request->setUrl($this->apiUrl);
        return $request;
    }

    /**
     * Returns converter.
     *
     * @return LayerConverter
     * @since 0.1.0
     */
    protected function getConverter()
    {
        if (!isset($this->converter)) {
            $this->converter = new LayerConverter;
        }
        return $this->converter;
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
            $manager = new Manager;
            throw $manager->generateApiOperationException($response);
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
