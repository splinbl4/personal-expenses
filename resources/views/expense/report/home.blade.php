@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <div class="btn-group-sm mb-3">
        <a href="{{route('expense.create')}}" class="btn btn-sm btn-primary">Добавить расход</a>
    </div>
    <h3>Сводный отчет по расходам</h3>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Месяц</th>
            <th>Сумма расходов за месяц</th>
            <th>Предельная сумма расходов за месяц</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($reports as $date => $report)
            <tr>
                <td>
                    <h5>{{\App\UseCase\Date\Date::getMonthName($report->month_number)}}</h5>
                </td>
                <td>{{$report->sum}}</td>
                <td>{{$report->limit}}</td>
                <td>
                    @if($report->sum != 0)
                        <a href="{{route(
                            'expense.report.month',
                            [
                                $report->year,
                                $report->month_number
                            ]
                        )}}" class="btn btn-sm btn-primary">Посмотреть</a>
                    @endif
                    @if(\App\Expense::isIncreaseLimit())
                        <a href="{{route('expense.limit.form', [$report->year, $report->month_number])}}" class="btn btn-sm btn-primary">Увеличить предельную сумму расходов</a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection