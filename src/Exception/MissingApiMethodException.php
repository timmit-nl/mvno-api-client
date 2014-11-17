<?php

namespace Etki\MvnoApiClient\Exception;

use BadMethodCallException;

/**
 * This exception is designed to be thrown whenever missing api method is
 * called.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception
 * @author  Etki <etki@etki.name>
 */
class MissingApiMethodException extends BadMethodCallException
{

}
