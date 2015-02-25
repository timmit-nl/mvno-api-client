<?php

namespace Etki\MvnoApiClient\Exception\Api;

use Exception;

/**
 * Designed to be thrown whenever response doesn't conform to what has been
 * expected.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception\Api
 * @author  Etki <etki@etki.name>
 */
class MalformedApiResponseException extends ApiRequestFailureException
{
    /**
     * String response representation.
     *
     * @type string
     * @since 0.1.0
     */
    private $responseRepresentation;

    /**
     * Initializer.
     *
     * @param string    $responseRepresentation Response representation as
     *                                          string.
     * @param string    $message                Exception message.
     * @param Exception $previous               Previous exception.
     *
     * @SuppressWarnings(PHPMD.LongVariableName)
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        $responseRepresentation,
        $message = null,
        Exception $previous = null
    ) {
        $this->responseRepresentation = $responseRepresentation;
        if (!$message) {
            $message = 'Unexpected response: ' . PHP_EOL .
                $responseRepresentation;
        }
        parent::__construct($message, 'server', 0, $previous);
    }

    /**
     * Returns response representation.
     *
     * @return string
     * @since 0.1.0
     */
    public function getResponseRepresentation()
    {
        return $this->responseRepresentation;
    }
}
