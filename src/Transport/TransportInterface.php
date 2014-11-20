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
     * @param HttpRequest $request Request to send.
     *
     * @return HttpResponse Response instance.
     * @since 0.1.0
     */
    public function sendRequest(HttpRequest $request);
}
