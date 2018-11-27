<?php

namespace App\Http\Controllers;

use App\Category;
use App\Expense;
use App\Month;
use App\UseCase\Date\Date;
use App\UseCase\Expense\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private $service;
    private $date;
    private $expense;

    public function __construct(ExpenseService $service, Date $date, Expense $expense)
    {
        $this->service = $service;
        $this->date = $date;
        $this->expense = $expense;
    }

    public function report()
    {
        $reports = Month::all();

        return view('expense.report.home', compact('reports'));
    }

    public function monthlyReport(int $year, int $month)
    {
        $expenses = $this->expense
            ->forUser(Auth::user())
            ->forCurrentMonthExpenses(
                $month,
                $year
            );

        if (!count($expenses)) {
            abort(404);
        }
        $date = $this->date;
        $categories = Category::all();

        $arrExpensesForMonth = $this->expense->getCurrentMonthExpenses(
            $month,
            $year
        )->toArray();

        $sumListPerDay = $this->service->getAmountOfExpenses($arrExpensesForMonth, 'date');

        $sumListCategory = $this->service->getAmountOfExpenses($arrExpensesForMonth, 'category_id');

        return view('expense.report.month', compact('date', 'month', 'year', 'categories', 'expenses', 'sumListPerDay', 'sumListCategory'));
    }
}
