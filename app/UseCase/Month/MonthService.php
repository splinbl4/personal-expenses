<?php

namespace App\UseCase\Month;

use App\Http\Requests\Month\CurrentLimitRequest;
use App\Month;
use App\UseCase\Date\Date;

interface MonthService
{
    public function create(array $request) :Month;


    public function updateSum($monthEdit, $request) :Month;


    public function changeCurrentMonthLimit($year, $monthNumber, CurrentLimitRequest $request) :Month;
}