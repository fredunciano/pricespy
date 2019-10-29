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
    @t('products_overview')
@stop

@section('page-button')
    <div id='toggle-button' style="display: none; float: left; padding-right: 20px; padding-left: 15px">
        <button id="toggle-table-view" class="btn btn-orange"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>

    @if(\App\User::requestCheck('productCreate'))
        <a class="btn-header-mobile-view" href="{{ route('products.create') }}">
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


    @if($importFailedProducts > 0)
        <a class="btn-header-mobile-view show-for-desktop" href="{{ route('products.fix.csv.upload') }}">
            <div class="col-xs-12 red page-top-button-area">
                <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                    <i class="fa fa-plus-circle text-light-op"></i>
                </div>
                <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0; min-height: 77px">
                    <h4 class="widget-text text-right">
                        @t('fix_import_failed_products') &nbsp;
                        <b class="label neutral">{{ $importFailedProducts }}</b>
                    </h4>
                </div>
            </div>
        </a>
    @endif
@stop

@section('content')

    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                {{--<th class="{{ hc(0) }}">@tbl('id')</th>--}}
                <th style="display: none"></th>
                <th class="{{ hc(0) }}">@tbl('product_name')</th>
                <th class="{{ hc(1) }}">@tbl('image')</th>
                <th class="{{ hc(2) }}">@tbl('category')</th>
                <th class="{{ hc(3) }}">@tbl('price')</th>
                <th class="{{ hc(4) }}">@tbl('link')</th>
                <th class="{{ hc(5) }}">@tbl('since')</th>
                <th class="{{ hc(6) }}">
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
{{--    @include('partials.datatable-export-scripts')--}}
    <script>
        if ($(window).width() < 767) {
            var actionClass = 'text-left'
        } else {
            actionClass = 'text-right'
            $('#action').hide()
        }
        UiTables.init({
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            serverSide: true,
            ajax: '{{ route('ajax.products.index') }}',
            columns: [
                // {name: 'id', },
                {name: 'name', visible: false},
                {name: 'linkedName', searchable: false,},
                {name: 'image', orderable: false, searchable: false,},
                {name: 'category_id', orderable: false, searchable: false,},
                {name: 'amount', searchable: false},
                {name: 'link', orderable: false, searchable: false,},
                {name: 'fetched_at',},
                {name: 'actions', orderable: false, searchable: false, className: actionClass}
            ],
            order: [[0, 'asc']],
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
            },
            // dom: 'lBfrtip',
            // buttons: [
            //     {
            //         text: 'PDF',
            //         titleAttr: '@t("own") @t("products") - Pricefeed',
            //         className: 'csv',
            //         action: function(e) {
            //             console.log(e)
            //         }
            //     },
            //     {
            //         text: 'Excel',
            //         titleAttr: '@t("own") @t("products") - Pricefeed',
            //         className: 'excel',
            //         action: function(e) {
            //             console.log(e)
            //         }
            //     },
            //     {
            //         text: 'CSV',
            //         titleAttr: '@t("own") @t("products") - Pricefeed',
            //         className: 'csv',
            //         action: function(e) {
            //             console.log(e)
            //         }
            //     },
            //
            // ],
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
                    str = '@t("price")';
                    break;
                case 4:
                    str = '@t("link")';
                    break;
                case 5:
                    str = '@t("since")';
                    break;
                case 6:
                    str = '@t("actions")';
                    break;
            }
            return str;
        }
    </script>
    <script src="{{ asset('js/custom/shop-selector.js') }}"></script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
