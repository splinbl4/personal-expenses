@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <h4>Задать предельную сумму расхода за {{\App\UseCase\Date\Date::getMonthName($month->month_number)}}</h4>
    <form method="POST" action="{{ route('expense.limit.store', [$month->year, $month->month_number]) }}">
        @csrf
        <div class="form-group">
            <label for="limit_sum" class="col-form-label">Предельная сумма</label>
            <input id="limit_sum" class="form-control{{ $errors->has('limit_sum') ? ' is-invalid' : '' }}" name="limit_sum" value="{{ old('limit_sum', $month->limit)}}">
            @if ($errors->has('limit_sum'))
                <span class="invalid-feedback"><strong>{{ $errors->first('limit_sum') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <a href="{{ route('expense.report') }}" class="btn btn-primary">Назад</a>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
@endsection