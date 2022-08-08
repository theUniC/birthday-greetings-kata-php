<?php

declare(strict_types=1);

namespace Tests\BirthdayGreetingsKata;

use BirthdayGreetingsKata\XDate;
use PHPUnit\Framework\TestCase;

class XDateTest extends TestCase
{
    /**
     * @test
     */
    public function getters()
    {
        $xDate = new XDate('1789/01/24');
        $this->assertEquals(1, $xDate->getMonth());
        $this->assertEquals(24, $xDate->getDay());
    }

    /**
     * @test
     */
    public function isSameDate()
    {
        $xDate          = new XDate('1789/01/24');
        $sameDay        = new XDate('2001/01/24');
        $notSameDay     = new XDate('1789/01/25');
        $notSameMonth   = new XDate('1789/02/25');

        $this->assertTrue($xDate->isSameDay($sameDay),          'same');
        $this->assertFalse($xDate->isSameDay($notSameDay),      'not same day');
        $this->assertFalse($xDate->isSameDay($notSameMonth),    'not same month');
    }

    /**
     * @test
     */
    public function equality()
    {
        $base       = new XDate("2000/01/02");
        $same       = new XDate("2000/01/02");
        $different  = new XDate("2000/01/04");

        $this->assertFalse($base->equals(null));
        $this->assertFalse($base->equals(''));
        $this->assertTrue($base->equals($base));
        $this->assertTrue($base->equals($same));
        $this->assertFalse($base->equals($different));
    }

}
