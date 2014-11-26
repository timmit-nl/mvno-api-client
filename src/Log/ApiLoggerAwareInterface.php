<?php

namespace Etki\MvnoApiClient\Log;

/**
 * This interface describes class that may log it's requests and responses.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Log
 * @author  Etki <etki@etki.name>
 */
interface ApiLoggerAwareInterface
{
    /**
     * Sets request logger.
     *
     * @param ApiLoggerInterface $logger Logger instance.
     *
     * @return void
     * @since 0.1.0
     */
    public function setRequestLogger(ApiLoggerInterface $logger);
}
 