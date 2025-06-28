<?php

namespace App\Helpers;

use Carbon\Carbon;

class ValidationDateFromString
{
    public function validate(string $date, string $format = 'd-m-Y')
    {
        try {
            $convertedDate = Carbon::createFromFormat($format, $date);
            return $convertedDate && $convertedDate->format($format) === $date;
        } catch (\Exception) {
            return false;
        }
    }
}
