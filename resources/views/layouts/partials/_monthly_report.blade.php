<table class="table table-bordered text-center">
    <thead>
    <tr>
        <th scope="col">№</th>
        @foreach($categories as $category)
            <th scope="col">{{$category->title}}</th>
        @endforeach
        <th scope="col">Сумма по дням</th>
    </tr>
    </thead>
    <tbody>
    {{-- TODO Пока не придумал, как сделать по другому --}}
    @for ($i = 1; $i <= $date->getDaysMonth(); $i++)
        <tr>
            <th scope="row">{{$i}}</th>
            @foreach($categories as $keys => $category)
                @php ($isTd = false)
                @foreach($expenses as $key => $expense)
                    @if($expense->getDayExpense($expense->date) == $i && $category->id == $expense->category_id)
                        <td>{{$expense->sum}}</td>
                        @php ($isTd = true)
                    @endif
                @endforeach
                @if($isTd === false)
                    <td></td>
                @endif
            @endforeach
            @foreach($sumListPerDay as $day => $sumPerDay)
                @if($i == $day)
                    @php ($isTd = true)
                    <th scope="row">{{$sumPerDay}}</th>
                @endif
            @endforeach
            @if($isTd === false)
                <th scope="row"></th>
            @endif
        </tr>
    @endfor
    <tr>
        <th scope="row">Сумма по категории</th>
        @foreach($categories as $category)
            @php ($isTd = false)
            @foreach($sumListCategory as $categoryId => $sumCategory)
                @if($category->id == $categoryId)
                    @php ($isTd = true)
                    <th scope="row">{{$sumCategory}}</th>
                @endif
            @endforeach
            @if($isTd === false)
                <th></th>
            @endif
        @endforeach
        <th></th>
    </tr>
    </tbody>
</table>
