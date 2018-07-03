<?php

namespace Cimons\LaraFcm\Response;

use Psr\Http\Message\ResponseInterface;

class DownstreamResponse extends BaseResponse
{

    const MULTICAST_ID = 'multicast_id';
    const CANONICAL_IDS = 'canonical_ids';
    const RESULTS = 'results';

    const MISSING_REGISTRATION = 'MissingRegistration';
    const MESSAGE_ID = 'message_id';
    const REGISTRATION_ID = 'registration_id';
    const NOT_REGISTERED = 'NotRegistered';
    const INVALID_REGISTRATION = 'InvalidRegistration';
    const UNAVAILABLE = 'Unavailable';
    const DEVICE_MESSAGE_RATE_EXCEEDED = 'DeviceMessageRateExceeded';
    const INTERNAL_SERVER_ERROR = 'InternalServerError';

    public $resultMessage;
    public $isSent = 0;

    protected $messageId;
    protected $numberTokensSuccess = 0;
    protected $numberTokensFailure = 0;
    protected $numberTokenModify = 0;

    public function __construct(ResponseInterface $response, $tokens)
    {
        parent::__construct($response);
    }

    /**
     * Parse the response.
     *
     * @param $responseInJson
     */
    protected function parseResponse($responseInJson)
    {
        $this->parse($responseInJson);

        if ($this->needResultParsing($responseInJson)) {

            $this->parseResult($responseInJson);
        }
    }

    /**
     * @internal
     *
     * @param $responseInJson
     */
    private function parse($responseInJson)
    {
        if (array_key_exists(self::MULTICAST_ID, $responseInJson)) {
            $this->messageId = $responseInJson[self::MULTICAST_ID];
        }

        if (array_key_exists(self::SUCCESS, $responseInJson)) {
            $this->numberTokensSuccess = $responseInJson[self::SUCCESS];
            $this->isSent              = $responseInJson[self::SUCCESS];
        }

        if (array_key_exists(self::FAILURE, $responseInJson)) {
            $this->numberTokensFailure = $responseInJson[self::FAILURE];
        }

        if (array_key_exists(self::CANONICAL_IDS, $responseInJson)) {
            $this->numberTokenModify = $responseInJson[self::CANONICAL_IDS];
        }
    }

    /**
     * @internal
     *
     * @param $responseInJson
     */
    private function parseResult($responseInJson)
    {
        foreach ($responseInJson[self::RESULTS] as $index => $result) {
            if ( ! $this->isSent($result)) {
                if (array_key_exists(self::ERROR, $result)) {
                    $this->resultMessage = $result[self::ERROR];
                }
            }
        }
    }


    /**
     * @internal
     *
     * @param $results
     *
     * @return bool
     */
    public function isSent($results)
    {
        return array_key_exists(self::MESSAGE_ID, $results) && ! array_key_exists(self::REGISTRATION_ID, $results);
    }

    /**
     * @internal
     *
     * @param $responseInJson
     *
     * @return bool
     */
    private function needResultParsing($responseInJson)
    {
        return array_key_exists(self::RESULTS,
                $responseInJson) && ($this->numberTokensFailure > 0 || $this->numberTokenModify > 0);
    }

    /**
     * Get the number of device reached with success.
     *
     * @return int
     */
    public function numberSuccess()
    {
        return $this->numberTokensSuccess;
    }

    public function getResultMessage()
    {
        return $this->resultMessage;
    }
}