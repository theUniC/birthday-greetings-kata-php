<?php

class CallbackMessenger implements Messenger
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function sendMessage($sender, $subject, $body, $recipient)
    {
        $callable = $this->callback;
        $callable($sender, $subject, $body, $recipient);
    }
}