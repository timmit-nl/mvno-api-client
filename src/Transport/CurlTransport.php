<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * Transport based on cURL.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Transport
 * @author  Etki <etki@etki.name>
 */
class CurlTransport implements TransportInterface
{
    /**
     * cURL handle.
     *
     * @type resource
     * @since 0.1.0
     */
    protected $handle;

    /**
     * Initializer.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct()
    {
        $this->handle = curl_init();
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_POST, true);
        curl_setopt($this->handle, CURLOPT_USERAGENT, 'PHP '.PHP_VERSION.' / Naka Mobile MVNOApiJSONClient');
    }

    public function setProxy($proxy)
    {
        curl_setopt($this->handle, CURLOPT_PROXY, $proxy);
    }

    /**
     * Sends request.
     *
     * @param HttpRequest $request Request to be made.
     *
     * @return HttpResponse Response.
     * @since 0.1.0
     */
    public function sendRequest(HttpRequest $request)
    {
        $response = new HttpResponse;
        $headers = array_merge(
            $request->getHeaders(),
            array(
                'Method' => 'POST',
                'Connection' => 'Keep-Alive',
                'Expect' => '',
            )
        );
        $renderedHeaders = array();
        foreach ($headers as $header => $value) {
            $renderedHeaders[] = sprintf('%s: %s', $header, $value);
        }
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, $renderedHeaders);
        curl_setopt($this->handle, CURLOPT_URL, $request->getUrl());
        curl_setopt($this->handle, CURLOPT_POSTFIELDS, $request->getPostBody());
        $postBody = curl_exec($this->handle);
        $error = curl_error($this->handle);
        $response->setBody($postBody);
        return $response;
    }
}
 