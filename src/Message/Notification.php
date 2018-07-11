<?php

namespace Cimons\LaraFcm\Message;

use Illuminate\Contracts\Support\Arrayable;

class Notification implements Arrayable
{

    protected $title;
    protected $body;
    protected $sound;
    protected $clickAction;

    public function __construct(NotificationBuilder $builder)
    {

        $this->title = $builder->getTitle();
        $this->body  = $builder->getBody();
        $this->sound = $builder->getSound();
        $this->clickAction = $builder->getClickAction();
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
            'sound' => $this->sound,
            'click_action' => $this->clickAction,
        ];

        // remove null values
        $notification = array_filter($notification);

        return $notification;
    }
}