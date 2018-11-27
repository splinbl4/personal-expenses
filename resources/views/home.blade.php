@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <div class="btn-group-sm mb-3">
        <a href="{{route('expense.create')}}" class="btn btn-sm btn-primary">Добавить расход</a>
    </div>
    <div class="row justify-content-center">
        <h3>Отчет за {{$date->getNowMonthName()}}</h3>
    </div>
    @include('layouts.partials._monthly_report')
@endsection
