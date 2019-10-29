@extends('layouts.app')
@section('styles')
    <style>
        @media screen and (max-width: 767px) {
            .page-head-title{
                width: 35%;
            }
        }
    </style>
@stop
@section('page-title')
    @t('categories')
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
@stop
@section('content')
    <div class="table-responsive statistics">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="{{ hc('red') }}">@tbl('category')</th>
                <th class="{{ hc('purple') }}">@tbl('competitor')</th>
                <th class="{{ hc('orange') }}">@tbl('average_price_difference')</th>
                <th class="{{ hc('red') }}">@tbl('linked_products')</th>
                <th class="{{ hc('green') }}">@tbl('more_expensive_products')</th>
                <th class="{{ hc('blue') }}">@tbl('cheaper_products')</th>
                <th class="{{ hc('purple') }}">@tbl('equal_products')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)

                <tr>
                    <td data-label="@t('category')" title="{{ $category->description }}">
                        <a href="{{ route('statistics.category.competitors.products.index', ["competitor_id" => $competitor->id, "category_id" => $category->id]) }}"
                           class="text-orange capital">
                            <strong class="underline-on-hover">{{ $category->name }}</strong>
                        </a>
                    </td>
                    <td data-label="@t('competitor')">
                        <a href="{{ url('/products?compName='. str_replace(' ', '||', $competitor->name)) }}">
                            {{ $competitor->name }}
                        </a>
                    </td>
                    <td data-label="@t('average_price_difference')">
                        <span class="label @if($category->data['average']['value'] > 0) increase
                                           @elseif($category->data['average']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ showVisualDifference($category->data['average']['value'], true) }}
                        </span>
                    </td>
                    <td data-label="@t('linked_products')" >
                        <span class="label @if($category->data['bindings']['value'] > 0) increase
                                           @elseif($category->data['bindings']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $category->data['bindings']['value'] }}
                        </span>
                    </td>
                    <td data-label="@t('more_expensive_products')">
                        <span class="label @if($category->data['higher']['value'] > 0) increase
                                           @elseif($category->data['higher']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $category->data['higher']['value'] }}
                        </span>
                    </td>
                    <td data-label="@t('cheaper_products')">
                        <span class="label @if($category->data['cheaper']['value'] > 0) increase
                                           @elseif($category->data['cheaper']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $category->data['cheaper']['value'] }}
                        </span>
                    </td>
                    <td data-label="@t('equal_products')">
                        <span class="label @if($category->data['equal']['value'] > 0) increase
                                           @elseif($category->data['equal']['value'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ $category->data['equal']['value'] }}
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
        App.datatables();
        $('.datatable').dataTable({
            language: {
                "searchPlaceholder": searchString(),
                "sEmptyTable": emptyTable(),
                "sInfo": getInfo(),
                "sInfoEmpty": getEmpty(),
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        });

        function searchString() {
            return envLang === 'en' ? 'Search...' : 'Suchen...';

        }

        function emptyTable() {
            return envLang === 'en' ? 'No Data Available' : 'Keine Daten vorhanden';
        }

        function getInfo() {
            return envLang === 'en' ? "Showing _START_ to _END_ of _TOTAL_ entries" : "_START_ bis _END_ von _TOTAL_ Einträgen"
        }

        function getEmpty() {
            return envLang === 'en' ? "Showing 0 to 0 of 0 entries" : "Zeige 0 bis 0 von 0 Einträgen"
        }
    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
