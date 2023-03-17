<?php

namespace App\Utilities;

use Carbon\Carbon;

class Utilities 
{
    // Format mobile number add 254 extension to it
    public static function formatMobileNumber($mobile_no)
    {
        return '254'.substr(trim($mobile_no), 1);
    }

    //Convert a MS serialized datetime value from Excel to a PHP Date/Time object.
    public static function formatExcelToDateTimeObject($date)
    {
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
    }

    // Round number to given number of decimal places
    public static function roundNumberToDecimalPlaces($number, $decimal)
    {
        return round($number, $decimal);
    }
}