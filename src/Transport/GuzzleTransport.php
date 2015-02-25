<?php

namespace Etki\MvnoApiClient\Transport;

use Etki\MvnoApiClient\Exception\TransportException;
use Guzzle\Http\Client;
use Guzzle\Plugin\Cache\CachePlugin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Guzzle-based transport.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class GuzzleTransport implements TransportInterface
{
    /**
     * Guzzle client instance.
     *
     * @type Client
     * @since 0.1.0
     */
    private $guzzle;
    /**
     * Timeout in milliseconds.
     *
     * @type int
     * @since 0.1.0
     */
    private $timeout = 10000;
    /**
     * Proxy string.
     *
     * @type string
     * @since 0.1.0
     */
    private $proxy;

    /**
     * Sends HTTP request.
     *
     * @param HttpRequest $request Request to send.
     *
     * @return void
     * @since 0.1.0
     */
    public function sendRequest(HttpRequest $request)
    {
        $guzzle = $this->getGuzzle();
        $uri = $request->getUrl();
        $headers = array_merge(
            $request->getHeaders(),
            array('Connection' => 'Keep-Alive', 'Expect' => '',)
        );
        $guzzle->post($uri, $headers);
    }

    /**
     * Sets new timeout.
     *
     * @param int $timeout Timeout in milliseconds.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setTimeout($timeout)
    {
        $normalizedTimeout = (int) $timeout;
        if ($normalizedTimeout < 500) {
            $message = sprintf('Invalid timeout `%s`', $timeout);
            throw new TransportException($message);
        }
        $this->timeout = $normalizedTimeout;
        return $this;
    }

    /**
     * Returns timeout.
     *
     * @return int
     * @since 0.1.0
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Sets proxy.
     *
     * @param string $proxy
     *
     * @return void
     * @since 0.1.0
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * Returns proxy.
     *
     * @return string
     * @since 0.1.0
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * Adds guzzle plugin.
     *
     * @param EventSubscriberInterface $guzzlePlugin Plugin to add.
     *
     * @return void
     * @since 0.1.0
     */
    public function setPlugin(EventSubscriberInterface $guzzlePlugin)
    {
        $this->getGuzzle()->addSubscriber($guzzlePlugin);
    }

    /**
     * Retrieves guzzle client.
     *
     * @return Client
     * @since 0.1.0
     */
    protected function getGuzzle()
    {
        if (!isset($this->guzzle)) {
            $this->guzzle = new Client;
        }
        return $this->guzzle;
    }
}
