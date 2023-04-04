<?php

declare(strict_types=1);

namespace BirthdayGreetingsKata;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

final class BirthdayService
{
    public function sendGreetings(string $fileName, XDate $xDate, string $smtpHost, int $smtpPort): void
    {
        $fileHandler = fopen($fileName, 'rb');
        fgetcsv($fileHandler);

        while ($employeeData = fgetcsv($fileHandler, null, ',')) {
            $employeeData = array_map('trim', $employeeData);
            $employee = new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
            if ($employee->isBirthday($xDate)) {
                $recipient = $employee->getEmail();
                $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
                $subject = 'Happy Birthday!';
                $this->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $subject, $body, $recipient);
            }
        }
    }

    private function sendMessage(string $smtpHost, int $smtpPort, string $sender, string $subject, string $body, string $recipient): void
    {
        // Create a mailer
        $mailer = new Mailer(
            Transport::fromDsn('smtp://' . $smtpHost . ':' . $smtpPort)
        );

        // Construct the message
        $msg = (new Email())
            ->subject($subject)
            ->from($sender)
            ->to($recipient)
            ->text($body);

        // Send the message
        $mailer->send($msg);
    }
}
