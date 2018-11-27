<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('categories', 'CategoryController');

    Route::get('/expense/create', 'ExpenseController@create')->name('expense.create');
    Route::post('/expense/store', 'ExpenseController@store')->name('expense.store');

    Route::group(['prefix' => '/expenses/limit/{year}'], function($year){
        Route::get('{month}', 'ExpenseController@currentMonthLimitForm')->name('expense.limit.form');
        Route::post('{month}', 'ExpenseController@currentMonthLimitStore')->name('expense.limit.store');
    });

    Route::get('/expenses/report', 'ReportController@report')->name('expense.report');

    Route::group(['prefix' => '/expenses/report/{year}'], function($year){
        Route::get('{month}', 'ReportController@monthlyReport')->name('expense.report.month');
    });
});



