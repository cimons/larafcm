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
     * @internal
     *
     * @var null|string
     */
    protected $clickAction;

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
     * Indicates the action associated with a user click on the notification.
     *
     * @param string $action
     *
     * @return NotificationBuilder current instance of the builder
     */
    public function setClickAction($action)
    {
        $this->clickAction = $action;

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
     * Get ClickAction.
     *
     * @return null|string
     */
    public function getClickAction()
    {
        return $this->clickAction;
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

