<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * Collection of API requests.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class ApiRequestCollection
{
    /**
     * Collection of API requests.
     *
     * @type ApiRequest[]
     * @since 0.1.0
     */
    private $requests = array();

    /**
     * Adds single request.
     *
     * @param ApiRequest $request Request to add.
     *
     * @return void
     * @since 0.1.0
     */
    public function addRequest(ApiRequest $request)
    {
        $this->requests[] = $request;
    }

    /**
     * Adds collection of requests.
     *
     * @param ApiRequest[] $requests Requests.
     *
     * @return void
     * @since 0.1.0
     */
    public function addRequests(array $requests)
    {
        foreach ($requests as $request) {
            $this->addRequest($request);
        }
    }

    /**
     * Retrieves all requests.
     *
     * @return ApiRequest[]
     * @since 0.1.0
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Returns size of collection.
     *
     * @return int
     * @since 0.1.0
     */
    public function getSize()
    {
        return sizeof($this->requests);
    }
}
