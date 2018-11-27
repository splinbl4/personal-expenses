<?php
namespace App\UseCase\Date;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

class Date
{
    public static $nowDay;
    public static $nowMonth;
    public static $nowYear;

    public static function getDayExpense(string $date) :string
    {
        return Carbon::parse($date)->format('d');
    }

    public function getDaysMonth() :int
    {
        $nowMonth = Carbon::parse()->format('m');
        $nowYear = Carbon::parse()->format('y');

        return cal_days_in_month(CAL_GREGORIAN, $nowMonth, $nowYear);
    }

    public function getNowMonthName() :string
    {
        return Lang::get('date.f' .  (self::getNowMonth()));
    }

    public static function getMonthName(string $month) :string
    {
        return Lang::get('date.f' .  ($month));
    }

    public static function getYear(string $date) :string
    {
        return Carbon::parse($date)->format('Y');
    }

    public static function getMonth(string $date) :string
    {
        return Carbon::parse($date)->format('m');
    }

    public static function dateList(): array
    {
        return [
            static::$nowDay => Carbon::parse()->format('d'),
            static::$nowMonth => Carbon::parse()->format('m'),
            static::$nowYear => Carbon::parse()->format('Y'),
        ];
    }

    public static function getNowDay() :string
    {
        return self::$nowDay = Carbon::parse()->format('d');
    }

    public static function getNowMonth() :string
    {
        return self::$nowMonth = Carbon::parse()->format('m');
    }

    public static function getNowYear() :string
    {
        return self::$nowYear = Carbon::parse()->format('Y');
    }

    public static function getAllMonth()
    {
        return [
            'Январь' => 1,
            'Февраль' => 2,
            'Март' => 3,
            'Апрель' => 4,
            'Май' => 5,
            'Июнь' => 6,
            'Июль' => 7,
            'Август' => 8,
            'Сентябрь' => 9,
            'Октябрь' => 10,
            'Ноябрь' => 11,
            'Декабрь' => 12,
        ];
    }
}