<?php

namespace App\UseCase\Month;

use App\Http\Requests\Month\CurrentLimitRequest;
use App\Month;

class MonthIncreaseLimit implements MonthService
{
    public function create(array $request) :Month
    {
        $fields = Month::getFields($request['date']);

        $monthEdit = Month::where('month_number', $fields['month_number'])
            ->where('year', $fields['year'])->first();

        if ($monthEdit) {
            return $this->updateSum($monthEdit, $request);
        }

        if ($request['sum'] > config('expense.limit')) {
            $request['sum'] = 0;
            $request['limit'] = config('expense.limit');
            Month::add($request);
            throw new \DomainException('Не удалось добавить расход. Увеличьте предельную сумму расхода за ' . Date::getMonthName($fields['month_number']));
        }

        $month = Month::add($request);

        return $month;
    }

    public function updateSum($monthEdit, $request) :Month
    {
        $sum = (float)$monthEdit->sum + (float)$request['sum'];

        if ($sum > $monthEdit->limit) {
            throw new \DomainException('Не удалось добавить расход. Увеличьте предельную сумму расхода за ' . Date::getMonthName($monthEdit->month_number));
        }

        return $monthEdit->updateSum($monthEdit, $request);
    }

    public function changeCurrentMonthLimit($year, $monthNumber, CurrentLimitRequest $request) :Month
    {
        $month = Month::where([
            'month_number' => $monthNumber,
            'year' => $year,
        ])->first();

        if (!$month) {
            throw new \DomainException('Месяц не найден');
        }

        $month->updateLimit($request);

        return $month;
    }
}