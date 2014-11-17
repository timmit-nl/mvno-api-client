<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * A simple transport based on url-wrappers.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class FileGetContentsTransport implements TransportInterface
{
    /**
     * Sends single request.
     *
     * @param string  $url     URL to query,
     * @param Request $request Request to send.
     *
     * @todo verify that no json_encode options are really needed.
     * @todo refactor if possible.
     *
     * @return Response API response,
     * @since 0.1.0
     */
    public function sendRequest($url, Request $request)
    {
        $credentials = $request->getCredentials();
        $magicString = sprintf(
            '%s:%s',
            $credentials->getUsername(),
            $credentials->getPassword()
        );
        $auth = base64_encode($magicString);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Authorization: Basic ' . $auth,
                'content' => json_encode($request->getData()),
            ),
        );
        $context = stream_context_create($options);
        $rawApiResponse = @file_get_contents($url, null, $context);
        $response = new Response;
        $response->setData(json_decode($rawApiResponse, true));
        return $response;
    }
}
