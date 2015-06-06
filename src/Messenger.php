<?php

interface Messenger
{
    public function sendMessage($sender, $subject, $body, $recipient);
}