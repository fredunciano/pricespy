@extends('layouts.app')
@section('page-title')
    @tl('category_performance_for') {{ $category->name }}
@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="{{ hc('red') }}">@tbl('competitor')</th>
                <th class="{{ hc('purple') }}">@tbl('average_price_difference')</th>
                <th class="{{ hc('orange') }}">@tbl('linked_products')</th>
                <th class="{{ hc('red') }}">@tbl('more_expensive_products')</th>
                <th class="{{ hc('green') }}">@tbl('cheaper_products')</th>
                <th class="{{ hc('blue') }}">@tbl('equal_products')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($competitors as $competitor)
                <tr>
                    <td>
                        <a href="{{ route('statistics.competitor.categories.index', $competitor['competitor']->id) }}">
                            <strong>{{ $competitor['competitor']->name }}</strong>
                        </a>
                    </td>
                    <td >
                        <span class="label @if($competitor['data']['average']['rawValue'] > 0) increase
                                           @elseif($competitor['data']['average']['rawValue'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $competitor['data']['average']['value'] }}
                        </span>
                    </td>
                    <td >
                        <span class="label @if($competitor['data']['bindings']['value'] > 0) increase
                                           @elseif($competitor['data']['bindings']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $competitor['data']['bindings']['value'] }}
                        </span>
                    </td>
                    <td >
                        <span class="label @if($competitor['data']['higher']['value'] > 0) increase
                                           @elseif($competitor['data']['higher']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $competitor['data']['higher']['value'] }}
                        </span>
                    </td>
                    <td >
                        <span class="label @if($competitor['data']['cheaper']['value'] > 0) increase
                                           @elseif($competitor['data']['cheaper']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $competitor['data']['cheaper']['value'] }}
                        </span>
                    </td>
                    <td >
                        <span class="label @if($competitor['data']['equal']['value'] > 0) increase
                                           @elseif($competitor['data']['equal']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $competitor['data']['equal']['value'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('partials.back', ['back' => route('statistics.competitors.index')])
@endsection
@section('scripts')
    <script>
        UiTables.init();
    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection