<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * A simple transport based on url-wrappers.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class FileGetContentsTransport implements TransportInterface
{
    /**
     * Number of retries.
     *
     * @type int
     * @since 0.1.0
     */
    protected $retries = 5;
    /**
     * Timeout in seconds.
     *
     * @type int
     * @since 0.1.0
     */
    protected $timeout = 5;
    /**
     * Sends single request.
     *
     * @param HttpRequest $request Request to send.
     *
     * @todo verify that no json_encode options are really needed.
     * @todo refactor if possible.
     *
     * @return HttpResponse raw API response,
     * @since 0.1.0
     */
    public function sendRequest(HttpRequest $request)
    {
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => $request->getHeaderString(),
                'content' => json_encode($request->getPostBody()),
                'timeout' => $this->timeout,
            ),
        );
        $context = stream_context_create($options);
        $response = new HttpResponse;
        for ($i = 0; $i < $this->retries; $i++) {
            $raw = @file_get_contents($request->getUrl(), null, $context);
            if ($raw) {
                break;
            }
        }
        $response->setBody($raw);
        return $response;
    }

    /**
     * Sets amount of retries.
     *
     * @param int $retries
     *
     * @return void
     * @since 0.1.0
     */
    public function setRetries($retries)
    {
        $this->retries = max(1, $retries);
    }

    /**
     * Returns amount of retries.
     *
     * @return int
     * @since 0.1.0
     */
    public function getRetries()
    {
        return $this->retries;
    }

    /**
     * Sets timeout.
     *
     * @param int|float $timeout Request timeout.
     *
     * @return void
     * @since 0.1.0
     */
    public function setTimeout($timeout)
    {
        $this->timeout = max(0.1, $timeout);
    }

    /**
     * Returns current timeout.
     *
     * @return int|float
     * @since 0.1.0
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}
