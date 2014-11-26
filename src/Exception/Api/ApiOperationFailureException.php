<?php

namespace Etki\MvnoApiClient\Exception\Api;

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
    protected $codeBase = array(
        1000 => array(
            'class' => 'CustomerNotFoundException',
        ),
        1001 => array(
            'class' => 'EmailAddressAlreadyInUseException'
        ),
    );

    /**
     * Creates new exception.
     *
     * @param string    $message  Exception message.
     * @param int       $code     Error code (if any).
     * @param Exception $previous Previous exception.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        $message = 'Operation hasn\'t finished successfully',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
