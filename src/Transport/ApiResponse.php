<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Exception\Api\MalformedApiRequestException;
use DateTime;
use BadMethodCallException;
use Etki\MvnoApiClient\Exception\Api\MalformedApiResponseException;

/**
 * This class represents API response.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class ApiResponse
{
    /**
     * Data holder.
     *
     * @type array
     * @since 0.1.0
     */
    protected $data;

    /**
     * Datetime.
     *
     * @type DateTime
     * @since 0.1.0
     */
    protected $dateTime;

    /**
     * Error code.
     *
     * @type int
     * @since 0.1.0
     */
    protected $errorCode;

    /**
     * Error message.
     *
     * @type string
     * @since 0.1.0
     */
    protected $errorMessage;
    /**
     * Request ID.
     *
     * @type string
     * @since 0.1.0
     */
    protected $requestId;

    /**
     * Constant containing string representation of exception cause for
     * server-generated exceptions.
     *
     * @type string
     * @since 0.1.0
     */
    const EXCEPTION_SOURCE_SERVER = 'Receiver';
    /**
     * Constant containing string representation of exception cause for
     * client-generated exceptions.
     *
     * @type string
     * @since 0.1.0
     */
    const EXCEPTION_SOURCE_CLIENT = 'Sender';

    /**
     * Sets data.
     *
     * @param array $data Sets incoming data.
     *
     * @return void
     * @since 0.1.0
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Sets error code.
     *
     * @param int $errorCode
     *
     * @return void
     * @since 0.1.0
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * Retrieves error code.
     *
     * @return int
     * @since 0.1.0
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Sets error message.
     *
     * @param string $message Error message.
     *
     * @return void
     * @since 0.1.0
     */
    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }

    /**
     * Retrieves error message.
     *
     * @return string
     * @since 0.1.0
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Sets request ID.
     *
     * @param int|string $requestId Request ID.
     *
     * @return void
     * @since 0.1.0
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * Returns request ID.
     *
     * @return string
     * @since 0.1.0
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * Returns response data.
     *
     * @return array.
     * @since 0.1.0
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns data item.
     *
     * @param string $itemKey Item key.
     *
     * @throws BadMethodCallException Thrown if item doesn't exist.
     *
     * @return mixed
     * @since 0.1.0
     */
    public function getDataItem($itemKey)
    {
        if (!$this->hasDataItem($itemKey)) {
            $message = sprintf('Data item `%s` doesn\'t exist', $itemKey);
            throw new BadMethodCallException($message);
        }
        return $this->data[$itemKey];
    }

    /**
     * Tells if response has data item.
     *
     * @param string $itemKey Item key.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasDataItem($itemKey)
    {
        return array_key_exists($itemKey, $this->data);
    }

    /**
     * Tells if response contains exception.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isExceptional()
    {
        return isset($this->errorCode);
    }

    /**
     * Tells if response has been successful.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isSuccessful()
    {
        return !$this->isExceptional();
    }

    /**
     * Returns response code.
     *
     * @return int
     * @since 0.1.0
     */
    public function getResponseCode()
    {
        $this->assertIsNotExceptional();
        return $this->data['responseCode'];
    }

    /**
     * Tells if response contains exact response message.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasResponseMessage()
    {
        return isset($this->data['responseMessage']);
    }

    /**
     * Returns response message, if it has been returned.
     *
     * @return string|null
     * @since 0.1.0
     */
    public function getResponseMessage()
    {
        $this->assertIsNotExceptional();
        if (!isset($this->data['responseMessage'])) {
            return null;
        }
        return $this->data['responseMessage'];
    }

    /**
     * Returns response timestamp.
     *
     * @return int
     * @since 0.1.0
     */
    public function getTimestamp()
    {
        $this->assertIsSuccessful();
        return $this->data['timestamp'];
    }

    /**
     * Returns exception text.
     *
     * @return string
     * @since 0.1.0
     */
    public function getException()
    {
        $this->assertIsExceptional();
        return $this->data['exception'];
    }

    /**
     * Returns exception source (`Sender` or `Receiver`).
     *
     * @return string
     * @since 0.1.0
     */
    public function getExceptionSource()
    {
        $this->assertIsExceptional();
        return $this->data['fault'];
    }

    /**
     * Tells if exception has been generated by the client.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isServerException()
    {
        return $this->getExceptionSource() === self::EXCEPTION_SOURCE_SERVER;
    }

    /**
     * Tells if exception has been generated by the client.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isClientException()
    {
        return $this->getExceptionSource() === self::EXCEPTION_SOURCE_CLIENT;
    }

    /**
     * Returns response datetime.
     *
     * @return DateTime
     * @since 0.1.0
     */
    public function getDateTime()
    {
        if (!isset($this->dateTime)) {
            $this->dateTime = new DateTime;
            $this->dateTime->setTimestamp($this->getTimestamp());
        }
        return $this->dateTime;
    }

    /**
     * Asserts that data has been successfully set.
     *
     * @throws BadMethodCallException Thrown if data hasn't been set.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    public function assertDataHasBeenSet()
    {
        if (!$this->data) {
            throw new BadMethodCallException('Data hasn\'t been set');
        }
    }

    /**
     * Asserts that current request is successful.
     *
     * @throws BadMethodCallException Thrown if request isn't successful.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    public function assertIsSuccessful()
    {
        if (!$this->isSuccessful()) {
            $message = 'Request isn\'t typical successful response';
            if (!$this->isExceptional()) {
                $responseMessage = '<none>';
                if (!empty($this->data['responseMessage'])) {
                    $responseMessage = $this->data['responseMessage'];
                }
                $message .= sprintf(
                    ' (error code: `%d`, message: `%s`)',
                    $this->data['responseCode'],
                    $responseMessage
                );
            }
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Asserts that current request is exceptional.
     *
     * @throws BadMethodCallException Thrown if request isn't exceptional.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    public function assertIsExceptional()
    {
        if (!$this->isExceptional()) {
            $message = 'Request isn\'t an exceptional response';
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Asserts that current request is not exceptional.
     *
     * @throws BadMethodCallException Thrown if request is exceptional.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    public function assertIsNotExceptional()
    {
        if ($this->isExceptional()) {
            $message = 'Request is an exceptional response';
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Creates API response from HTTP response.
     *
     * @param string $response Original HTTP response body.
     *
     * @return ApiResponse Generated response.
     * @since 0.1.0
     */
    public static function createFromPlainText($response)
    {
        $apiResponse = new ApiResponse;
        $data = json_decode($response, true);
        if (!$data || (!isset($data['error']) && !isset($data['result']))
            || !isset($data['id'])
        ) {
            throw new MalformedApiResponseException($response);
        }
        $apiResponse->setRequestId($data['id']);
        if (isset($data['error'])) {
            $error = $data['error'];
            if (isset($error['data'])) {
                $apiResponse->setData($error['data']);
            }
            $apiResponse->setErrorCode($error['code']);
            $apiResponse->setErrorMessage($error['message']);
        } else {
            $apiResponse->setData($data['result']);
        }
        return $apiResponse;
    }
}
