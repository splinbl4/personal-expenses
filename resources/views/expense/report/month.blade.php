@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <div class="btn-group-sm mb-3">
        <a href="{{route('expense.create')}}" class="btn btn-sm btn-primary">Добавить расход</a>
    </div>
    <div class="row justify-content-center">
        <h3>Отчет за {{$date::getMonthName($month)}}</h3>
    </div>
    {{--@if(\App\Expense::isIncreaseLimit())--}}
        {{--<div class="btn-group-sm mb-3">--}}
            {{--<p>Вы можете <a href="{{route('expense.limit.form', [$year, $month])}}" class="btn-link btn-primary">установить</a> предельную сумму ежемесячного расхода за {{\App\UseCase\Date\Date::getMonthName($month)}}.</p>--}}
        {{--</div>--}}
    {{--@endif--}}
    @include('layouts.partials._monthly_report')
@endsection

