<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Credentials;

/**
 * MVNO-compliant request generator.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class Client implements HighLevelApiClientInterface
{
    /**
     * API credentials.
     *
     * @type Credentials
     * @since 0.1.0
     */
    private $credentials;
}
