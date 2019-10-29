@extends('layouts.app')
@section('styles')
    <style>
        @media screen and (max-width: 767px) {
            .page-head .pull-right.mt20 {
                width: 100%;
            }

        }
    </style>
@endsection
@section('page-title')
    @t('products_overview') (@t('competitor'))
@stop
@section('page-button')

    <div>
        <div id='toggle-button' style="display: none; float: left; padding-right: 20px; padding-left: 15px">
            <button id="toggle-table-view" class="btn btn-orange"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
                View
            </button>
        </div>

        @if(\App\User::requestCheck('productCreate'))
            <a class="btn-header-mobile-view" href="{{ route('competitors.products.create') }}">
                <div class="col-xs-12 orange page-top-button-area">
                    <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                        <i class="fa fa-plus-circle text-light-op"></i>
                    </div>
                    <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0">
                        <h4 class="widget-text text-right">
                            @t('add_product')
                        </h4>
                    </div>
                </div>
            </a>
        @endif
        @if(\App\User::requestCheck('productEdit'))
            <a class="btn-header-mobile-view show-for-desktop" href="{{ route('products.price.update') }}">
                <div class="col-xs-12 green page-top-button-area">
                    <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                        <i class="fa fa-plus-circle text-light-op"></i>
                    </div>
                    <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0">
                        <h4 class="widget-text text-right">
                            @t('update_product_price_from_csv')
                        </h4>
                    </div>
                </div>
            </a>
        @endif
@stop
@section('content')
            <div class="row mb20">
                <div class="col-md-3">
                    <select id="shop-select" class="form-control">
                        @php
                            $currentShop = $_GET['s'] ?? null;
                            if(!isset($_GET['s']) && isset($_GET['compName'])){
                                $currentShop =iconv(mb_detect_encoding($_GET['compName'], mb_detect_order(), true), "UTF-8", $_GET['compName']);
                            }
                        @endphp
                        <option value="">@t('all')</option>
                        @foreach ($stores as $store)
                            <option value="{{ str_replace(' ', '||',$store->name) }}"
                                    @if (str_replace(' ', '||',$store->name) == $currentShop) selected @endif>{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-custom table-vcenter datatable">
                    <thead>
                    <tr>
                        {{--<th class="text-center {{ hc(0) }}">@tbl('id')</th>--}}
                        <th style="display: none"></th>
                        <th class="{{ hc(0) }}">@tbl('product_name')</th>
                        <th class="{{ hc(1) }}">@tbl('image')</th>
                        <th class="{{ hc(2) }}">@tbl('category')</th>
                        <th class="{{ hc(3) }}">@tbl('competitor')</th>
                        <th class="{{ hc(4) }}">@tbl('price')</th>
                        <th class="{{ hc(5) }}">@tbl('link')</th>
                        <th class="{{ hc(6) }}">@tbl('since')</th>
                        <th class="{{ hc(7) }}">
                            <div class="action">
                                @tbl('actions')
                            </div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
@endsection
@section('scripts')
            <style>
                @media only screen and (max-width: 767px) {
                    div.dataTables_length select {
                        width: 100%;
                    }

                    div.dataTables_filter label, div.dataTables_length label {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    .input-group {
                        min-width: 100% !important;
                    }

                    #inline-custom-dropdown {
                        width: 100% !important;
                        padding-left: 0 !important;
                    }
                }

            </style>
            <script>
                if ($(window).width() < 767) {
                    var actionClass = 'text-left'
                } else {
                    actionClass = 'text-right'
                    $('#action').hide()
                }
                UiTables.init({
                    dom: 'l<"#inline-custom-dropdown">frtip',
                    serverSide: true,
                    ajax: '{{ route('ajax.competitors.products.index') }}',
                    columns: [
                        // {name: 'id', className: 'text-center'},
                        {name: 'name', visible: false},
                        {name: 'linkedName', searchable: false},
                        {name: 'image', orderable: false, searchable: false,},
                        {name: 'category_id', orderable: false, searchable: false,},
                        {name: 'source.name', className: 'text-center', orderable: false},
                        {name: 'amount', searchable: false},
                        {name: 'link', orderable: false, searchable: false},
                        {name: 'fetched_at', className: 'text-center'},
                        {name: 'actions', orderable: false, searchable: false, className: actionClass}
                    ],
                    order: [[1, 'asc']],
                    oSearch: {"sSearch": getParam()},
                    initComplete: function (settings, json) {
                        columns = $('.table tr').length;
                        rows = $('.table th').length;
                        shapeTable(rows, columns);
                        $('.table .text-center').removeClass('text-center');
                    },
                    fnDrawCallback: function () {
                        $('.table .text-center').removeClass('text-center');
                        columns = $('.table tr').length;
                        rows = $('.table th').length;
                        shapeTable(rows, columns);
                    },
                    createdRow: function (row, data, rowIndex) {
                        $.each($('td', row), function (colIndex) {
                            $(this).attr('data-label', setColumnLabel(colIndex));
                        });
                    }
                });

                function setColumnLabel(colIndex) {
                    let str;
                    switch (colIndex) {
                        case 0:
                            str = '@t("product_name")';
                            break;
                        case 1:
                            str = '@t("image")';
                            break;
                        case 2:
                            str = '@t("category")';
                            break;
                        case 3:
                            str = '@t("competitor")';
                            break;
                        case 4:
                            str = '@t("price")';
                            break;
                        case 5:
                            str = '@t("link")';
                            break;
                        case 6:
                            str = '@t("since")';
                            break;
                        case 7:
                            str = '@t("actions")';
                            break;
                    }
                    return str;
                }

                function getParam() {
                    var param = window.location.href.slice(window.location.href.indexOf('?') + 1).split('=')[1];
                    if (param !== undefined) {
                        param = param.split('||').join(' ');
                        return decodeURI(param).split('||').join(' ');
                    }
                    return '';
                }

                $('#shop-select')
                    .appendTo("#inline-custom-dropdown");

            </script>
            <script src="js/custom/shop-selector.js"></script>
            <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
