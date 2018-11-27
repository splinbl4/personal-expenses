<?php

namespace App\Http\Controllers;

use App\Category;
use App\Expense;
use App\Http\Requests\Expense\ExpenseRequest;
use App\Http\Requests\Month\CurrentLimitRequest;
use App\Month;
use App\UseCase\Date\Date;
use App\UseCase\Expense\ExpenseService;
use App\UseCase\Month\MonthService;
use Auth;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private $service;
    private $date;
    private $expense;
    private $monthService;

    public function __construct(ExpenseService $service, Date $date, Expense $expense, MonthService $monthService)
    {
        $this->service = $service;
        $this->date = $date;
        $this->expense = $expense;
        $this->monthService = $monthService;
    }

    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();

        return view('expense.create', compact('categories'));
    }

    public function store(ExpenseRequest $request)
    {
        try {
            $expense = $this->service->create(Auth::id(), $request);
        } catch (\DomainException $e) {
            return redirect()
                ->route('expense.report')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route(
                'expense.report.month',
                [
                    Date::getYear($expense->date),
                    Date::getMonth($expense->date)
                ]
            )
            ->with('success', 'Расход успешно создан!');
    }

    public function currentMonthLimitForm($year, $monthNumber)
    {
        $month = Month::where('month_number', $monthNumber)
            ->where('year', $year)->firstOrFail();

        return view('expense.limit_form', compact('year', 'month'));
    }

    public function currentMonthLimitStore($year, $month, CurrentLimitRequest $request)
    {
        try {
            $this->monthService->changeCurrentMonthLimit($year, $month, $request);
        } catch (\DomainException $e) {
            return redirect()->route('expense.limit.form', [$year, $month])
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('expense.report')
            ->with('success', 'Предельная сумма расхода успешно изменена!');
    }
}
