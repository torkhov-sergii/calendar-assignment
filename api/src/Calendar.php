<?php

namespace App;

use Carbon\Carbon;

class Calendar
{
    protected array $markedDays = [];

    public function addMarkedDay(Carbon $day): void
    {
        $this->markedDays[] = $day;
    }

    public function getJson(): string
    {
        header('Content-type: application/json');
        return json_encode(array_map(fn($day) => $day->format('Y-m-d'), $this->markedDays));
    }
}
