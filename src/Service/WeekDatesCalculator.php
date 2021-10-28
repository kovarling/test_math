<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Service;

class WeekDatesCalculator
{
    public static function getWeekIndexByDate(\DateTimeImmutable $date): string
    {
        $day = (int) $date->format('w');

        switch ($day) { // change week start to Monday from Sunday
            case 0:
                $day = 6;
                break;
            default:
                $day--;
        }

        $week_start = date('Y-m-d', strtotime('-'.$day.' days', $date->getTimestamp()));
        $week_end = date('Y-m-d', strtotime('+'.(6 - $day).' days', $date->getTimestamp()));

        return $week_start.':'.$week_end;
    }
}
