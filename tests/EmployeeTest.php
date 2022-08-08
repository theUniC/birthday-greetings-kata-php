<?php
declare(strict_types=1);

namespace Tests\BirthdayGreetingsKata;

use BirthdayGreetingsKata\Employee;
use BirthdayGreetingsKata\XDate;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * @test
     */
    public function birthday()
    {
        $employee = new Employee('foo', 'bar', '1990/01/31', 'a@b.c');
        $this->assertFalse($employee->isBirthday(new XDate('2008/01/30')), 'not his birthday');
        $this->assertTrue($employee->isBirthday(new XDate('2008/01/31')), 'his birthday');
    }

    /**
     * @test
     */
    public function equality()
    {
        $base       = new Employee('First', 'Last', '1999/09/01', 'first@last.com');
        $same       = new Employee('First', 'Last', '1999/09/01', 'first@last.com');
        $different  = new Employee('First', 'Last', '1999/09/01', 'boom@boom.com');

        $this->assertFalse($base->equals(null));
        $this->assertFalse($base->equals(''));
        $this->assertTrue($base->equals($same));
        $this->assertFalse($base->equals($different));
    }
}
