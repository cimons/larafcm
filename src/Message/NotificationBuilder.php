<?php

namespace Cimons\LaraFcm\Message;

use Cimons\LaraFcm\Message\Notification;

class NotificationBuilder
{
    /**
     * @internal
     *
     * @var null|string
     */
    protected $title;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $body;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $sound;

    /**
     * Title must be present on android notification and ios (watch) notification.
     *
     * @param string $title
     */
    public function __construct($title = null)
    {
        $this->title = $title;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * Get title.
     *
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get body.
     *
     * @return null|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get Sound.
     *
     * @return null|string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * Build an PayloadNotification.
     *
     * @return Notification
     */
    public function build()
    {
        return new Notification($this);
    }
}

