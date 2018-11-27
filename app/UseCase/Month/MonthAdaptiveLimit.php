<?php

namespace App\UseCase\Month;

use App\Http\Requests\Month\CurrentLimitRequest;
use App\Month;
use App\UseCase\Date\Date;
use Carbon\Carbon;

class MonthAdaptiveLimit implements MonthService
{
    public function create(array $request) :Month
    {
        $fields = Month::getFields($request['date']);

        $monthEdit = Month::where('month_number', $fields['month_number'])
            ->where('year', $fields['year'])->first();

        if ($monthEdit) {
            return $this->updateSum($monthEdit, $request);
        }

        $request['limit'] = config('expense.limit');
        $month = Month::add($request);

        if ($request['sum'] > config('expense.limit')) {
            $this->createNextMonth($request);
        }

        return $month;
    }

    public function updateSum($monthEdit, $request) :Month
    {
        $sum = (float)$request['sum'] + (float)$monthEdit->sum;
        if ($sum > $monthEdit->limit) {
            $this->checkNextMonth($request, $monthEdit->sum, $monthEdit->limit);
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

    public function checkNextMonth(array $request, $sum, $limit) :void
    {
        $fields = Month::getFields($request['date']);
        $nextMonthNumber = Carbon::parse($request['date'])->startOfMonth()->addMonth()->format('m');
        $year = $fields['year'];

        $nextMonth = Month::where('month_number', $nextMonthNumber)
            ->where('year', $year)->first();

        if ($nextMonth) {
            $this->editNextMonth($request);
        } else {
            $this->createNextMonth($request, $sum, $limit);
        }
    }

    public function createNextMonth(array $request, $sum = 0, $limit = 0) :void
    {
        $limit = $limit == 0 ? (float)config('expense.limit') : $limit;
        $overLimit = (float)$request['sum'] + (float)$sum - $limit;
        $request['limit'] = $limit - (float)$overLimit;
        $request['sum'] = 0;

        $fields = Month::getFields($request['date']);
        $nextMonthNumber = Carbon::parse($request['date'])->startOfMonth()->addMonth()->format('m');
        $year = $fields['year'];

        if ((int)$fields['month_number'] === 12) {
            $year = Carbon::parse($request['date'])->startOfYear()->addYear()->format('Y');
        }

        $request['date'] = $year . '-' . $nextMonthNumber;

        Month::add($request);
    }

    public function editNextMonth(array $request) :void
    {
        $fields = Month::getFields($request['date']);
        $nextMonthNumber = Carbon::parse($request['date'])->startOfMonth()->addMonth()->format('m');
        $year = $fields['year'];

        if ((int)$fields['month_number'] === 12) {
            $year = Carbon::parse($request['date'])->startOfYear()->addYear()->format('Y');
        }

        $nextMonth = Month::where('month_number', $nextMonthNumber)
            ->where('year', $year)->first();

        if (!$nextMonth) {
            throw new \DomainException('Месяц не найден');
        }

        $nextMonth->limit = $nextMonth->limit - $request['sum'];
        $nextMonth->save();
    }
}