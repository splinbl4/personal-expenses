<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ (URL::current() == route('home')) ? 'active' : null }}" href="{{ route('home') }}">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('categories*') ? 'active' : null }}" href="{{ route('categories.index') }}">Категории</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('expenses/report*') ? 'active' : null }}" href="{{route('expense.report')}}">Сводный отчет</a>
    </li>
</ul>