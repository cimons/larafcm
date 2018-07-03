<?php

namespace Cimons\LaraFcm\Message;

use Illuminate\Contracts\Support\Arrayable;

class Notification implements Arrayable
{

    protected $title;
    protected $body;
    protected $sound;

    public function __construct(NotificationBuilder $builder)
    {

        $this->title = $builder->getTitle();
        $this->body  = $builder->getBody();
        $this->sound = $builder->getSound();
    }

    /**
     * convert PayloadNotification to array.
     *
     * @return array
     */
    public function toArray()
    {
        $notification = [
            'title' => $this->title,
            'body'  => $this->body,
            'sound' => $this->sound
        ];

        // remove null values
        $notification = array_filter($notification);

        return $notification;
    }
}