<?php

namespace Cimons\LaraFcm\Sender;

use Cimons\LaraFcm\Message\Notification;
use Cimons\LaraFcm\Request\Request;
use Cimons\LaraFcm\Response\DownstreamResponse;
use GuzzleHttp\Exception\ClientException;


class FCMSender extends HTTPSender
{
    const MAX_TOKEN_PER_REQUEST = 1000;

    public function sendTo($to, Notification $notification = null)
    {
        $request        = new Request($to, $notification);
        $responseGuzzle = $this->post($request);
        $response       = new DownstreamResponse($responseGuzzle, $to);

        return $response;
    }

    private function post($request)
    {
        try {
            $responseGuzzle = $this->client->request('post', $this->url, $request->build());
        } catch (ClientException $e) {
            $responseGuzzle = $e->getResponse();
        }

        return $responseGuzzle;
    }
}