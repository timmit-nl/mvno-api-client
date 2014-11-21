<?php

namespace Etki\MvnoApiClient\Exception;

use Exception;

/**
 * This exception is used whenever returned API result is undesired.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception
 * @author  Etki <etki@etki.name>
 */
class ApiOperationFailureException extends ApiFailureException
{
    public function __construct(
        $message = 'Operation hasn\'t finished successfully',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
