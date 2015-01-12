<?php

namespace Etki\MvnoApiClient\Exception\Api\Concrete;

use Etki\MvnoApiClient\Exception\Api\ApiOperationFailureException;

/**
 * Thrown whenever customer can't be registered because email address is already
 * in use.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception\Api\Exact
 * @author  Etki <etki@etki.name>
 */
class EmailAddressAlreadyInUseException extends ApiOperationFailureException
{

}
 