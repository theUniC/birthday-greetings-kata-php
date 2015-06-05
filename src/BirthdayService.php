<?php

class CsvEmployeeRepository
{
    /**
     * @var string
     */
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function findAllWhoseBirthdayIs(XDate $xDate)
    {
        $fileHandler = fopen($this->fileName, 'r');
        fgetcsv($fileHandler);

        $employees = [];

        while ($employeeData = fgetcsv($fileHandler, null, ',')) {
            $employeeData = array_map('trim', $employeeData);
            $employee = new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
            if ($employee->isBirthday($xDate)) {
                $employees[] = $employee;
            }
        }

        fclose($fileHandler);

        return $employees;
    }
}

class BirthdayService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var CsvEmployeeRepository
     */
    private $employeeRepository;

    public function __construct($employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function sendGreetings($fileName, XDate $xDate, $smtpHost, $smtpPort)
    {
        $employees = $this->employeeRepository->findAllWhoseBirthdayIs($xDate);

        foreach ($employees as $employee) {
            $recipient = $employee->getEmail();
            $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
            $subject = 'Happy Birthday!';
            $this->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $subject, $body, $recipient);
        }
    }

    private function sendMessage($smtpHost, $smtpPort, $sender, $subject, $body, $recipient)
    {
        // Create a mail session
        $this->mailer = Swift_Mailer::newInstance(Swift_SmtpTransport::newInstance($smtpHost, $smtpPort));

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

    // made protected for testing :-(
    protected function doSendMessage(Swift_Message $msg)
    {
        $this->mailer->send($msg);
    }
}