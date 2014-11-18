<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * HTTP response.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class HttpResponse
{
    /**
     * HTTP body.
     *
     * @type string
     * @since 0.1.0
     */
    protected $body;
    /**
     * HTTP headers.
     *
     * @type array
     * @since 0.1.0
     */
    protected $headers = array();

    /**
     * Sets body of http response.
     *
     * @param string $body Body of HTTP message.
     *
     * @return void
     * @since 0.1.0
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Returns body of http response.
     *
     * @return string
     * @since 0.1.0
     */
    public function getBody()
    {
        return $this->body;
    }
}
