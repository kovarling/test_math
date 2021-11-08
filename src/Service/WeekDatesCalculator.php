<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Service;

class WeekDatesCalculator
{
    private const SUNDAY_WEEK_INDEX = 0;
    private const LAST_WEEK_INDEX = 6;

    public function getWeekIndexByDate(\DateTimeImmutable $date): string
    {
        $day = (int) $date->format('w');

        if ($day === self::SUNDAY_WEEK_INDEX) { // change week start to Monday from Sunday
            $day = self::LAST_WEEK_INDEX;
        } else {
            --$day;
        }

        $week_start = date('Y-m-d', strtotime('-'.$day.' days', $date->getTimestamp()));
        $week_end = date('Y-m-d', strtotime('+'.(6 - $day).' days', $date->getTimestamp()));

        return $week_start.':'.$week_end;
    }
}
