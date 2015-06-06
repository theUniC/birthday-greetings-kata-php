<?php

class AcceptanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var int
     */
    private static $SMTP_PORT = 25;

    /**
     * @var Swift_Message[]
     */
    private $messagesSent = [];

    /**
     * @var BirthdayService
     */
    private $service;

    public function setUp()
    {
        $this->service = new BirthdayService(
            new CsvEmployeeRepository(__DIR__ . '/resources/employee_data.txt'),
            new FakeMessenger('localhost', static::$SMTP_PORT, function (Swift_Message $msg) {
                $this->messagesSent[] = $msg;
            })
        );
    }

    public function tearDown()
    {
        $this->service = $this->messagesSent = null;
    }

    /**
     * @test
     */
    public function willSendGreetings_whenItsSomebodysBirthday()
    {
        $this->service->sendGreetings(__DIR__ . '/resources/employee_data.txt', new XDate('2008/10/08'), 'localhost', static::$SMTP_PORT);

        $this->assertCount(1, $this->messagesSent, 'message not sent?');
        $message = $this->messagesSent[0];
        $this->assertEquals('Happy Birthday, dear John!', $message->getBody());
        $this->assertEquals('Happy Birthday!', $message->getSubject());
        $this->assertCount(1, $message->getTo());
        $this->assertEquals('john.doe@foobar.com', array_keys($message->getTo())[0]);
    }

    /**
     * @test
     */
    public function willNotSendEmailsWhenNobodysBirthday()
    {
        $this->service->sendGreetings(__DIR__ . '/resources/employee_data.txt', new XDate('2008/01/01'), 'localhost', static::$SMTP_PORT);

        $this->assertCount(0, $this->messagesSent, 'what? messages?');
    }
}

class FakeMessenger extends Messenger
{
    /**
     * @var Closure
     */
    private $callback;

    public function __construct($smtpHost, $smtpPort, Closure $callback)
    {
        $this->callback = $callback;

        parent::__construct($smtpHost, $smtpPort);
    }

    protected function doSendMessage(Swift_Message $msg)
    {
        $callable = $this->callback;
        $callable($msg);
    }
}