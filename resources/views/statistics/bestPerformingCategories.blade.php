@extends('layouts.app')
@section('styles')
    <style>
        .page-top-button-area h4{
            font-size: 13px;
        }

        @media screen and (max-width: 767px) {
            .page-top-button-area h4{
                font-size: 10px;
            }
        }
    </style>
@endsection
@section('page-title')
    @t('top_daily_categories')
@stop
@section('page-button')

    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
    @if(\App\User::requestCheck('competitorCreate'))
        <a class="btn-header-mobile-view" style="margin-top: 5px" href="{{ route('pages.create') }}">
            <div class="col-xs-12 orange page-top-button-area">
                <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                    <i class="fa fa-plus-circle text-light-op"></i>
                </div>
                <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0">
                    <h4 class="widget-text text-right">
                        @t('add_page')
                    </h4>
                </div>
            </div>
        </a>
    @endif
@stop
@section('content')
    <div class="table-responsive statistics">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="{{ hc(0) }}">@tbl('category')</th>
                <th class="{{ hc(1) }}">@tbl('percentage_difference')</th>
                <th class="{{ hc(2) }}">@tbl('price_difference')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($productCategories as $key => $productCategoryData)
                <tr>
                    <td data-label="@t('category')">
                        <div class="text-orange capital">
                            <a href="{{ route('statistics.trending.data.showProducts', [ "category_id" => $productCategoryData[0]['category_id']]) }}">
                                <strong class="underline-on-hover">
                                    {{ $key }}
                                </strong>
                            </a>
                        </div>


                    </td>
                    <td data-label="@t('percentage')"
                        data-sort="{{$productCategoryData->avg('percentage_diff')}}">

                            <span class="label @if($productCategoryData->avg('percentage_diff') > 0) increase
                                           @elseif($productCategoryData->avg('percentage_diff') == 0) neutral
                                           @else decrease
                                           @endif">
                                {{ showVisualDifference(round($productCategoryData->avg('percentage_diff'), 2), true) }}
                            </span>


                    </td>
                    <td data-label="@t('price_difference')">
                            <span class="label @if($productCategoryData->avg('price_diff') > 0) increase
                                           @elseif($productCategoryData->avg('price_diff') == 0) neutral
                                           @else decrease
                                           @endif">
                                {{ formatMoney(round( $productCategoryData->avg('price_diff') ,2))  }}
{{--                                {{showVisualDifference(round( $productCategoryData->avg('price_diff') ,2))  }} €--}}
                            </span>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        App.datatables();
        // $('.datatable').append('<caption style="caption-side: top">A fictional company\'s staff table.</caption>');
        $('.datatable').DataTable(
            {
                language: {
                    "searchPlaceholder": searchString(),
                    "sEmptyTable": emptyTable(),
                    "sInfo": getInfo(),
                    "sInfoEmpty": getEmpty(),
                },
                "order": [[1, "desc"]]
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
