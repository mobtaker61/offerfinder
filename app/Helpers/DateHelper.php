<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function calculateRemainingDays($endDate)
    {
        $endDate = Carbon::parse($endDate);
        return abs((int) $endDate->diffInDays(Carbon::now()));
    }
}