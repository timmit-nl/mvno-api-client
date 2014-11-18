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
     * @param HttpRequest $request Request to send.
     *
     * @todo verify that no json_encode options are really needed.
     * @todo refactor if possible.
     *
     * @return ApiResponse API response,
     * @since 0.1.0
     */
    public function sendRequest(HttpRequest $request)
    {
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => $request->getHeaderString(),
                'content' => json_encode($request->getPostBody()),
            ),
        );
        $context = stream_context_create($options);
        $response = new HttpResponse;
        $response->setBody(@file_get_contents($request->getUrl(), null, $context));
        $apiResponse = ApiResponse::createFromHttpResponse($response);
        return $apiResponse;
    }
}
