<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * Interface for request transports.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
interface TransportInterface
{
    /**
     * Sends request and receives response.
     *
     * @param string  $url     URL to query.
     * @param ApiRequest $request Request to send.
     *
     * @return ApiResponse Response instance
     * @since 0.1.0
     */
    public function sendRequest(HttpRequest $request);
}
