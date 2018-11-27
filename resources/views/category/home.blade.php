@extends('layouts.app')

@section('content')
    @include('layouts.partials._nav')
    <h4>Категории расходов</h4>
    <p><a href="{{ route('categories.create') }}" class="btn btn-success">Добавить категорию</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($categories as $category)
            <tr>
                <td>
                    <h5>{{ $category->title }}</h5>
                </td>
                <td>
                    <a href="{{route('categories.edit', $category->id)}}" class="btn btn-sm btn-primary">редактировать</a>
                    {{--{{Form::open(['route' => ['categories.destroy', $category], 'method' => 'delete', 'class' => 'form-delete'])}}--}}
                    {{--<button onclick="return confirm('Вы уверены?')" type="submit" class="button-delete" title="удалить">--}}
                        {{--<i class="fa fa-remove"></i>--}}
                    {{--</button>--}}
                    {{--{{Form::close()}}--}}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection