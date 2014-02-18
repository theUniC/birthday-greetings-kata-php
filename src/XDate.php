<?php

class XDate
{
    /**
     * @var DateTime
     */
    private $date;

    public function __construct($yyyyMMdd)
    {
        $this->date = DateTime::createFromFormat('Y/m/d', $yyyyMMdd);
    }

    public function getDay()
    {
        return (int) $this->date->format('d');
    }

    public function getMonth()
    {
        return (int) $this->date->format('m');
    }

    public function isSameDay(XDate $anotherDate)
    {
        return
            $anotherDate->getDay() == $this->getDay()
            && $anotherDate->getMonth() == $this->getMonth()
        ;
    }

    public function equals($obj)
    {
        if (!($obj instanceof XDate)) {
            return false;
        }

        return $obj->date == $this->date;
    }

    public function __toString()
    {
        return $this->date->format('Y/m/d');
    }
}