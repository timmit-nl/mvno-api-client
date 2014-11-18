<?php

namespace Etki\MvnoApiClient\Exception;

use \RuntimeException;

/**
 * This exception is thrown whenever API request fails.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception
 * @author  Etki <etki@etki.name>
 */
class ApiRequestFailureException extends RuntimeException
{
    /**
     * Exception origin (client / server).
     *
     * @type string
     * @since 0.1.0
     */
    protected $origin;

    /**
     * Initializer.
     *
     * @param string $message
     * @param int    $origin
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct($message, $origin)
    {
        $this->origin = $origin;
        parent::__construct($message);
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
