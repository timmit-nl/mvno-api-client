<?php

namespace Etki\MvnoApiClient\Log;

use Etki\MvnoApiClient\Transport\ApiRequest;
use Etki\MvnoApiClient\Transport\ApiResponse;

/**
 * This interface describes logger that saves single request-response chunk of
 * API communication.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Log
 * @author  Etki <etki@etki.name>
 */
interface ApiLoggerInterface
{
    /**
     * Logs API talk.
     *
     * @param ApiRequest  $request  Sent request,
     * @param ApiResponse $response Returned response.
     *
     * @return void
     * @since 0.1.0
     */
    public function log(ApiRequest $request, ApiResponse $response);
}
 