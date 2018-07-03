<?php

namespace Cimons\LaraFcm\Response;

use Psr\Http\Message\ResponseInterface;
use Cimons\LaraFcm\Response\Exceptions\ServerResponseException;
use Cimons\LaraFcm\Response\Exceptions\InvalidRequestException;
use Cimons\LaraFcm\Response\Exceptions\UnauthorizedRequestException;

/**
 * Class BaseResponse.
 */
abstract class BaseResponse
{
    const SUCCESS = 'success';
    const FAILURE = 'failure';
    const ERROR = 'error';
    const MESSAGE_ID = 'message_id';

    /**
     * @var bool
     */
    protected $logEnabled = false;

    /**
     * BaseResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->isJsonResponse($response);
        $responseInJson = json_decode($response->getBody(), true);

        $this->parseResponse($responseInJson);
    }

    /**
     * Check if the response given by fcm is parsable.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws InvalidRequestException
     * @throws ServerResponseException
     * @throws UnauthorizedRequestException
     */
    private function isJsonResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 200) {
            return;
        }

        if ($response->getStatusCode() == 400) {
            throw new InvalidRequestException($response);
        }

        if ($response->getStatusCode() == 401) {
            throw new UnauthorizedRequestException($response);
        }

        throw new ServerResponseException($response);
    }

    /**
     * parse the response.
     *
     * @param array $responseInJson
     */
    abstract protected function parseResponse($responseInJson);

}
