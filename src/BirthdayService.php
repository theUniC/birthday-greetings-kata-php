<?php

class BirthdayService
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var Messenger
     */
    private $messenger;

    public function __construct(EmployeeRepository $employeeRepository, Messenger $messenger)
    {
        $this->employeeRepository = $employeeRepository;
        $this->messenger = $messenger;
    }

    public function sendGreetings($fileName, XDate $xDate, $smtpHost, $smtpPort)
    {
        $employees = $this->employeeRepository->findAllWhoseBirthdayIs($xDate);

        foreach ($employees as $employee) {
            $this->sendBirthdayGreetingTo($employee, $smtpHost, $smtpPort);
        }
    }

    private function sendBirthdayGreetingTo($employee, $smtpHost, $smtpPort)
    {
        $recipient = $employee->getEmail();
        $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $subject = 'Happy Birthday!';
        $this->messenger->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $subject, $body, $recipient);
    }
}