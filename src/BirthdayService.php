<?php

class BirthdayService
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var SwiftMailerMessenger
     */
    private $messenger;

    public function __construct(EmployeeRepository $employeeRepository, Messenger $messenger)
    {
        $this->employeeRepository = $employeeRepository;
        $this->messenger = $messenger;
    }

    public function sendGreetings(XDate $xDate)
    {
        $employees = $this->employeeRepository->findAllWhoseBirthdayIs($xDate);

        foreach ($employees as $employee) {
            $this->sendBirthdayGreetingTo($employee);
        }
    }

    private function sendBirthdayGreetingTo($employee)
    {
        $recipient = $employee->getEmail();
        $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $subject = 'Happy Birthday!';
        $this->messenger->sendMessage('sender@here.com', $subject, $body, $recipient);
    }
}