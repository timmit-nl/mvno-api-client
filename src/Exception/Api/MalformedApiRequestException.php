<?php

namespace Etki\MvnoApiClient\Exception\Api;

use \Exception;

/**
 * Thrown whenever request doesn't conform to standards listed in API
 * specification.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception
 * @author  Etki <etki@etki.name>
 */
class MalformedApiRequestException extends ApiFailureException
{
    /**
     * @param string[]|string $missingKeys List of missing response keys or just
     *                                     a regular exception message.
     * @param int             $code        Exception code.
     * @param Exception       $previous    Previous exception.
     */
    public function __construct(
        $missingKeys = null,
        $code = 0,
        Exception $previous = null
    ) {
        $message = $missingKeys;
        if (is_array($missingKeys)) {
            $message = 'Request is missing following keys: ' .
                implode(', ', $missingKeys);
        }
        parent::__construct($message, $code, $previous);
    }
}
