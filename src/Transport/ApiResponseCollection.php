<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Exception\BadMethodCallException;

/**
 * Collection of API responses.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class ApiResponseCollection
{
    /**
     * Collection of API responses.
     *
     * @type ApiResponse[]
     * @since 0.1.0
     */
    private $responses = array();

    /**
     * Adds new response to collection.
     *
     * @param ApiResponse $response Response to add.
     *
     * @return void
     * @since 0.1.0
     */
    public function addResponse(ApiResponse $response)
    {
        if ($response->getRequestId()) {
            $this->responses[$response->getRequestId()] = $response;
        } else {
            $message = 'Passed request doesn\'t contain any ID';
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Adds responses to collection.
     *
     * @param ApiResponse[] $responses
     *
     * @return void
     * @since 0.1.0
     */
    public function addResponses(array $responses)
    {
        foreach ($responses as $response) {
            $this->addResponse($response);
        }
    }

    /**
     * Returns responses.
     *
     * @return ApiResponse[]
     * @since 0.1.0
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Retrieves response by ID.
     *
     * @param string|int $id Response ID.
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     *
     * @return ApiResponse
     * @since 0.1.0
     */
    public function getResponse($id)
    {
        if ($this->hasResponse($id)) {
            return $this->responses[$id];
        }
        throw new BadMethodCallException('No such response');
    }

    /**
     * Tells if response with specified ID exists.
     *
     * @param int|string $id Response ID.
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasResponse($id)
    {
        return isset($this->responses[$id]);
    }
}
