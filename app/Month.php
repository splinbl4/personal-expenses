<?php

namespace App;

use App\Http\Requests\Month\CurrentLimitRequest;
use App\UseCase\Date\Date;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string month_number
 * @property string year
 * @property int limit
 * @property int sum
 */

class Month extends Model
{
    protected $fillable = [
        'month_number', 'year', 'limit', 'sum',
    ];

    public static function add($request) :Month
    {
        $fields = self::getFields($request['date']);

        $expense = Month::create([
            'month_number' => $fields['month_number'],
            'year' => $fields['year'],
            'sum' => $request['sum'],
            'limit' => $request['limit'],
        ]);

        return $expense;
    }

    public function updateSum(Month $month, $request) :Month
    {
        $sum = (float)$month->sum + (float)$request['sum'];

        $month->update([
            'sum' => $sum,
        ]);

        return $month;
    }

    public static function getFields(string $date) :array
    {
        return [
            'month_number' => Date::getMonth($date),
            'year' => Date::getYear($date),
        ];
    }

    public function updateLimit(CurrentLimitRequest $request) :void
    {
        $this->limit = $request['limit_sum'];
        $this->save();
    }
}
