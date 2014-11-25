<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * HTTP request to be sent to API.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class HttpRequest
{
    /**
     * URL to perform request at.
     *
     * @type string
     * @since 0.1.0
     */
    protected $url;
    /**
     * HTTP headers.
     *
     * @type string[]
     * @since 0.1.0
     */
    protected $headers = array();
    /**
     * List of get parameters,
     *
     * @type string[]
     * @since 0.1.0
     */
    protected $getParams = array();
    /**
     * Post body.
     *
     * @type string
     * @since 0.1.0
     */
    protected $postBody;
    /**
     * Adds HTTP header.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     * @since 0.1.0
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Adds get parameter
     *
     * @param string $name  Get parameter name,
     * @param string $value Get parameter value.
     *
     * @return void
     * @since 0.1.0
     */
    public function addGetParam($name, $value = null)
    {
        $this->getParams[$name] = $value;
    }

    /**
     * Sets URL to perform request to.
     *
     * @param string $url URL.
     *
     * @return void
     * @since 0.1.0
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns url.
     *
     * @return string
     * @since 0.1.0
     */
    public function getUrl()
    {
        $url = $this->url;
        if ($this->getParams) {
            $url .= '?' . $this->getQueryString();
        }
        return $url;
    }

    /**
     * Returns http headers.
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Return nicely formatted header string.
     *
     * @return string
     * @since 0.1.0
     */
    public function getHeaderString()
    {
        $headers = array();
        foreach ($this->headers as $header => $value) {
            $headers[] = sprintf('%s: %s', $header, $value);
        }
        return implode("\r\n", $headers) . "\r\n";
    }

    /**
     * Returns query string.
     *
     * @todo refactor
     *
     * @return string Query string.
     * @since 0.1.0
     */
    public function getQueryString()
    {
        $queryString = http_build_query($this->getParams);
        foreach ($this->getParams as $param => $value) {
            if (!$value) {
                if ($queryString) {
                    $queryString .= '&';
                }
                $queryString .= $param;
            }
        }
        return $queryString;
    }

    /**
     * Returns get params.
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * Saves POST body
     *
     * @param string $body POST body.
     *
     * @return void
     * @since 0.1.0
     */
    public function setPostBody($body)
    {
        $this->postBody = $body;
    }

    /**
     * Returns post body.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPostBody()
    {
        return $this->postBody;
    }
}
