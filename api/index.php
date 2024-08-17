<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Content-Type');

require __DIR__ . '/vendor/autoload.php';

use App\Calendar;
use Carbon\Carbon;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$year = $data['year'];
$month = $data['month'];

$date = Carbon::parse("$month $year");

$calendar = new Calendar;
$calendar->addMarkedDay($date->clone()->setDay(5));
$calendar->addMarkedDay($date->clone()->setDay(10));
$calendar->addMarkedDay($date->clone()->setDay(15));
echo $calendar->getJson();
