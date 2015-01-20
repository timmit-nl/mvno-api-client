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
    private $guzzle;
    private $timeout = 10000;
    private $proxy;
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
    public function setTimeout($timeout)
    {
        $normalizedTimeout = intval($timeout);
        if ($normalizedTimeout < 500) {
            $message = sprintf('Invalid timeout `%s`', $timeout);
            throw new TransportException($message);
        }
        $this->timeout = $normalizedTimeout;
        return $this;
    }
    public function getTimeout()
    {
        return $this->timeout;
    }
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }
    public function getProxy()
    {
        return $this->proxy;
    }
    public function setPlugin(EventSubscriberInterface $guzzlePlugin)
    {
        $this->getGuzzle()->addSubscriber($guzzlePlugin);
    }
    protected function getGuzzle()
    {
        if (!isset($this->guzzle)) {
            $this->guzzle = new Client;
            $userAgent = 'PHP '.PHP_VERSION.' / Naka Mobile MVNOApiJSONClient';
            $this->guzzle->setUserAgent($userAgent);
        }
        return $this->guzzle;
    }
}
