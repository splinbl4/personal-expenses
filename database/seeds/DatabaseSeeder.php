<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run() :void
    {
         $this->call(CategoriesSeeder::class);
//         $this->call(ExpensesTableSeeder::class);
    }
}
