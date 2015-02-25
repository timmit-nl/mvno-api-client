<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Exception\Api\MalformedApiResponseException;

/**
 * Creates API response.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class LayerConverter
{
    /**
     * Creates API response from array.
     *
     * @param array $data Data to create response from.
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function createApiResponse(array $data)
    {
        $apiResponse = new ApiResponse;
        if (!isset($data['id'])
            || (!isset($data['error']) && !isset($data['result']))
        ) {
            throw new MalformedApiResponseException(json_encode($data));
        }
        $apiResponse->setRequestId($data['id']);
        if (isset($data['error'])) {
            $apiResponse->setErrorCode($data['error']['code']);
            $apiResponse->setErrorMessage($data['error']['message']);
            if (isset($data['error']['data'])) {
                $apiResponse->setData($data['error']['data']);
            }
        } else {
            $apiResponse->setData($data['result']);
        }
        return $apiResponse;
    }

    /**
     * Creates JSON-RPC request from API request object.
     *
     * @param ApiRequest $apiRequest API request object.
     *
     * @return array
     * @since 0.1.0
     */
    public function createJsonRpcRequest(ApiRequest $apiRequest)
    {
        return array(
            'jsonrpc' => '2.0',
            'method' => $apiRequest->getMethodName(),
            'params' => $apiRequest->getData(),
            'id' => $apiRequest->getRequestId(),
        );
    }
}
