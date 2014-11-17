<?php

namespace Etki\MvnoApiClient;

/**
 * API credentials.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class Credentials
{
    /**
     * Username to access API.
     *
     * @type string
     * @since 0.1.0
     */
    protected $username;
    /**
     * Password to access API.
     *
     * @type string
     * @since 0.1.0
     */
    protected $password;
    /**
     * API key.
     *
     * @type string
     * @since 0.1.0
     */
    protected $apiKey;

    /**
     * Returns `username`.
     *
     * @return string
     * @since 0.1.0
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets `username`.
     *
     * @param string $username
     *
     * @return void
     * @since 0.1.0
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Returns `password`.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets `password`.
     *
     * @param string $password
     *
     * @return void
     * @since 0.1.0
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns `apiKey`.
     *
     * @return string
     * @since 0.1.0
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets `apiKey`.
     *
     * @param string $apiKey
     *
     * @return void
     * @since 0.1.0
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

}
