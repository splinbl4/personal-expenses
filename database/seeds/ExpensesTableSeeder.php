<?php

use App\Expense;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    public function run() :void
    {
        Expense::truncate();
        factory(Expense::class, 10)->create();
    }
}
