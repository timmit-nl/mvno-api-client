<?php

namespace Etki\MvnoApiClient\Exception\Api;

use Exception;

/**
 * This exception is thrown whenever API request fails.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception
 * @author  Etki <etki@etki.name>
 */
class ApiRequestFailureException extends ApiFailureException
{
    /**
     * Exception origin (client / server).
     *
     * @type string
     * @since 0.1.0
     */
    protected $origin;

    /**
     * Constant for setting client origin.
     *
     * @type string
     * @since 0.1.0
     */
    const ORIGIN_CLIENT = 'client';
    /**
     * Constant for setting server origin.
     *
     * @type string
     * @since 0.1.0
     */
    const ORIGIN_SERVER = 'server';

    /**
     * Initializer.
     *
     * @param string    $message  Exception message.
     * @param string    $origin   Exception origin (client/server)
     * @param int       $code     Exception code.
     * @param Exception $previous Previous exception in stack.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        $message,
        $origin,
        $code = 0,
        Exception $previous = null
    ) {
        $this->origin = $origin;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns exception origin.
     *
     * @return string
     * @since 0.1.0
     */
    public function getOrigin()
    {
        return $this->origin;
    }
}
