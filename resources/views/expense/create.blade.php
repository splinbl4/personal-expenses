@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <h4>Добавить расход</h4>
    <form method="POST" action="{{ route('expense.store') }}">
        @csrf
        <div class="form-group">
            <label for="sum" class="col-form-label">Сумма</label>
            <input id="sum" class="form-control{{ $errors->has('sum') ? ' is-invalid' : '' }}" name="sum" value="{{ old('sum')}}">
            @if ($errors->has('sum'))
                <span class="invalid-feedback"><strong>{{ $errors->first('sum') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <label for="date" class="col-form-label">Дата</label>
            <input type="date" id="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d'))}}">
            @if ($errors->has('date'))
                <span class="invalid-feedback"><strong>{{ $errors->first('date') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <label for="category_id" class="col-form-label">Категория</label>
            {{Form::select('category_id',
            $categories,
             null,
            ['class' => 'form-control select2'])}}
        </div>

        <div class="form-group">
            <a href="{{ route('home') }}" class="btn btn-primary">Назад</a>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
@endsection