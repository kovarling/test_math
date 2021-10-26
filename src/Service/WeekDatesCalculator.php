<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Service;


class WeekDatesCalculator
{
    public static function getWeekIndexByDate(\DateTimeImmutable $date) : string
    {
        $day = $date->format('w');

        $week_start = date('Y-m-d', strtotime('-'.$day.' days', $date->getTimestamp()));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days', $date->getTimestamp()));
        return $week_start.':'.$week_end;
    }

    // change week start to Monday from Sunday
    private function convertWeekDays($day) : int
    {
        switch ($day) {
            case 0:
                return 6;
            default:
                return $day - 1;
        }
    }
}