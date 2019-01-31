<?php

declare(strict_types=1);

namespace BirthdayGreetingsKata;

final class Employee
{
    /**
     * @var XDate
     */
    private $birthDate;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $email;

    public function __construct($firstName, $lastName, $birthDate, $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = new XDate($birthDate);
        $this->email = $email;
    }

    public function isBirthday(XDate $today): bool
    {
        return $today->isSameDay($this->birthDate);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function __toString(): string
    {
        return 'Employee ' . $this->firstName . ' ' . $this->lastName . ' <' . $this->email . '> born ' . $this->birthDate;
    }

    public function equals($obj): bool
    {
        if ($this == $obj) {
            return true;
        }

        if (null === $obj) {
            return false;
        }

        if (!($obj instanceof self)) {
            return false;
        }

        if (null === $this->birthDate) {
            if (null !== $obj->birthDate) {
                return false;
            }
        } elseif (!$this->birthDate->equals($obj->birthDate)) {
            return false;
        }

        if (null === $this->email) {
            if (null !== $obj->email) {
                return false;
            }
        } elseif ($this->email !== $obj->email) {
            return false;
        }

        if (null === $this->firstName) {
            if (null !== $obj->firstName) {
                return false;
            }
        } elseif ($this->firstName !== $obj->firstName) {
            return false;
        }

        if (null === $this->lastName) {
            if (null !== $obj->lastName) {
                return false;
            }
        } elseif (!$this->lastName !== $obj->lastName) {
            return false;
        }

        return true;
    }
}
