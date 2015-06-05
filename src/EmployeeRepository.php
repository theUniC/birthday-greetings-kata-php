<?php

interface EmployeeRepository
{
    public function findAllWhoseBirthdayIs(XDate $xDate);
}