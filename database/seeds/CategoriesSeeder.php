<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        Category::truncate();

        $categories = ['Продукты', 'Бензин', 'Квартплата', 'Детский сад', 'Прочее'];

        foreach ($categories as $category) {
            Category::create([
                'title' => $category
            ]);
        }
    }
}
