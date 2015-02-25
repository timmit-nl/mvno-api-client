<?php

namespace Etki\MvnoApiClient\Exception;

use BadMethodCallException as SplBadMethodCallException;

/**
 *
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception
 * @author  Etki <etki@etki.name>
 */
class BadMethodCallException extends SplBadMethodCallException implements
    NakaMobileApiClientExceptionInterface
{

}
