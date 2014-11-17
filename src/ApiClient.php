<?php

namespace Etki\MvnoApiClient;

use Etki\MvnoApiClient\Exception\MissingApiMethodException;
use Etki\MvnoApiClient\Transport\Request;
use Etki\MvnoApiClient\Transport\RequestGenerator;
use Etki\MvnoApiClient\Transport\RequestGeneratorInterface;
use Etki\MvnoApiClient\Transport\TransportInterface;

/**
 * The very very client.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class ApiClient
{
    /**
     * Request generator instance.
     *
     * @type RequestGeneratorInterface
     * @since 0.1.0
     */
    protected $requestGenerator;
    /**
     * HTTP transport.
     *
     * @type TransportInterface
     * @since 0.1.0
     */
    protected $transport;
    /**
     * URL which will be used to query the API.
     *
     * @type string
     * @since 0.1.0
     */
    protected $apiUrl = 'https://api.nakasolutions.com/mvno/json';

    /**
     * Initializes client.
     *
     * @param Credentials        $credentials Connection credentials.
     * @param TransportInterface $transport   HTTP transport.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        Credentials $credentials = null,
        TransportInterface $transport = null
    ) {
        $this->requestGenerator = new RequestGenerator;
        if ($transport) {
            $this->transport = $transport;
        }
    }

    /**
     * Sets request generator.
     *
     * @param RequestGeneratorInterface $requestGenerator New generator.
     *
     * @return void
     * @since 0.1.0
     */
    public function setRequestGenerator(
        RequestGeneratorInterface $requestGenerator
    ) {
        $this->requestGenerator = $requestGenerator;
    }

    /**
     * Sets transport.
     *
     * @param TransportInterface $transport New transport.
     *
     * @return void
     * @since 0.1.0
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Calls method by it's name.
     *
     * @param string $name Method name.
     * @param array  $data Method parameters.
     *
     * @return array Response data.
     * @since 0.1.0
     */
    public function callMethod($name, array $data)
    {
        if (!method_exists($this->requestGenerator, $name)) {
            $message = sprintf('Method `%s` diesn\'t exist', $name);
            throw new MissingApiMethodException($message);
        }
        /** @type Request $request */
        $request = call_user_func_array(
            array($this->requestGenerator, $name),
            $data
        );
        $request->setHeader();
        $response = $this->transport->sendRequest($this->apiUrl, $request);
        return $response->getData();
    }
}
