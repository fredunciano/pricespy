@extends('layouts.app')
@section('page-title')
    @t('statistics') @t('overview')
@stop
@section('styles')
    <style>
        .btn-custom-1 {
            color: #fff;
            text-transform: uppercase;
            text-align: right !important;
            background-color: #a98ec3;
            border-color: #a98ec3;
        }

        .btn-custom-2 {
            color: #fff;
            text-transform: uppercase;
            text-align: right !important;
            background-color: #eb4d6c;
            border-color: #eb4d6c;
        }

        .btn-custom-1:hover, .btn-custom-2:hover {
            color: #fff;
        }

        .btn-custom-3, .btn-custom-3:hover, .btn-custom-3:focus {
            min-width: auto;
            text-transform: uppercase;
            text-align: right !important;
        }

        @media screen and (max-width: 767px) {
            .mobile-responsive-v1 td::before {
                width: 45%;
            }
        }

        .clearfix:before, .clearfix:after, .dl-horizontal dd:before, .dl-horizontal dd:after, .container:before, .container:after, .container-fluid:before, .container-fluid:after, .row:before, .row:after, .form-horizontal .form-group:before, .form-horizontal .form-group:after, .btn-toolbar:before, .btn-toolbar:after, .btn-group-vertical > .btn-group:before, .btn-group-vertical > .btn-group:after, .nav:before, .nav:after, .navbar:before, .navbar:after, .navbar-header:before, .navbar-header:after, .navbar-collapse:before, .navbar-collapse:after, .pager:before, .pager:after, .panel-body:before, .panel-body:after, .modal-header:before, .modal-header:after, .modal-footer:before, .modal-footer:after {
            display: initial;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/d3-chart-custom.css') }}">
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; float: left; padding-right: 20px; padding-left: 15px">
        <button id="toggle-table-view" class="btn btn-orange"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>

    {{--DESKTOP BUTTONS--}}
    <a class="btn btn-custom-1 show-for-desktop toggle-button"
       href="#" data-div="priceDifference">
        {!! insertBrTagToWords(t('price_diff_by_cat')) !!}
    </a>
    <a class="btn btn-custom-2 show-for-desktop toggle-button"
       href="#" data-div="category-percentage-difference">
        {!! insertBrTagToWords(t('category_percentage_difference')) !!}
    </a>
    <a class="btn btn-custom-3 show-for-desktop toggle-button"
       href="#" data-div="table" style="display: none">
        Tabellarische <br>Übersicht
    </a>
    {{--MOBILE BUTTONS--}}
    <a class="btn btn-custom-1 btn-header-mobile-view show-for-mobile toggle-button"
       href="#" data-div="priceDifference" id="bubble-button">
        {!! insertBrTagToWords(t('price_diff_by_cat')) !!}
    </a>
    <a class="btn btn-custom-2 btn-header-mobile-view show-for-mobile toggle-button"
       href="#" data-div="category-percentage-difference" id="d3-button">
        {!! insertBrTagToWords(t('category_percentage_difference')) !!}
    </a>
    <a class="btn btn-custom-3 btn-header-mobile-view show-for-mobile toggle-button"
       href="#" data-div="table" style="display: none">
        Tabellarische <br>Übersicht
    </a>
    <a class="btn btn-custom-3 btn-header-mobile-view show-for-mobile"
       style="text-align: right; min-width: 190px; text-transform: uppercase; display: none"
       href="javascript:void(0)"
       onclick="view(0)"
       id="table-button"

    >
        {!! t('table_overview') !!}
    </a>
@stop
@section('content')
    <div id="table" class="toggle-div">
{{--        <div class="table-responsive" id="show-bubble-chart" style="display: none">--}}
{{--            <iframe src="{{ route('statistics.priceDifferenceByCategory.index') }}"--}}
{{--                    style="width: 100%; min-height: 600px"--}}
{{--                    frameborder="0"></iframe>--}}
{{--        </div>--}}
{{--        <div class="table-responsive" id="show-d3-chart" style="display: none">--}}
{{--            <iframe src="{{ route('statistics.category.percentage.difference') }}"--}}
{{--                    style="width: 100%; min-height: 600px"--}}
{{--                    frameborder="0"></iframe>--}}
{{--        </div>--}}

        <div class="table-responsive" id="show-table">
            <table class="table table-custom table-vcenter datatable">
                <thead>
                <tr>
                    <th class="{{ hc(0) }}">@tbl('competitor')</th>
                    <th class="{{ hc(1) }}">@tbl('average_price_difference')</th>
                    <th class="{{ hc(2) }}">@tbl('linked_products')</th>
                    <th class="{{ hc(3) }}">@tbl('more_expensive_products')</th>
                    <th class="{{ hc(4) }}">@tbl('cheaper_products')</th>
                    <th class="{{ hc(5) }}">@tbl('equal_products')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competitors as $competitor)
                    <tr>
                        <td data-label="@t('competitor')">
                            <div class="text-orange capital">
                                <a href="{{ route('statistics.competitor.categories.index', $competitor->id) }}"
                                   class="text-orange capital">
                                    <strong class="underline-on-hover">{{ $competitor->name }}</strong>
                                </a>
                            </div>

                        </td>
                        <td data-label="@t('average_price_difference')"
                            data-order="{{ $competitor->difference['average']['value'] }}">
                        <span class="label @if($competitor->difference['average']['value'] > 0) increase
                                           @elseif($competitor->difference['average']['value'] == 0) neutral
                                           @else decrease @endif">
                            {{ showVisualDifference($competitor->difference['average']['value'], true) }}
                        </span>
                        </td>
                        <td data-label="@t('linked_products')">
                        <span class="label @if($competitor->difference['bindings']['value'] > 0) increase
                                           @elseif($competitor->difference['bindings']['value'] == 0) neutral
                                           @else decrease @endif">
                            {{ $competitor->difference['bindings']['value'] }}
                        </span>
                        </td>
                        <td data-label="@t('more_expensive_products')">
                        <span class="label @if($competitor->difference['higher']['value'] > 0) increase
                                           @elseif($competitor->difference['higher']['value'] == 0) neutral
                                           @else decrease @endif">
                            {{ $competitor->difference['higher']['value'] }}
                        </span>
                        </td>
                        <td data-label="@t('cheaper_products')">
                        <span class="label @if($competitor->difference['cheaper']['value'] > 0) increase
                                           @elseif($competitor->difference['cheaper']['value'] == 0) neutral
                                           @else decrease @endif">
                            {{ $competitor->difference['cheaper']['value'] }}
                        </span>
                        </td>
                        <td data-label="@t('equal_products')">
                        <span class="label @if($competitor->difference['equal']['value'] > 0) increase
                                           @elseif($competitor->difference['equal']['value'] == 0) neutral
                                           @else decrease @endif">
                            {{ $competitor->difference['equal']['value'] }}
                        </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{--  PRICE DIFFERENCE CHART  --}}

    <div id="priceDifference" class="toggle-div" style="display:none;">
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <ul class="nav nav-tabs trendingDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle categoryText border_bottom_add_radius" data-toggle="dropdown"
                           href="#">
                            @t('categories') <span class="caret"></span></a>
                        <ul class="dropdown-menu chartToggle">
                            @foreach ($categoriesPriceDifference as $category)
                                <li><a href="#category{{$category->id}}"
                                       data-categoryId={{$category->id}}>{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

            </div>

            <div class="col-sm-3 col-xs-6">
                <ul class="nav nav-tabs trendingDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle competitorText increaseMenuText border_bottom_add_radius"
                           data-toggle="dropdown"
                           href="#">
                            @t('stores') <span class="caret"></span></a>
                        <ul class="dropdown-menu competitorToggle">
                            <li><a href="#competitor0"
                                   data-competitor=0>@t('all')</a></li>
                            @foreach ($competitorsPriceDifference as $competitor)
                                <li><a href="#competitor{{$competitor->id}}"
                                       data-competitor={{$competitor->id}}>{{$competitor->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

            </div>

            <div class="col-sm-3 col-xs-6 inline export" style="display: none">
                <button id="export-chart-data-price-difference"
                        style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"
                        class="btn btn-info">
                    @t('csv_export')
                </button>
            </div>

            <div class="col-sm-3 col-xs-6 inline export" style="display: none">
                <button id="export-chart-data-price-difference-in-pdf"
                        style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"

                        class="btn btn-info">
                    @t('pdf_export')
                </button>
            </div>
        </div>
        <div style="width: 100%; overflow: auto">
            <div class="chart-container chartWrapper">
                <canvas id="bubble-chart"></canvas>
                <div class="emptyHeader font-weight-bold text-secondary">@t('Please make a selection first')</div>
            </div>
        </div>
    </div style>

    {{--  CATEGORY PERCENTAGE DIFFERENCE CHART  --}}

    <div id="category-percentage-difference" class="toggle-div" style="display: none">
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <button id="export-chart-data"
                        style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"
                        class="btn btn-info">
                    @t('csv_export')
                </button>
            </div>
            <div class="col-sm-3 col-xs-6">
                <button id="export-chart-data-in-pdf"
                        style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"

                        class="btn btn-info">
                    @t('pdf_export')
                </button>
            </div>
        </div>
        <input type="hidden" id="dataset" value="{{ $dataSet }}">
        <div style="width: 100%; overflow: auto">
            <div style="width: 900px; margin: 0 auto">
                <div id="ulList" class="d3chart"></div>
                <div id="chart" class="chart"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function view(param) {
            if (param === 1) {
                $('#show-bubble-chart').show();
                $('#bubble-button').hide();

                $('#show-d3-chart').hide();
                $('#show-table').hide();
                $('#d3-button').show();
                $('#table-button').show();
            } else if (param === 2) {
                $('#show-d3-chart').show();
                $('#d3-button').hide();

                $('#show-bubble-chart').hide();
                $('#show-table').hide();
                $('#bubble-button').show();
                $('#table-button').show();

            } else {
                $('#show-table').show();
                $('#table-button').hide();

                $('#show-bubble-chart').hide();
                $('#show-d3-chart').hide();
                $('#bubble-button').show();
                $('#d3-button').show();

            }
        }

        UiTables.init({
            pageLength: 50,
            drawCallback: function () {
                $('.pagination li:not(.disabled)', this.api().table().container())
                    .on('click', function () {
                        $('.table .text-center').removeClass('text-center');
                        columns = $('.table tr').length;
                        rows = $('.table th').length;
                        shapeTable(rows, columns);
                    });
            }
        });
    </script>

    @include('statistics.partials.competitors-partials-script')

    <script>
        $('#export-chart-data').on('click', function () {
            window.location.href = '{{ route('statistics.category.percentage.difference.in.csv') }}';
        })

        $('#export-chart-data-in-pdf').on('click', function () {
            window.location.href = '{{ route('statistics.category.percentage.difference.in.pdf') }}';
        });
    </script>
    <script>
        $(".toggle-button").on("click", function () {
            let divID = $(this).data("div");
            $(".toggle-div").css("display", "none");

            $(".toggle-button").css("display", "inline-block");
            if ($(window).width() < 767) {
                $(".toggle-button.show-for-desktop").css("display", "none");
            } else {
                $(".toggle-button.show-for-mobile").css("display", "none");
            }
            $(this).css("display", "none");
            $("#" + divID).css("display", "block");
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.8/d3.min.js"></script>
    <script src="{{ asset('js/custom/d3-chart-for-category-percentage-difference.js') }}"></script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
