<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Client\Credentials;

/**
 * This class represents single API request.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class ApiRequest
{
    /**
     * URL where request should go.
     *
     * @type string
     * @since 0.1.0
     */
    protected $url;
    /**
     * Request data.
     *
     * @type array
     * @since 0.1.0
     */
    protected $data;
    /**
     * Name of the API method.
     *
     * @type string
     * @since 0.1.0
     */
    protected $methodName;
    /**
     * API credentials.
     *
     * @type Credentials
     * @since 0.1.0
     */
    protected $credentials;

    /**
     * Sets data.
     *
     * @param array $data Data to be set.
     *
     * @return void
     * @since 0.1.0
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Returns data.
     *
     * @return array
     * @since 0.1.0
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets API method name.
     *
     * @param string $methodName API method name.
     *
     * @return void
     * @since 0.1.0
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }

    /**
     * Returns API method name.
     *
     * @return string
     * @since 0.1.0
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Saves request credentials.
     *
     * @param Credentials $credentials
     *
     * @return void
     * @since 0.1.0
     */
    public function setCredentials(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Get API request credentials.
     *
     * @return Credentials
     * @since 0.1.0
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Sets URL.
     *
     * @param string $url Url to set,
     *
     * @return void
     * @since 0.1.0
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Retrieves url.
     *
     * @return string
     * @since 0.1.0
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Creates HTTP request.
     *
     * @return HttpRequest
     * @since 0.1.0
     */
    public function createHttpRequest()
    {
        $request = new HttpRequest;
        $request->setUrl($this->getUrl());
        $request->addGetParam($this->getMethodName());
        $dataString = base64_encode(
            sprintf(
                '%s:%s',
                $this->credentials->getUsername(),
                $this->credentials->getPassword()
            )
        );
        $request->addHeader('Authorization', 'Basic ' . $dataString);
        $request->setPostBody(json_encode($this->data));
        return $request;
    }
}
