<?php

namespace App\Http\Controllers;

use App\Category;
use App\Expense;
use App\UseCase\Date\Date;
use App\UseCase\Expense\ExpenseService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $date;
    private $expense;
    private $service;

    public function __construct(Date $date, Expense $expense, ExpenseService $service)
    {
        $this->middleware('auth');
        $this->date = $date;
        $this->expense = $expense;
        $this->service = $service;
    }

    public function index()
    {
        $date = $this->date;

        $categories = Category::all();

        $arrExpensesForMonth = $this->expense->getCurrentMonthExpenses(
            Date::getNowMonth(),
            Date::getNowYear()
        )->toArray();

        $expenses = $this->expense
            ->forUser(Auth::user())
            ->forCurrentMonthExpenses(
                Date::getNowMonth(),
                Date::getNowYear()
            );

        $sumListPerDay = $this->service->getAmountOfExpenses($arrExpensesForMonth, 'date');

        $sumListCategory = $this->service->getAmountOfExpenses($arrExpensesForMonth, 'category_id');

        return view('home', compact('date', 'categories', 'expenses', 'sumListPerDay', 'sumListCategory'));
    }
}
