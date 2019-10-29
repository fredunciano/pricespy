@extends('layouts.app')
@section('styles')
    <style>
        .text-center {
            text-align: center !important;
        }

        /*.table {*/
        /*min-height: 200px;*/
        /*}*/

        .raw-text {
            color: #ffffff;
            font-weight: bolder;
        }

        .widget-text strong span {
            font-weight: bolder;
            font-size: 40px;
        }

        .trending_body {
            min-height: 360px;
        }

        .filter-block {
            display: none;
        }

        .hide-for-mobile, #competitors-legend {
            display: block;
        }

        .row {
            margin-bottom: 20px;
        }

        @media screen and (max-width: 767px) {
            .hide-for-mobile, #competitors-legend {
                display: none;
            }

            .filter-block {
                display: block;
            }
        }
    </style>
@stop
@section('page-head')
    <div class="row page-head">
        <div class="col-md-12">
            <div class="col-md-6 col-xs-6">
                <h1 class="page-head-title" style="padding-left: 0">
                    {{--<b style="padding-right:10px">@t('welcome')</b> {{ auth()->user()->name }}--}}
                    Dashboard
                </h1>
            </div>

            <div class="col-md-6 col-xs-6" style="padding-right: 0">
                <div class="pull-right top-button-area">
                    <a href="{{ route('products.create') }}">
                        <div class="col-md-12 col-xs-12 orange top-button" style="padding: 0 10px 0 10px">
                            <div class="col-xs-1 widget-icon-small" style="padding-left:0; padding-right:5px">
                                <i class="fa fa-plus-circle text-light-op top-button-icon"></i>
                            </div>
                            <div class="col-xs-11 pull-right" style="padding-left:0; padding-right:0">
                                <h4 class="widget-text text-right top-button-text">
                                    @t('add_product_button')
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('competitors.requests.create') }}">
                        <div class="col-md-12 col-xs-12 green top-button" style="padding: 0 10px 0 10px">
                            <div class="col-xs-1 widget-icon-small" style="padding-left:0; padding-right:5px">
                                <i class="fa fa-plus-circle text-light-op top-button-icon"></i>
                            </div>
                            <div class="col-xs-11 pull-right" style="padding-left:0; padding-right:0">
                                <h4 class="widget-text text-right top-button-text">
                                    @t('add_competitor_button')
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
    {{--TOP STAT DATA--}}
    <div class="row top-stat-data">
        <!-- Simple Stats Widgets -->
        <div class="col-sm-6 col-lg-3 col-xs-6 xs-no-padding-right">
            <a class="widget background-orange">
                <div class="widget-content widget-content-mini clearfix">
                    <div class="widget-icon ">
                        <i class="custom-icon-boxes text-light-op" style="margin-top: 10px"></i>
                    </div>
                    <h2 class="widget-heading widget-text">
                        <strong><span data-toggle="counter" data-to="{{ $topStats['totalProducts'] }}"></span></strong>
                    </h2>
                    <span class="raw-text">@t('number_of_products')</span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 col-xs-6 xs-no-padding-left">
            <a class="widget background-blue">
                <div class="widget-content widget-content-mini clearfix">
                    <div class="widget-icon">
                        <i class="custom-icon-fire text-light-op" style="margin-top: 10px"></i>
                    </div>
                    <h2 class="widget-heading widget-text">
                        <strong>
                            <span data-toggle="counter" data-to="{{ $topStats['totalLastDayPriceChanges'] }}"></span>
                        </strong>
                    </h2>
                    <span class="raw-text">
                        @php
                            $words = t('number_of_price_changes_in_last_24h');
                            if(auth()->user()->locale == 'en'){
                                echo putBrTag($words, 4);
                            } else {
                                echo putBrTag($words, 3);
                            }
                        @endphp
                    </span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 col-xs-6 xs-no-padding-right">
            <a class="widget background-lightblue">
                <div class="widget-content widget-content-mini clearfix">
                    <div class="widget-icon">
                        <i class="custom-icon-globe text-light-op" style="margin-top: 10px"></i>
                    </div>
                    <h2 class="widget-heading widget-text">
                        <strong>
                            <span data-toggle="counter" data-to="{{ $topStats['totalConnectedCompetitors'] }}"></span>
                        </strong>
                    </h2>
                    <span class="raw-text">@t('number_of_connected_competitors')</span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 col-xs-6 xs-no-padding-left">
            <a class="widget background-green">
                <div class="widget-content widget-content-mini clearfix">
                    <div class="widget-icon">
                        <i class="custom-icon-thumbs-up text-light-op" style="margin-top: 10px"></i>
                    </div>
                    <h2 class="widget-heading widget-text">
                        <strong><span data-toggle="counter"
                                      data-to="{{ $topStats['totalCheaperProduct'] }}"> €</span></strong>
                    </h2>
                    <span class="raw-text">@t('number_of_cheaper_products')</span>
                </div>
            </a>
        </div>
        <!-- END Simple Stats Widgets -->
    </div>

    {{--LINE CHART AREA--}}
    <div class="row">
        <div class="title-only-for-mobile" id="category-graph-title">
            <h3>@t('Category Average Price Graph') <a class="pull-right"><i id="category-graph-icon"
                                                                            class="fa fa-angle-right fa-2x"></i></a>
            </h3>
        </div>
        <div class="col-lg-12 hide-div-only-for-mobile" id="category-graph-content">
            <div class="widget">
                <div class="row d-flex-reverse">
                    <div class="col-sm-4 col-xs-12 pull-right">
                        <div class="widget-content">
                            <h4 class="text-uppercase widget-title" style="color: #fff; margin-bottom: 20px">
                                <b>@t('Category Average Price Graph')</b>
                                {{--@t('Filter')--}}
                            </h4>
                            <div class="row mb20">
                                <div class="col-xs-12">
                                    <div class="form-control no-padding filter-block row"
                                         style="padding-left: 5px!important;">
                                        <div class="col-xs-10" style="padding-left: 1px; height: 63px">
                                            <div class=" col-xs-5 no-padding">
                                                <div class="label pink" id="line-chart-time-period"></div>
                                            </div>
                                            <div class="col-xs-7 no-padding">
                                                <div class="label purple" id="line-chart-category-name"></div>
                                            </div>
                                            <div class=" col-xs-6 no-padding">
                                                <div class="label orange" id="line-chart-competitor-name"></div>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 no-padding" style="height: 63px;">
                                            <a href="#" data-toggle="modal" data-target="#filter-modal"
                                               class="pull-right" style="height: 100%">
                                                <i class="fa fa-filter"
                                                   style="background: #09b9b2; color: #fff; padding: 9px 13px; font-size: 45px"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="hide-for-mobile col-xl-6 col-md-12 col-xs-12">
                                    <label class="control-label">@t('Showing Results From')</label>
                                    <select id="line-chart-select" class="form-control line-filter-select ">
                                        <option value="" selected disabled>@t('select')</option>
                                        <option value="last_7_days" selected>@t('last_week')</option>
                                        <option value="last_30_days">@t('last_month')</option>
                                        <option value="last_12_month">@t('last_year')</option>
                                    </select>
                                    <br>
                                </div>
                                <div class="hide-for-mobile col-xl-6 col-md-12 col-xs-12">
                                    <label class="control-label">@t('category')</label>
                                    <select id="line-category-select" class="form-control line-filter-select ">
                                        {{--<option value="">@t('all')</option>--}}
                                        @foreach ($categories as $index => $category)
                                            <option value="{{ $category->id }}"
                                                    @if($index=0) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                                <div class="hide-for-mobile col-xl-6 col-md-12 col-xs-12">
                                    <label class="control-label">@t('competitor')</label>
                                    <select id="line-competitor-select"
                                            class="form-control line-filter-select ">
                                        <option value="">@t('all')</option>
                                        @foreach ($competitors as $competitor)
                                            <option value="{{ $competitor->id }}">{{ $competitor->name }}</option>
                                        @endforeach
                                    </select>
                                    @php $allComps = collect($competitors)->pluck('name')->all(); @endphp
                                    <input type="hidden" id="all-comps" value="{{ json_encode($allComps) }}">
                                </div>
                                <div class="hide-for-mobile col-xl-6 col-md-12 col-xs-12">
                                    <label for="">&nbsp;</label>
                                    <button id="reset-line-filter" class="btn btn-green form-control">@t('reset')
                                    </button>
                                </div>

                                <div class="col-xs-12 col-lg-6">
                                    <label for="">&nbsp;</label>
                                    <button id="export-data" style="background: #373d58; color: #ccc"
                                            class="btn btn-info form-control">
                                        @t('export_to_csv')
                                    </button>
                                </div>
                                <div class="col-xs-12 col-lg-6">
                                    <label for="">&nbsp;</label>
                                    <button id="export-data-in-pdf" style="background: #373d58; color: #ccc"
                                            class="btn btn-info form-control">
                                        @t('export_to_pdf')
                                    </button>
                                </div>

                                {{--<div class="col-xs-12">--}}
                                {{--<label id="legend-title" style="margin-top: 10px; display: none">--}}
                                {{--@t('legend')--}}
                                {{--</label>--}}
                                {{--</div>--}}

                                <div id="competitors-legend">

                                </div>

                                {{----}}
                                {{--<div class="col-md-6">--}}
                                {{--<div class="line-chart-legend legend-color-2"></div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                {{--<div class="line-chart-legend legend-color-3"></div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                {{--<div class="line-chart-legend legend-color-4"></div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <div class="widget-content border-bottom themed-background-muted line-chart">
                            <div id="lineChartLoader" style="display: none">
                                @include('partials.loader')
                            </div>
                            {{--<div style="text-align: center; font-family: 'Bookman Old Style'; font-size: 20px; position: absolute; top: 50%; right: 35%; color: #595b61">--}}
                            {{--@t("filter_message")--}}
                            {{--</div>--}}
                            <div class="chartWrapper">
                                <canvas id="line-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--PIE CHART AND PRICE STATS--}}
    <div class="row d-lg-flex">
        <div class="title-only-for-mobile" id="pie-chart-title">
            <h3 class="text-orange">@t('market_distribution') <a class="pull-right"><i
                            class="fa fa-angle-right fa-2x" id="pie-chart-icon"></i></a></h3>
        </div>
        <div id="pie-chart-content" class="col-lg-6 col-sm-12 hide-div-only-for-mobile">
            <div class="widget">
                <div class="widget-content doughnout-chart">
                    <div class="row mb20">
                        <div class="col-lg-5 col-md-5 col-sm-12" style="padding-right: 0">
                            <h4 class="m-dis-title">
                                <b class="text-orange text-uppercase widget-title">@t('market_distribution')</b>

                                <div>
                                    <button id="export-pie-chart-data"
                                            class="market-distribution-button btn btn-info form-control">
                                        @t('csv_export')
                                    </button>

                                    <button id="export-pie-chart-data-in-pdf"
                                            class="market-distribution-button btn btn-info form-control">
                                        @t('pdf_export')
                                    </button>
                                </div>

                            </h4>


                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-12">

                            <div class="form-control no-padding filter-block row"
                                 style="padding-left: 5px!important;">
                                <div class="col-xs-10" style="padding-left: 1px; height: 33px">
                                    <div class="col-xs-6 no-padding">
                                        <span class="label purple" id="pie-chart-category-name"></span>
                                    </div>
                                    <div class=" col-xs-6 no-padding">
                                        <span class="label orange" id="pie-chart-competitor-name"></span>
                                    </div>
                                </div>

                                <div class="col-xs-2 no-padding" style="height: 33px;">
                                    <a href="#" data-toggle="modal" data-target="#pie-filter-modal"
                                       class="pull-right" style="height: 100%">
                                        <i class="fa fa-filter"
                                           style="background: #09b9b2; color: #fff; padding: 5px 10px; font-size: 23px"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="col-xs-6 hide-for-mobile">
                                <label class="control-label">@t('category')</label>
                                <select id="category-select" class="form-control filter-select ">
                                    @php $currentCategory = $_GET['category'] ?? null; @endphp
                                    <option value="">@t('all')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if ($category->id == $currentCategory) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-6 hide-for-mobile">
                                <label class="control-label">@t('competitor')</label>
                                <select id="competitor-select" class="form-control filter-select ">
                                    @php $currentCompetitor = $_GET['competitor'] ?? null; @endphp
                                    <option value="">@t('all')</option>
                                    @foreach ($competitors as $competitor)
                                        <option value="{{ $competitor->id }}"
                                                @if ($competitor->id == $currentCompetitor) selected @endif>{{ $competitor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div id="pie-chart-legends">

                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                            <div id="dLoader" style="display: none">
                                @include('partials.loader')
                            </div>
                            <div style="padding-top: 10px; padding-right: 10px;display: flex;justify-content: center">
                                <div id="myChartNoDataArea"
                                     style="text-align: center; font-family: 'Roboto'; font-size: 20px; position: absolute; top: 40%; right: 20%; color: #595b61; display: none">
                                    @t("no_data_available")
                                </div>
                                <canvas id="myChart" style="margin: 0 auto" height="220"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>

            {{--<div class="widget">--}}
            {{--<div class="row">--}}
            {{--<div class="col-sm-12">--}}
            {{--<!-- Project Widget -->--}}
            {{--<div class="widget scrollbar scrollbar-sm">--}}
            {{--<div class="widget-content border-bottom">--}}
            {{--<span class="pull-right text-muted">4 New</span>--}}
            {{--Recent Notifications--}}
            {{--</div>--}}
            {{--@foreach ([--}}
            {{--'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dignissim diam quis enim lobortis scelerisque fermentum. Ultrices neque ornare aenean euismod elementum nisi. Lacus luctus accumsan tortor posuere ac. Suspendisse sed nisi lacus sed viverra tellus in hac. Sagittis vitae et leo duis ut diam quam nulla. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend. Sit amet purus gravida quis blandit turpis cursus in hac. At quis risus sed vulputate odio ut enim blandit. Bibendum est ultricies integer quis auctor elit sed vulputate mi. Massa massa ultricies mi quis hendrerit. Lectus arcu bibendum at varius vel. Urna nec tincidunt praesent semper feugiat nibh. Cum sociis natoque penatibus et magnis',--}}
            {{--'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dignissim diam quis enim lobortis scelerisque fermentum. Ultrices neque ornare aenean euismod elementum nisi. Lacus luctus accumsan tortor posuere ac. Suspendisse sed nisi lacus sed viverra tellus in hac. Sagittis vitae et leo duis ut diam quam nulla. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend. Sit amet purus gravida quis blandit turpis cursus in hac. At quis risus sed vulputate odio ut enim blandit. Bibendum est ultricies integer quis auctor elit sed vulputate mi. Massa massa ultricies mi quis hendrerit. Lectus arcu bibendum at varius vel. Urna nec tincidunt praesent semper feugiat nibh. Cum sociis natoque penatibus et magnis',--}}
            {{--'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dignissim diam quis enim lobortis scelerisque fermentum. Ultrices neque ornare aenean euismod elementum nisi. Lacus luctus accumsan tortor posuere ac. Suspendisse sed nisi lacus sed viverra tellus in hac. Sagittis vitae et leo duis ut diam quam nulla. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend. Sit amet purus gravida quis blandit turpis cursus in hac. At quis risus sed vulputate odio ut enim blandit. Bibendum est ultricies integer quis auctor elit sed vulputate mi. Massa massa ultricies mi quis hendrerit. Lectus arcu bibendum at varius vel. Urna nec tincidunt praesent semper feugiat nibh. Cum sociis natoque penatibus et magnis',--}}
            {{--] as $notification)--}}
            {{--<a href="javascript:void(0)"--}}
            {{--class="widget-content clearfix @if ($loop->index % 2) notification-even @else notification-odd @endif">--}}
            {{--<img src="img/placeholders/avatars/avatar6.jpg" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar pull-left">--}}
            {{--<h4 class="widget-heading text-muted mb10"><b>System</b></h4>--}}
            {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor--}}
            {{--incididunt ut--}}
            {{--labore et dolore magna aliqua. Dignissim diam quis enim lobortis scelerisque--}}
            {{--fermentum.--}}
            {{--Ultrices neque ornare aenean euismod elementum nisi. Lacus luctus accumsan--}}
            {{--tortor posuere--}}
            {{--ac. Suspendisse sed nisi lacus sed viverra tellus in hac. Sagittis vitae et leo--}}
            {{--duis ut diam--}}
            {{--quam nulla. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque--}}
            {{--eleifend.--}}
            {{--Sit amet purus gravida quis blandit turpis cursus in hac. At quis risus sed--}}
            {{--vulputate odio--}}
            {{--ut enim blandit. Bibendum est ultricies integer quis auctor elit sed vulputate--}}
            {{--mi. Massa--}}
            {{--massa ultricies mi quis hendrerit. Lectus arcu bibendum at varius vel. Urna nec--}}
            {{--tincidunt--}}
            {{--praesent semper feugiat nibh. Cum sociis natoque penatibus et magnis.</p>--}}
            {{--<div class="progress progress-striped progress-mini active">--}}
            {{----}}{{----}}{{--<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%"></div>--}}{{----}}{{----}}
            {{--</div>--}}
            {{--</a>--}}
            {{--@endforeach--}}
            {{--</div>--}}
            {{--<!-- END Project Widget -->--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="widget">--}}
            {{--<div class="col-sm-12">--}}
            {{--<!-- Statistics Widget -->--}}
            {{--<div class="widget" style="margin-bottom: 0">--}}
            {{--<div class="widget-content themed-background-muted no-padding">--}}
            {{--<div class="row">--}}
            {{--<div class="col-lg-6" style="padding-top: 20px;">--}}
            {{--<div class="mb20">--}}
            {{--<img src="{{ auth()->user()->getAvatar() }}" alt="avatar"--}}
            {{--class="img-circle img-dashboard-small">--}}
            {{--<i class="img-circle img-thumbnail img-dashboard fa fa-user fa-4x"></i>--}}
            {{--<h3 class="widget-heading text-dark text-uppercase" style="display:inline;">--}}
            {{--<span><b>@t('my')</b> Account</span>--}}
            {{--</h3>--}}

            {{--<b class="premium-background ml15 pull-right text-uppercase"--}}
            {{--style="color: #303852; font-weight: bolder">--}}
            {{--Premium <i class="fa fa-diamond" style="font-size: 20px"></i>--}}
            {{--</b>--}}
            {{--</div>--}}
            {{--<h4 class="widget-heading">@t('profile')</h4>--}}
            {{--<div class="mb20" style="padding-top: 10px">--}}
            {{--<p style="margin-bottom: 10px; color: #66788e; font-size: 24px">{{ auth()->user()->name }}</p>--}}
            {{--<p style="margin-bottom: 10px; color: #66788e">{{ auth()->user()->email }}</p>--}}
            {{--<p style="margin-bottom: 10px; color: #66788e">{{ auth()->user()->company }}</p>--}}
            {{--</div>--}}
            {{--<div class="row mb5">--}}
            {{--<div class="col-xs-12">--}}
            {{--<span class="pull-left">@t('sites_evaluated')</span>--}}
            {{--<span class="pull-right">1000 @tl('of') 10000</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row mb5">--}}
            {{--<div class="col-xs-12">--}}
            {{--<div class="progressbar green">--}}
            {{--<span style="width: 10%"></span>--}}
            {{--</div>--}}
            {{--<br>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row mb5">--}}
            {{--<div class="col-xs-12">--}}
            {{--<span class="pull-left">@t('competitors')</span>--}}
            {{--<span class="pull-right">75 @tl('of') 100</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row mb5">--}}
            {{--<div class="col-xs-12">--}}
            {{--<div class="progressbar orange">--}}
            {{--<span style="width: 75%"></span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-lg-6 no-padding" style="background: #363e5a">--}}
            {{--<div class="widget-icons-wrapper" style="background: #363e5a">--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('products.my') }}">--}}
            {{--<i class="custom-icon-cart"> </i><br/>@t('my_shop')--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="widget-icons-wrapper" style="background: #343a56">--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('products.comparison.index') }}">--}}
            {{--<i class="custom-icon-search"> </i><br/>@t('comparison')--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="widget-icons-wrapper" style="background: #343a56">--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('home') }}">--}}
            {{--<i class="custom-icon-mail"> </i><br/>@t('pay_invoice')--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="widget-icons-wrapper" style="background: #363e5a">--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('competitors.index') }}">--}}
            {{--<i class="custom-icon-users"> </i><br/>@t('competitors')--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="widget-content text-center" style="display:flex; flex-wrap: wrap; align-items: center; justify-content: center">--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('products.my') }}"><i--}}
            {{--class="fa fa-5x fa-shopping-cart"> </i> <br/> @t('my_shop')</a>--}}
            {{--</div>--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('products.comparison.index') }}"><i--}}
            {{--class="fa fa-search fa-5x"> </i> <br/> @t('comparison')</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="widget-content text-center"--}}
            {{--style="display:flex; flex-wrap: wrap; align-items: center; justify-content: center">--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('home') }}"><i--}}
            {{--class="fa fa-5x fa-credit-card"> </i> <br/>--}}
            {{--@t('pay_invoice')</a>--}}
            {{--</div>--}}
            {{--<div style="flex-grow:100;">--}}
            {{--<a class="mask-link" href="{{ route('competitors.index') }}"><i--}}
            {{--class="fa fa-5x fa-users"> </i> <br/> @t('competitors')</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--</div>--}}


        </div>

        <div class="title-only-for-mobile" id="own-price-title">
            <h3 class="text-green">@t('own')<b> @t('best_prices')</b> <a class="pull-right"><i
                            class="fa fa-angle-right fa-2x" id="own-price-icon"></i></a></h3>
        </div>
        <div id="own-price-content" class="col-lg-3 col-sm-12 hide-div-only-for-mobile">
            <div class="widget small-block" style="line-height:18px">
                <div class="widget-content mx5 dashboard-stat-height">
                    <h4 class="text-green text-uppercase widget-title">
                        <b>@t('own')</b>@t('best_prices')
                    </h4>
                    @foreach ($topData['own'] as $product)
                        <div class="row mb20">
                            <div class="col-xs-8" style="padding-right: 0">
                                {{ $loop->index + 1 }}.
                                <a class="danger mask-link" href="{{ route('products.show', $product->id) }}">
                                    @if (strlen($product->name) > 25)
                                        <span title="{{ $product->name }}">{{ substr($product->name, 0, 24) }}...</span>
                                    @else
                                        {{ $product->name }}
                                    @endif
                                </a>
                            </div>
                            <div class="col-xs-4 no-padding text-right">
                                <b style="padding-right: 5px">{{ showVisualDifference($product->difference, true) }}</b>
                            </div>
                        </div>
                    @endforeach
                    @if (!count($topData['own']))
                        <div class="text-center" style="margin-top:90px;">
                            <i>@t('no_statistics')</i>
                        </div>
                    @endif
                    <div class="row widget-bottom-block">
                        <div class="col-xs-12">
                            <a href="{{ route('statistics.own.best.prices') }}"
                               class="btn btn-green"><b>@t('show_more')</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="title-only-for-mobile" id="comp-price-title">
            <h3 class="text-orange">@t('competitors')<b> @t('best_prices')</b> <a class="pull-right"><i
                            class="fa fa-angle-right fa-2x" id="comp-price-icon"></i></a></h3>
        </div>
        <div id="comp-price-content" class="col-lg-3 col-sm-12 hide-div-only-for-mobile">
            <div class="widget small-block" style="line-height:18px">
                <div class="widget-content mx5 dashboard-stat-height">
                    <h4 class="text-orange text-uppercase widget-title">
                        <b>@t('competitors')</b>@t('best_prices')
                    </h4>
                    @foreach ($topData['competitors'] as $product)
                        <div class="row mb20">
                            <div class="col-xs-8" style="padding-right: 0">
                                {{ $loop->index + 1 }}.
                                <a class="danger mask-link" href="{{ route('products.show', $product->id) }}">
                                    @if (strlen($product->name) > 25)
                                        <span title="{{ $product->name }}">{{ substr($product->name, 0, 23) }}...</span>
                                    @else
                                        {{ $product->name }}
                                    @endif
                                </a>
                            </div>
                            <div class="col-xs-4 no-padding text-right">
                                <b style="padding-right: 5px">{{ showVisualDifference($product->difference, true) }}</b>
                            </div>
                        </div>
                    @endforeach
                    @if (!count($topData['competitors']))
                        <div class="text-center" style="margin-top:90px;">
                            <i>@t('no_statistics')</i>
                        </div>
                    @endif
                    <div class="row widget-bottom-block">
                        <div class="col-xs-12">
                            <a href="{{ route('statistics.competitors.best.prices') }}"
                               class="btn btn-orange"><b>@t('show_more')</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--PRICE CHANGES--}}
    <div class="row">
        <div class="statistics">
            <div class="title-only-for-mobile" id="price-change-title">
                <h3 class="text-green"><b> @t('price_changes')</b> <a class="pull-right"><i
                                class="fa fa-angle-right fa-2x" id="price-change-icon"></i></a></h3>
            </div>
            <div id="price-change-content" class="col-sm-12 hide-div-only-for-mobile">
                <!-- Statistics Widget -->
                <div class="widget ">
                    <h4 class="text-lightblue text-uppercase mb20" style="padding: 15px 0 0 30px">
                        <b class="mr5">@t('price_changes')</b>
                    </h4>


                    <div style="padding: 15px 15px;">

                        <div class="col-md-6">
                            <div id='toggle-button' style="display: none; padding-left: 15px;">
                                <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass"
                                                                                                    class="fa fa-th-large"></i>
                                    Toggle
                                    View
                                </button>
                            </div>
                            <div class="widget-dropdown-with-text">
                                <ul class="nav nav-tabs trendingDropdown" style="display: inline-block">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle increaseMenuText border_bottom_add_radius"
                                           data-toggle="dropdown"
                                           href="#">
                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu increaseMenu">
                                            <li><a href="#dayInc" id="dayDataInc" data-toggle="tab">@t('day')</a></li>
                                            <li><a href="#weekInc" id="weekDataInc"
                                                   data-toggle="tab">@t('this_week')</a></li>
                                            <li><a href="#monthInc" id="monthDataInc"
                                                   data-toggle="tab">@t('this_month')</a></li>
                                        </ul>
                                    </li>
                                </ul>

                                <div class="price-change-stat-count">
                                    @t('No. of Competitor Products which Increased in Price'): <span
                                            class="label increase" id="countTrends"></span>
                                </div>
                            </div>

                            <!-- Tab panes -->
                            <div class="tab-content trending_body">
                                <div id="dayInc" class="tab-pane active"><br>
                                    <span class="label increase" id="dayIncreaseCount" style="display: none"></span>

                                    <div class="table-responsive">
                                        <table class="table table-custom table-vcenter datatable" id="tableDayIncrease">
                                            <thead>
                                            <tr>
                                                <th class="{{ hc(0) }}">
                                                    @tbl('product_name')
                                                </th>
                                                <th class="text-center {{ hc(1) }}">
                                                    @tbl('competitor')
                                                </th>
                                                <th class="text-center {{ hc(2) }}">
                                                    @tbl('percentage')
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                                <div id="weekInc" class="tab-pane fade"><br>
                                    <span class="label increase" id="weekIncreaseCount" style="display: none"></span>
                                    <div class="table-responsive">
                                        <table class="table table-custom table-vcenter table" id="tableWeekIncrease">
                                            <thead>
                                            <tr>
                                                <th class="{{ hc(0) }}">
                                                    @tbl('product_name')
                                                </th>
                                                <th class="text-center {{ hc(1) }}">
                                                    @tbl('competitor')
                                                </th>
                                                <th class="text-center {{ hc(2) }}">
                                                    @tbl('percentage')
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                </div>
                                <div id="monthInc" class="tab-pane fade"><br>
                                    {{--<p>@t('No. of Competitor Products which Increased in Price') : <span--}}
                                    {{--class="label increase" id="monthIncreaseCount"></span></p>--}}
                                    <span class="label increase" id="monthIncreaseCount" style="display: none"></span>
                                    <div class="table-responsive">
                                        <table class="table table-custom table-vcenter table" id="tableMonthIncrease">
                                            <thead>
                                            <tr>
                                                <th class="{{ hc(0) }}">
                                                    @tbl('product_name')
                                                </th>
                                                <th class="header_align {{ hc(1) }}">
                                                    @tbl('competitor')
                                                </th>
                                                <th class="text-center {{ hc(2) }}">
                                                    @tbl('percentage')
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                </div>
                            </div>

                            <a style="margin-top: 20px" href="{{route('statistics.trending.data.priceChange')}}"
                               id="showMore" type="button"
                               class="btn btn-lightblue">@t('show_more')</a>
                        </div>

                        <div class="col-md-6">
                            <div class="widget-dropdown-with-text">
                                <ul class="nav nav-tabs trendingDropdown" style="display: inline-block">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle decreaseMenuText border_bottom_add_radius"
                                           data-toggle="dropdown" href="#">
                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu decreaseMenu">
                                            <li><a class="nav-link " id="dayDataDec" data-toggle="tab"
                                                   href="#day">@t('day')</a>
                                            </li>
                                            <li><a class="nav-link " id="weekDataDec" data-toggle="tab" href="#week">@t('this_week')</a>
                                            </li>
                                            <li><a class="nav-link " id="monthDataDec" data-toggle="tab" href="#month">@t('this_month')</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <div class="price-change-stat-count">
                                    @t('No. of Competitor Products which Decreased in Price'): <span
                                            class="label decrease" id="countTrendsDec"></span>
                                </div>
                            </div>

                            <!-- Tab panes -->
                            <div class="tab-content trending_body">
                                <div id="day" class="tab-pane active"><br>
                                    <span class="label decrease" id="dayDecreaseCount" style="display: none"></span>
                                    <div class="table-responsive">
                                        <table class="table table-custom table-vcenter" id="tableDayDecrease">
                                            <thead>
                                            <tr>
                                                <th class="{{ hc(0) }}">
                                                    @tbl('product_name')
                                                </th>
                                                <th class="text-center {{ hc(1) }}">
                                                    @tbl('competitor')
                                                </th>
                                                <th class="text-center {{ hc(2) }}">
                                                    @tbl('percentage')
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>

                                </div>
                                <div id="week" class="tab-pane fade"><br>
                                    <span class="label decrease" id="weekDecreaseCount" style="display: none"></span>
                                    <div class="table-responsive">
                                        <table class="table table-custom table-vcenter" id="tableWeekDecrease">
                                            <thead>
                                            <tr>
                                                <th class="{{ hc(0) }} ">
                                                    @tbl('product_name')
                                                </th>
                                                <th class="text-center {{ hc(1) }} ">
                                                    @tbl('competitor')
                                                </th>
                                                <th class="text-center {{ hc(2) }}">
                                                    @tbl('percentage')
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                </div>
                                <div id="month" class="tab-pane fade"><br>
                                    <span class="label decrease" id="monthDecreaseCount" style="display: none"></span>
                                    <div class="table-responsive">
                                        <table class="table table-custom table-vcenter" id="tablemonthDecrease">
                                            <thead>
                                            <tr>
                                                <th class="{{ hc(0) }}">
                                                    @tbl('product_name')
                                                </th>
                                                <th class="text-center {{ hc(1) }}">
                                                    @tbl('competitor')
                                                </th>
                                                <th class="text-center {{ hc(2) }}">
                                                    @tbl('percentage')
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END Statistics Widget -->

                </div>
            </div>
        </div>
    </div>

    <!-- Third Row -->
    <input id="chart-data" type="hidden" value="{{ $chartData }}">
    <input id="line-chart-data" type="hidden" value="{{ $lineChartData }}">
    {{--<input id="line-chart-data" type="hidden">--}}
@stop
@section('scripts')
    <div id="filter-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        @if(auth()->user()->locale == 'en')
                            FILTER OPTION
                        @else
                            FILTEROPTIONEN
                        @endif
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row mb20">
                        <div class="col-xs-12">
                            <label class="control-label">@t('Showing Results From')</label>
                            <select id="line-chart-select" class="form-control line-filter-select ">
                                <option value="" selected disabled>@t('select')</option>
                                <option value="last_7_days" selected>@t('last_week')</option>
                                <option value="last_30_days">@t('last_month')</option>
                                <option value="last_12_month">@t('last_year')</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label">@t('category')</label>
                            <select id="line-category-select" class="form-control line-filter-select ">
                                {{--<option value="">@t('all')</option>--}}
                                @foreach ($categories as $index => $category)
                                    <option value="{{ $category->id }}"
                                            @if($index=0) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <br>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label">@t('competitor')</label>
                            <select id="line-competitor-select"
                                    class="form-control line-filter-select ">
                                <option value="">@t('all') @t('stores')</option>
                                @foreach ($competitors as $competitor)
                                    <option value="{{ $competitor->id }}">{{ $competitor->name }}</option>
                                @endforeach
                            </select>
                            @php $allComps = collect($competitors)->pluck('name')->all(); @endphp
                            <input type="hidden" id="all-comps" value="{{ json_encode($allComps) }}">
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12">
                            <label for="">&nbsp;</label>
                            <button id="reset-line-filter" class="btn btn-green form-control">@t('reset')
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-center">
                    <hr class="hr-color">
                    <button type="button" id="save-filter" class="btn btn-success-custom"
                            style="display: inline-block; min-height: 40px">
                        @if(auth()->user()->locale == 'en')
                            APPLY
                        @else
                            ANWENDEN
                        @endif
                    </button>
                </div>
            </div>

        </div>
    </div>


    <div id="pie-filter-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        @if(auth()->user()->locale == 'en')
                            FILTER OPTION
                        @else
                            FILTEROPTIONEN
                        @endif
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row mb20">
                        <div class="col-xs-12">
                            <label class="control-label">@t('category')</label>
                            <select id="category-select" class="form-control filter-select ">
                                @php $currentCategory = $_GET['category'] ?? null; @endphp
                                <option value="">@t('all') @t('categories')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                            @if ($category->id == $currentCategory) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label">@t('competitor')</label>
                            <select id="competitor-select" class="form-control filter-select ">
                                @php $currentCompetitor = $_GET['competitor'] ?? null; @endphp
                                <option value="">@t('all') @t('stores')</option>
                                @foreach ($competitors as $competitor)
                                    <option value="{{ $competitor->id }}"
                                            @if ($competitor->id == $currentCompetitor) selected @endif>{{ $competitor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-center">
                    <hr class="hr-color">
                    <button type="button" id="save-filter-for-pie" class="btn btn-success-custom"
                            style="display: inline-block; min-height: 40px">
                        @if(auth()->user()->locale == 'en')
                            APPLY
                        @else
                            ANWENDEN
                        @endif
                    </button>
                </div>
            </div>

        </div>
    </div>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
    <script>
        $(document).ready(function () {
            $('#category-graph-title').on('click touch', function () {
                if ($('#category-graph-content:visible').length) {
                    $('#category-graph-content').hide("fade", {direction: "up"}, 200);
                    $('#category-graph-icon').removeClass('fa-angle-down').addClass('fa-angle-right')
                } else {
                    $('#category-graph-content').show("fade", {direction: "down"}, 500);
                    $('#category-graph-icon').removeClass('fa-angle-right').addClass('fa-angle-down')
                }
            })

            $('#pie-chart-title').on('click touch', function () {
                if ($('#pie-chart-content:visible').length) {
                    $('#pie-chart-content').hide("fade", {direction: "up"}, 20);
                    $('#pie-chart-icon').removeClass('fa-angle-down').addClass('fa-angle-right')
                } else {
                    $('#pie-chart-content').show("fade", {direction: "down"}, 500);
                    $('#pie-chart-icon').removeClass('fa-angle-right').addClass('fa-angle-down')
                }
            })

            $('#own-price-title').on('click touch', function () {
                if ($('#own-price-content:visible').length) {
                    $('#own-price-content').hide("fade", {direction: "up"}, 200);
                    $('#own-price-icon').removeClass('fa-angle-down').addClass('fa-angle-right')
                } else {
                    $('#own-price-content').show("fade", {direction: "down"}, 500);
                    $('#own-price-icon').removeClass('fa-angle-right').addClass('fa-angle-down')
                }
            })

            $('#comp-price-title').on('click touch', function () {
                if ($('#comp-price-content:visible').length) {
                    $('#comp-price-content').hide("fade", {direction: "up"}, 200);
                    $('#category-graph-icon').removeClass('fa-angle-down').addClass('fa-angle-right')
                } else {
                    $('#comp-price-content').show("fade", {direction: "down"}, 500);
                    $('#comp-price-icon').removeClass('fa-angle-right').addClass('fa-angle-down')
                }
            })

            $('#price-change-title').on('click touch', function () {
                if ($('#price-change-content:visible').length) {
                    $('#price-change-content').hide("fade", {direction: "up"}, 200);
                    $('#price-change-icon').removeClass('fa-angle-down').addClass('fa-angle-right')
                } else {
                    $('#price-change-content').show("fade", {direction: "down"}, 500);
                    $('#price-change-icon').removeClass('fa-angle-right').addClass('fa-angle-down')
                }
            })

            $('#save-filter').on('click touch', function () {
                $('#filter-modal').toggle('modal').removeClass('in')
                $('.modal-backdrop').hide()
                $('body').removeClass("modal-open");
            });

            $('#save-filter-for-pie').on('click touch', function () {
                $('#pie-filter-modal').toggle('modal').removeClass('in')
                $('.modal-backdrop').hide()
                $('body').removeClass("modal-open");
            });

            if ($(window).width() < 767) {
                $('.hide-for-mobile').remove();
            }
        });
    </script>
    <!-- Load and execute javascript code used only in this page -->
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
    <script src="{{ asset('js/pages/readyDashboard.js') }}"></script>
    <script>
        $(function () {
            ReadyDashboard.init();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            marketDistributionChart();
            var marketDistribution;

            function showLegendsForPieChart(labels, backgrounds) {
                let windowWidth = $(window).width();
                if (windowWidth < 1460) {
                    var br = '<br>'
                } else {
                    br = ''
                }
                var text = '<div class="col-md-12" style="color: #fff; font-weight: bolder">@t("legend")</div>';
                var inlineStyle = "";
                if ($(window).width() > 767) {
                    var className = 'col-md-12';
                    var style = ''
                    inlineStyle = 'display: inline-block;width: 68%'
                } else {
                    className = 'col-xs-6 col-md-6';
                    style = '';
                    // style = 'display:inline-block; width: 48%; padding-left: 15px';
                }
                if ($(window).width() > 769 && $(window).width() < 1300) {
                    inlineStyle = ''
                }
                labels.forEach((label, i) => {
                    labelArray = label.split(' - ')
                    text += '<div class="' + className + '" style="' + style + '">' +
                        // '<div style="display: inline-block;text-align: left; background: ' + backgrounds[i] + ';" class="line-chart-legend">' + labelArray[0] + '</div>' + br +
                        '<div style="background: ' + backgrounds[i] + ';' + inlineStyle + '" class="line-chart-legend">' + labelArray[0] + '</div>' + br +
                        '<b style="color: #fff;">' + labelArray[1] + '</b>' +
                        '</div>';


                })
                $('#pie-chart-legends').html(text)
            }

            function marketDistributionChart() {
                var ctx = document.getElementById("myChart");
                var data = JSON.parse($('#chart-data').val());
                if (marketDistribution !== undefined) {
                    marketDistribution.destroy();
                }
                showLegendsForPieChart(data.labels, data.background)

                let noDataFound = true;
                for (let i = 0; i < data.values.length && noDataFound; i++) {
                    if (data.values[i] > 0) {
                        noDataFound = false;
                    }
                }
                if (noDataFound) {
                    $('#myChartNoDataArea').show();
                    $('#myChart').hide();
                } else {
                    $('#myChartNoDataArea').hide();
                    $('#myChart').show();
                    marketDistribution = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: '# of Products',
                                data: data.values,
                                backgroundColor: data.background,
                                borderColor: data.border,
                                borderWidth: 1
                            }],
                        },
                        options: {
                            legend: {
                                display: false,
                            },
                            responsive: false,
                        },

                    });
                }
            }

            $('.filter-select').on('change', function () {
                $('#dLoader').show()
                // var url = location.protocol + '//' + location.host + location.pathname;
                var url = '{{ url('/') }}' + '?get-market-distribution-data=' + 1;
                url = generatePieChartUrl(url)
                // window.location.href = url;
                $.ajax({
                    url: url,
                    cache: true,
                    success: function (response) {
                        $('#chart-data').val(response)
                        marketDistributionChart();
                        $('#dLoader').hide()
                        setPieChartFilterOption()
                    }
                });
            });

            function generatePieChartUrl(url) {
                var category = $('#category-select').val();
                var competitor = $('#competitor-select').val();

                if (category !== '') {
                    url += '&category=' + category;
                }
                if (competitor !== '') {
                    // url += category === '' ? '?' : '&';
                    url += '&competitor=' + competitor;
                }
                return url;
            }

            setPieChartFilterOption();

            function setPieChartFilterOption() {
                let catName = $('#category-select option:selected').text();
                catName = catName.length > 15 ? catName.substr(0, 14) + '...' : catName;
                $('#pie-chart-category-name').text(catName);
                $('#pie-chart-competitor-name').text($('#competitor-select option:selected').text());
            }

            $('#export-pie-chart-data').on('click', function () {
                base = '{{ route('pie.chart.export') }}';
                url = generatePieChartUrl(base);
                window.location.href = url;
            })

            $('#export-pie-chart-data-in-pdf').on('click', function () {
                base = '{{ route('pie.chart.export.in.pdf') }}';
                url = generatePieChartUrl(base);
                window.location.href = url;
            })

            // LINE CHART
            categoryAveragePriceChart();
            var categoryAveragePrice;

            function categoryAveragePriceChart() {
                var dataVals = $('#line-chart-data').val();
                var categoryAveragePriceChartData = dataVals.length > 0 ? JSON.parse(dataVals) : [];
                if (dataVals.length) {
                    if (categoryAveragePriceChartData.yearOverlap) {
                        var labels = categoryAveragePriceChartData.labels.map(date => {
                            var dateArr = date.split('.');
                            var updateDate = dateArr[1] + '/' + dateArr[0] + '/' + dateArr[2];
                            var isExists = dateCheck(updateDate);

                            date = date.split('.');
                            date = date[0] + '.' + date[1] + '.' + date[2].substring(2);
                            if (isExists || dateArr[2] !== '{{ date('Y') }}') {
                                return date;
                            }

                            return date.split('.').reverse().slice(1).reverse().join('.') + '.';
                        })
                    } else {
                        labels = categoryAveragePriceChartData.labels.map(date => {
                            return date.split('.').reverse().slice(1).reverse().join('.') + '.';
                        })
                    }

                    function dateCheck(updateDate) {
                        var fromDate = '01/01/{{ date('Y') }}';
                        var toDate = '01/15/{{ date('Y') }}';
                        var fDate, lDate, cDate;
                        fDate = Date.parse(fromDate);
                        lDate = Date.parse(toDate);
                        cDate = Date.parse(updateDate);

                        if ((cDate <= lDate && cDate >= fDate)) {
                            return true;
                        }
                        return false;
                    }

                    var max = categoryAveragePriceChartData.max;
                    var min = categoryAveragePriceChartData.min;
                } else {
                    labels = Last7Days();
                    categoryAveragePriceChartData.datasets = [];
                    max = 0;
                    min = 0;
                }

                if (categoryAveragePrice !== undefined) {
                    categoryAveragePrice.destroy();
                }
                var ctx = document.getElementById("line-chart").getContext('2d');
                categoryAveragePrice = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: categoryAveragePriceChartData.datasets,
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function (item) {
                                        const formatter = new Intl.NumberFormat('de-DE', {
                                            // style: 'currency',
                                            currency: 'EUR'
                                        })
                                        return formatter.format(item);
                                    },
                                    // beginAtZero: true,
                                    suggestedMax: max,
                                    suggestedMin: min,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: ''
                                },
                                gridLines: {
                                    drawBorder: true,
                                    display: true
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    drawBorder: true,
                                    display: true
                                }
                            }],
                        },
                        animation: {
                            duration: 1,
                            onComplete: function () {
                                var controller = this.chart.controller;
                                var chart = controller.chart;
                                var yAxis = controller.scales['y-axis-0'];
                                if ($(window).width() < 767) {
                                    var widthToRemove = 25;
                                    var heighToRemove = 10;
                                } else {
                                    widthToRemove = 75;
                                    heighToRemove = 20;
                                }
                                var xOffset = chart.width - (chart.width - widthToRemove);
                                var yOffset = chart.height - (chart.height - heighToRemove);
                                ctx.font = '12px roboto';
                                ctx.fillStyle = '#666666';
                                ctx.fillText('@t("Currency") (€)', xOffset, yOffset);
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function (tooltipItems, data) {
                                    const formatter = new Intl.NumberFormat('de-DE', {
                                        style: 'currency',
                                        currency: 'EUR'
                                    })
                                    return ' ' + formatter.format(tooltipItems.yLabel);
                                }
                            }
                        },
                    },
                });

                // Chart.plugins.register({
                //     afterDraw: function (chart) {
                //         if (chart.data.datasets.length === 0) {
                //             // No data is present
                //             var ctx = chart.chart.ctx;
                //             var width = chart.chart.width;
                //             var height = chart.chart.height
                //             // chart.clear();
                //
                //             ctx.save();
                //             ctx.textAlign = 'center';
                //             ctx.textBaseline = 'middle';
                //             ctx.font = "20px Roboto non-sherif";
                //             ctx.fillText('@t("filter_message")', width / 2, height / 2);
                //             ctx.restore();
                //         }
                //     }
                // });
            }

            $('.line-filter-select').on('change', function () {
                $('#lineChartLoader').show()
                getSelectedCompName();
                var url = generateUrl('{{ url('/get-line-chart-data') }}');
                $.ajax({
                    url: url,
                    cache: true,
                    success: function (response) {
                        $('#line-chart-data').val(response);
                        categoryAveragePriceChart();
                        $('#lineChartLoader').hide()
                        setLineChartFilterOption();
                    }
                });
            });


            setLineChartFilterOption();

            function setLineChartFilterOption() {
                $('#line-chart-time-period').text($('#line-chart-select option:selected').text());
                let catName = $('#line-category-select option:selected').text();
                catName = catName.length > 15 ? catName.substr(0, 14) + '...' : catName;
                $('#line-chart-category-name').text(catName);
                $('#line-chart-competitor-name').text($('#line-competitor-select option:selected').text());
            }


            function getSelectedCompName() {
                let name = $('#line-competitor-select').find('option:selected').text();
                if (name === 'All' || name === 'Alle') {
                    let all = $('#all-comps').val();
                    all = JSON.parse(all);
                    var text = '';
                    all.forEach((item, i) => {
                        text += '<div class="col-md-6">' +
                            '<div class="line-chart-legend legend-color-' + (i + 1) + '">' + item + '</div>' +
                            '</div>';

                    })

                    if (all.length === 0) {
                        $('#legend-title').css('display', 'none');
                    }
                } else {
                    text = '<div class="col-md-6">' +
                        '<div class="line-chart-legend legend-color-1">' + name + '</div>' +
                        '</div>';
                }

                $('#competitors-legend').html(text)

                $('#legend-title').show();
            }

            function generateUrl(url) {

                var lineCategory = $('#line-category-select').val();
                var lineCompetitor = $('#line-competitor-select').val();
                var categoryAveragePriceChartType = $('#line-chart-select').val();

                url += lineCategory !== '' ? '?lineCategory=' + lineCategory : '?lineCategory=';
                url += lineCompetitor !== '' ? '&lineCompetitor=' + lineCompetitor : '&lineCompetitor=';
                url += categoryAveragePriceChartType !== '' ? '&categoryAveragePriceChartType=' + categoryAveragePriceChartType : '&categoryAveragePriceChartType=';
                return url;
            }

            $('#export-data').on('click', function () {
                base = '{{ route('line.chart.export') }}';
                url = generateUrl(base);
                window.location.href = url;
            })

            $('#export-data-in-pdf').on('click', function () {
                base = '{{ route('line.chart.export.in.pdf') }}';
                url = generateUrl(base);
                window.location.href = url;
            })

            $('#reset-line-filter').on('click', function () {
                $('#line-chart-select').val('last_7_days')
                $("#line-category-select").val($("#line-category-select option:first").val());
                $("#line-competitor-select").val($("#line-competitor-select option:first").val());
                var url = '{{ url('/get-line-chart-data') }}';

                $.ajax({
                    url: url,
                    cache: false,
                    success: function (response) {
                        // $("#results").append(html);
                        // console.log(response)
                        $('#line-chart-data').val(response)
                        categoryAveragePriceChart();
                        $('#save-filter').trigger('touch')
                    }
                });
            })

            // For reset label
            function Last7Days() {
                var result = [];
                for (var i = 0; i < 7; i++) {
                    var d = new Date();
                    d.setDate(d.getDate() - i);
                    result.push(formatDate(d))
                }

                return result;
            }

            function formatDate(date) {
                var dd = date.getDate();
                var mm = date.getMonth() + 1;
                if (dd < 10) {
                    dd = '0' + dd
                }
                if (mm < 10) {
                    mm = '0' + mm
                }
                date = dd + '.' + mm + '.';
                return date
            }
        });
    </script>


    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        function setColumnLabel(colIndex) {
            let str;
            switch (colIndex) {
                case 0:
                    str = '@t("product_name")';
                    break;
                case 1:
                    str = '@t("competitor")';
                    break;
                case 2:
                    str = '@t("percentage_difference")';
                    break;
            }
            return str;
        }

        $(document).ready(function () {
            $(".increaseMenu li a").click(function () {
                $(".increaseMenuText").html($(this).text() + "<span class='caret'></span>");

            });
            $('.increaseMenu li a').first().trigger('click');
            $(".decreaseMenu li a").click(function () {
                $(".decreaseMenuText").html($(this).text() + "<span class='caret'></span>");

            });
            $('.decreaseMenu li a').first().trigger('click');


            App.datatables();

            getDailyInfo(2)

            async function getDailyInfo(type) {
                try {
                    var dayDataUrl = "{{ route('products.comparison.getProductPerDay') }}"
                    const response = await axios.get(dayDataUrl);
                    if (response) {
                        if (type === 0) {
                            await renderTable($('#tableDayIncrease'), $('#dayIncreaseCount'), true, dayDataUrl);
                        } else if (type === 1) {
                            await renderTable($('#tableDayDecrease'), $('#dayDecreaseCount'), false, dayDataUrl);
                        } else {
                            await renderTable($('#tableDayIncrease'), $('#dayIncreaseCount'), true, dayDataUrl);
                            await renderTable($('#tableDayDecrease'), $('#dayDecreaseCount'), false, dayDataUrl);
                        }
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            async function getWeeklyInfo(type) {
                try {
                    var weekDataUrl = "{{ route('products.comparison.getProductsForWeek') }}"
                    const response = await axios.get(weekDataUrl);
                    if (response) {
                        if (type === 0) {
                            await renderTable($('#tableWeekIncrease'), $('#weekIncreaseCount'), true, weekDataUrl);
                        } else if (type === 1) {
                            await renderTable($('#tableWeekDecrease'), $('#weekDecreaseCount'), false, weekDataUrl);
                        } else {
                            await renderTable($('#tableWeekIncrease'), $('#weekIncreaseCount'), true, weekDataUrl);
                            await renderTable($('#tableWeekDecrease'), $('#weekDecreaseCount'), false, weekDataUrl);
                        }
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            async function getMonthlyInfo(type) {
                try {
                    var monthDataUrl = "{{ route('products.comparison.getProductByMonth') }}"
                    const response = await axios.get(monthDataUrl);
                    if (response) {
                        if (type === 0) {
                            await renderTable($('#tableMonthIncrease'), $('#monthIncreaseCount'), true, monthDataUrl);
                        } else if (type === 1) {
                            await renderTable($('#tablemonthDecrease'), $('#monthDecreaseCount'), false, monthDataUrl);

                        } else {
                            await renderTable($('#tableMonthIncrease'), $('#monthIncreaseCount'), true, monthDataUrl);
                            await renderTable($('#tablemonthDecrease'), $('#monthDecreaseCount'), false, monthDataUrl);
                        }
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            $('#countTrends').text('0');
            $('#countTrendsDec').text('0');

            $('#dayDataInc').on('click', function () {
                if (!$('#dayIncreaseCount').text()) {
                    $('#countTrends').text('0');
                } else {
                    $('#countTrends').text($('#dayIncreaseCount').text());
                }

            });
            $('#dayDataDec').on('click', function () {
                if (!$('#dayDecreaseCount').text()) {
                    $('#countTrendsDec').text('0');
                } else {
                    $('#countTrendsDec').text($('#dayDecreaseCount').text());
                }
            });

            var weekData = null;
            $('#weekDataInc').on('click', async function () {
                if (weekData == null) {
                    const data = await getWeeklyInfo(0);
                }
                if (!$('#weekIncreaseCount').text()) {
                    $('#countTrends').text('0');
                } else {
                    $('#countTrends').text($('#weekIncreaseCount').text());
                }

            });
            $('#weekDataDec').on('click', async function () {
                if (weekData == null) {
                    const data = await getWeeklyInfo(1);
                }
                if (!$('#weekDecreaseCount').text()) {
                    $('#countTrendsDec').text('0');
                } else {
                    $('#countTrendsDec').text($('#weekDecreaseCount').text());
                }
            });

            var monthData = null;
            $('#monthDataInc').on('click', async function () {
                if (monthData == null) {
                    const data = await getMonthlyInfo(0);
                }
                if (!$('#monthIncreaseCount').text()) {
                    $('#countTrends').text('0');
                } else {
                    $('#countTrends').text($('#monthIncreaseCount').text());
                }
            });
            $('#monthDataDec').on('click', async function () {
                if (monthData == null) {
                    const data = await getMonthlyInfo(1);
                }
                if (!$('#monthDecreaseCount').text()) {
                    $('#countTrendsDec').text('0');
                } else {
                    $('#countTrendsDec').text($('#monthDecreaseCount').text());
                }

            });

            async function renderTable(selector, selectorTypeCount, isItPositive, url) {
                var className = 'decrease'
                var trendSelector = $('#countTrendsDec');
                if (isItPositive) {
                    className = 'increase';
                    trendSelector = $('#countTrends');
                    url = url + '?inc=1';
                } else {
                    url = url + '?inc=0';
                }
                selector.DataTable(
                    {
                        "bPaginate": false,
                        // "bLengthChange": false,
                        "bFilter": false,
                        "stateSave": true,
                        "bDestroy": true,
                        'ajax': {
                            'url': url,
                            'type': 'GET',
                            'error': function (error) {
                                console.log(error.responseText);
                            },
                            'dataSrc': await function (json) {
                                selectorTypeCount.text(json.length);
                                trendSelector.text(selectorTypeCount.text());
                                return json.splice(0, 3);

                            }
                        },
                        "columns": [
                            {
                                "data": null,
                                "render": function (data, type, row, meta) {
                                    var width = $(window).width();
                                    if (width < 1366) {
                                        var productName = row.product_name.length > 15 ? row.product_name.substr(0, 15) + '...' : row.product_name;
                                    } else {
                                        productName = row.product_name.length > 30 ? row.product_name.substr(0, 30) + '...' : row.product_name;
                                    }
                                    return '<span class="text-orange  "><a class="text-orange" href="/products/' + row.id +
                                        '"><strong class="underline-on-hover">' + productName + '</strong></a></span>';

                                }
                            },
                            {
                                "data": null,
                                "render": function (data, type, row, meta) {
                                    return '<a href="/products?compName=' + row.name.split(' ').join('||') + '">' + row.name + '</a>';
                                }
                            },
                            {
                                "data": null,
                                "render": function (data, type, row, meta) {
                                    if (type === 'display') {
                                        return '<span class="label ' + className + '">' + showVisualDifference(row.price_difference, true) + '</span>';
                                    }
                                    return row.price_difference;
                                }
                            },
                        ],
                        "columnDefs": [
                            {className: "text-center", "targets": [1, 2]},
                        ],
                        "order": [[2, "desc"]],
                        'initComplete': async function (settings, json) {
                            selector.addClass('mobile-responsive-v2');
                            var rows = $(selector.selector + ' th').length;
                            var columns = $(selector.selector + ' tr').length;
                            await shapeTable(rows, columns, selector.selector);
                            $('.table .text-center').removeClass('text-center');
                        },
                        'fnDrawCallback': async function () {
                            // $('.table .text-center').removeClass('text-center');
                            // setTimeout(async function () {
                            //     var rows = $(selector.selector + ' th').length;
                            //     var columns = $(selector.selector + ' tr').length;
                            //     await shapeTable(rows, columns, selector.selector);
                            // }, 350)
                        },
                        'createdRow': function (row, data, rowIndex) {
                            $.each($('td', row), function (colIndex) {
                                $(this).attr('data-label', setColumnLabel(colIndex));
                            });
                        },
                        language: {
                            "searchPlaceholder": searchString(),
                            "sEmptyTable": emptyTable(),
                            "sInfo": getInfo(),
                            "sInfoEmpty": getEmpty(),
                            "sLoadingRecords": getLoading(),
                        },

                    });
            }

            function showVisualDifference(difference, percents = false) {
                let dif = parseFloat(difference);
                if (dif === 0) {
                    return difference + (percents ? ' %' : '');
                }
                return (dif > 0 ? '+ ' : '- ') + Math.abs(difference) + (percents ? ' %' : '');
            }

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


            function getLoading() {
                // return envLang === 'en' ? "Loading..." : "Lädt...";
                return '<div class="loader">\n' +
                    '                    <svg width="200px" height="200px">\n' +
                    '                        <g id="document">\n' +
                    '                            <path fill="#EFEADE" d="M120,87.068L108,75H80v50h40V87.068z M120,87.068"/>\n' +
                    '                            <path fill="#D6D1BC"\n' +
                    '                                  d="M90.741,99.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 C90.333,98,90,98.334,90,98.753C90,99.166,90.333,99.5,90.741,99.5L90.741,99.5z M90.741,99.5"/>\n' +
                    '                            <path fill="#D6D1BC"\n' +
                    '                                  d="M91.001,93.5h9.998c0.552,0,1.001-0.335,1.001-0.75c0-0.413-0.449-0.75-1.001-0.75h-9.998 C90.45,92,90,92.337,90,92.75C90,93.165,90.45,93.5,91.001,93.5L91.001,93.5z M91.001,93.5"/>\n' +
                    '                            <path fill="#D6D1BC" d="M108,75v12h12L108,75z M108,75"/>\n' +
                    '                            <path fill="#D6D1BC"\n' +
                    '                                  d="M90.741,105.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,105.166,90.333,105.5,90.741,105.5L90.741,105.5z M90.741,105.5"/>\n' +
                    '                            <path fill="#D6D1BC"\n' +
                    '                                  d="M90.741,111.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,111.166,90.333,111.5,90.741,111.5L90.741,111.5z M90.741,111.5"/>\n' +
                    '                            <path fill="#D6D1BC"\n' +
                    '                                  d="M90.741,117.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,117.166,90.333,117.5,90.741,117.5L90.741,117.5z M90.741,117.5"/>\n' +
                    '                        </g>\n' +
                    '                        <g id="search">\n' +
                    '                            <path fill="#566181"\n' +
                    '                                  d="M127.039,127.787l-13.217-13.213c2.793-2.594,4.555-6.285,4.555-10.385c0-7.821-6.367-14.189-14.188-14.189 C96.37,90,90,96.369,90,104.189c0,7.82,6.37,14.188,14.189,14.188c2.783,0,5.375-0.818,7.57-2.211l13.449,13.451 c0.26,0.246,0.582,0.383,0.924,0.383c0.32,0,0.646-0.137,0.906-0.383C127.545,129.111,127.545,128.291,127.039,127.787z M92.582,104.189c0-6.396,5.211-11.608,11.608-11.608c6.406,0,11.607,5.211,11.607,11.608c0,6.402-5.201,11.607-11.607,11.607 C97.793,115.797,92.582,110.592,92.582,104.189z"/>\n' +
                    '                        </g>\n' +
                    '                    </svg>\n' +
                    '                </div>'
            }
        });

        function openFilterModal() {
            $('#filter-modal').toggle('modal')
        }
    </script>
@stop
