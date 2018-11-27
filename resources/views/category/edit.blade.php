@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <h4>Изменить категорию расходов</h4>
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="col-form-label">Имя</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="name" value="{{ old('title', $category->title) }}">
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Назад</a>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
@endsection