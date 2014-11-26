<?php

namespace Etki\MvnoApiClient\Exception\Api;

use Etki\MvnoApiClient\Transport\ApiResponse;

/**
 * This class is designed to create custom exceptions based on returned error
 * code.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Exception\Api
 * @author  Etki <etki@etki.name>
 */
class Manager
{
    /**
     * Base namespace for all generated exceptions.
     *
     * @type string
     * @since 0.1.0
     */
    protected $baseNamespace = 'Etki\MvnoApiClient\Exception\Api\Concrete';
    /**
     * List of exceptions associated with particular error codes.
     *
     * @type string[] Class names in [errorCode => className] format.
     * @since 0.1.0
     */
    protected $codeBase = array(
        1000 => 'CustomerNotFound',
        1001 => 'EmailAddressAlreadyInUse',
        2009 => 'RateServiceError',
    );

    /**
     * This method should be called whenever API request was successful, but
     * returned result shows that request hasn't been completed properly.
     *
     * @param ApiResponse $response Response that should be used to get
     *                              operation error code and message.
     *
     * @return ApiOperationFailureException New exception instance
     * @since 0.1.0
     */
    public function generateApiOperationException(ApiResponse $response) {
        $errorCode = (int) $response->getResponseCode();
        $message = $response->getResponseMessage();
        if (!$message) {
            $message = sprintf(
                'Operation didn\'t return successful result (error code: `%d`)',
                $errorCode
            );
        }
        if (!isset($this->codeBase[$errorCode])) {
            return new ApiOperationFailureException($message, $errorCode);
        }
        $className = $this->baseNamespace . '\\' . $this->codeBase[$errorCode];
        $suffix = 'Exception';
        if (strrpos($className, $suffix)
            !== strlen($className) - strlen($suffix)
        ) {
            $className .= $suffix;
        }
        return new $className($message, $errorCode);
    }
}
 