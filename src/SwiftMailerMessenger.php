<?php

class SwiftMailerMessenger implements Messenger
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $smtpHost;

    /**
     * @var int
     */
    private $smtpPort;

    public function __construct($smtpHost, $smtpPort)
    {
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
    }

    public function sendMessage($sender, $subject, $body, $recipient)
    {
        // Create a mail session
        $this->mailer = Swift_Mailer::newInstance(Swift_SmtpTransport::newInstance($this->smtpHost, $this->smtpPort));

        // Construct the message
        $msg = Swift_Message::newInstance($subject);
        $msg
            ->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body)
        ;

        // Send the message
        $this->doSendMessage($msg);
    }

    protected function doSendMessage(Swift_Message $msg)
    {
        $this->mailer->send($msg);
    }
}
