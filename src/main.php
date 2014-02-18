<?php

$service = new BirthdayService();
$service->sendGreetings('employee_data.txt', new XDate('2008/10/08'), 'localhost', 25);