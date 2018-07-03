<?php

namespace Cimons\LaraFcm\Request;

use Cimons\LaraFcm\Message\Notification;

class Request extends BaseRequest
{
    protected $to;
    protected $notification;

    public function __construct($to, Notification $notification = null)
    {
        parent::__construct();

        $this->to           = $to;
        $this->notification = $notification;
    }


    /**
     * get to key transformed.
     *
     * @return array|null|string
     */
    protected function getTo()
    {
        $to = is_array($this->to) ? null : $this->to;
        return $to;
    }

    /**
     * get registrationIds transformed.
     *
     * @return array|null
     */
    protected function getRegistrationIds()
    {
        return is_array($this->to) ? $this->to : null;
    }
    
    /**
     * Build the body for the request.
     *
     * @return array
     */
    protected function buildBody()
    {
        $message = [
            'to' => $this->getTo(),
            'registration_ids' => $this->getRegistrationIds(),
            'notification' => $this->getNotification(),
        ];

        // remove null entries
        return array_filter($message);
    }

    /**
     * get notification transformed.
     *
     * @return array|null
     */
    protected function getNotification()
    {
        return $this->notification ? $this->notification->toArray() : null;
    }

}