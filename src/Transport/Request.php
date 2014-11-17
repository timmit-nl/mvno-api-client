<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * This class represents single request
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class Request
{
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
     *
     *
     * @type string[]
     * @since 0.1.0
     */
    protected $headers = array();

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
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
}
