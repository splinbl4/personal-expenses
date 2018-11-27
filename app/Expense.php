<?php

namespace App;

use App\Http\Requests\Expense\ExpenseRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
* @property int $id
* @property string $sum
* @property string $date
* @property int $category_id
* @property int $user_id
*/

class Expense extends Model
{
    protected $fillable = ['sum', 'date', 'category_id', 'user_id'];

    public function getDayExpense(string $date) :string
    {
        return Carbon::parse($date)->format('d');
    }

    public function getCurrentMonthExpenses(int $month, int $year)
    {
        return Expense::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeForCurrentMonthExpenses(Builder $query, string $month, string $year)
    {
        return $query->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
    }

    public static function add(int $userId, ExpenseRequest $request) :Expense
    {
        $expense = Expense::create([
            'sum' => $request['sum'],
            'date' => $request['date'],
            'category_id' => $request['category_id'],
            'user_id' => $userId,
        ]);

        return $expense;
    }

    public function edit(Expense $expense, ExpenseRequest $request) :Expense
    {
        $expense->update([
            'sum' => $request['sum'],
            'date' => $request['date'],
            'category_id' => $request['category_id'],
        ]);

        return $expense;
    }

    public static function isAdaptiveLimit()
    {
        return config('expense.scenario') === 'adaptive_limit';
    }

    public static function isIncreaseLimit()
    {
        return config('expense.scenario') === 'increase_limit';
    }
}
