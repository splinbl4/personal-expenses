<?php
namespace App\UseCase\Expense;

use App\Expense;
use App\Http\Requests\Expense\ExpenseRequest;
use App\UseCase\Month\MonthService;
use Carbon\Carbon;

class ExpenseService
{
    private $monthService;

    public function __construct(MonthService $monthService)
    {
        $this->monthService = $monthService;
    }

    public function create(int $userId, ExpenseRequest $request) :Expense
    {
        $this->monthService->create($request->toArray());

        $expenseEdit = Expense::where('date', $request['date'])
            ->where('category_id', $request['category_id'])->first();

        if ($expenseEdit) {
            return $this->edit($expenseEdit->id, $request);
        }

        $expense = Expense::add($userId, $request);

        return $expense;
    }

    public function edit(int $expenseId, ExpenseRequest $request) :Expense
    {
        $expense = Expense::findOrFail($expenseId);

        $expense->edit($expense, $request);

        return $expense;
    }

    public function getAmountOfExpenses(array $arrExpenses, string $param) :array
    {
        $arrSum = [];
        $listSum = [];

        foreach ($arrExpenses as $expensesForMonth) {
            switch ($param) {
                case 'date':
                    $arrSum[(int)Carbon::parse($expensesForMonth['date'])->format('d')][] = $expensesForMonth;
                    break;
                case 'category_id':
                    $arrSum[$expensesForMonth['category_id']][] = $expensesForMonth;
                    break;
                case 'month':
                    $arrSum[
                        (int)Carbon::parse($expensesForMonth['date'])->format('Y') . '-' .
                        (int)Carbon::parse($expensesForMonth['date'])->format('m')
                    ][] = $expensesForMonth;
                    break;
            }
        }

        foreach ($arrSum as $key => $expense) {
            $listSum[$key] = array_sum(array_map(function ($row) {
                return $row['sum'];
            }, $expense));
        }

        ksort($listSum);

        return $listSum;
    }
}