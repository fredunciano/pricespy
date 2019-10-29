@extends('layouts.app')
@section('styles')
    <style>
        tr td .capital {
            white-space: normal;
        }
    </style>
@endsection
@section('page-title')
    @t('price_comparison')
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; float: left; padding-left: 15px">
        <button id="toggle-table-view" class="btn btn-orange"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>

@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                {{--<th class=" {{ hc(0) }}">@tbl('id')</th>--}}
                <th class="{{ hc(0) }}">@tbl('name')</th>
                <th class=" {{ hc(1) }}">@tbl('category')</th>
                <th class=" {{ hc(2) }}" style="width: 9%">@tbl('my_price')</th>
                <th class=" {{ hc(3) }}">@tbl('store')</th>
                <th class=" {{ hc(4) }}">@tbl('competitor_price')</th>
                <th class=" {{ hc(5) }}">@tbl('price_difference')</th>
                <th class=" {{ hc(6) }}">@tbl('link')</th>
                <th class=" {{ hc(7) }}">@tbl('since')</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($bindings as $binding)
                @php $product = $binding->product @endphp
                @php $mainProduct = $binding->mainProduct @endphp
                <tr>
                    {{--<td >{{ $product->id }}</td>--}}
                    <td data-label="@t('name')">
                        {{ route('products.show', ['product' => $product]) }} - {{ $product->name }}
                    </td>
                    <td data-label="@t('category')">
                        {{ route('categories.show', $product->category_id) }} - {{$product->category->name}}
                    </td>
                    <td data-label="@t('my_price')"
                        title="@t(auth()->user()->after_tax_prices ? 'gross' : 'net')"
                        data-order="{{ $mainProduct->amount }}">
                        {{ $mainProduct->showPrice() }}
                        @if ($mainProduct->hasRangedPrice())
                            - {{ $mainProduct->showMaxPrice() }}
                        @endif
                    </td>
                    <td data-label="@t('store')">
                        {{--                        <a href="{{ url('products?s='.str_replace(' ', '||', $product->source->name)) }}"--}}
                        {{--                           title="{{ $product->source->name }}">--}}
                        {{--                            {{ strlen($product->source->name) > 15 ? substr($product->source->name, 0,13).'...': $product->source->name }}</a>--}}

                        {{ url('products?s='.str_replace(' ', '||', $product->source->name)) }}
                        - {{$product->source->name}}
                    </td>
                    <td data-label="@t('competitor_price')"
                        title="@t(auth()->user()->after_tax_prices ? 'gross' : 'net')"
                        data-order="{{ $product->amount }}">
                        {{ $product->showPrice() }}
                        @if ($product->hasRangedPrice())
                            - {{ $product->showMaxPrice() }}
                        @endif
                    </td>
                    <td data-label="@t('price_difference')"
                        data-order="{{ $binding->product->amount*100 - $binding->mainProduct->amount*100 }}">
                        <span class="label" style="background-color:{{ $binding->difference['colour'] }}">
                            {{ $binding->difference['signed'] }}
                        </span>
                    </td>
                    <td data-label="@t('link')">
                        <a href="{{ $product->link }}" target="_blank">
                            <div class="custom-icon-link"
                                 style="width: 22px; height: 21px; vertical-align: super; cursor: pointer"></div>
                        </a>

                    </td>
                    <td data-label="@t('since')">{{ $product->fetched_at->format('d.m.Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    {{--    @include('partials.datatable-export-scripts')--}}

    <script>
        UiTables.init({
            bAutoWidth: false,
            columnDefs: [
                {
                    targets: [0, 1, 3], // the target for this configuration, 0 it's the first column
                    render: function (data, type, row, index) {
                        dataArray = data.split(' - ');
                        data = name = dataArray[1];
                        if (type === 'display') {
                            var url = dataArray[0];
                            if (index.col === 0) {
                                if ($(window).width() < 1367) {
                                    data = data.substr(0, 20) + '...';
                                } else {
                                    data = data.length > 45 ? data.substr(0, 45) + '...' : data;
                                }
                                return '<div class="text-orange capital">' +
                                    '<a href="' + url + '" title="' + name + '">' +
                                    '<strong class="underline-on-hover">' + data + '</strong>' +
                                    '</a>' +
                                    '</div>';
                            } else {
                                if ($(window).width() < 1367) {
                                    data = data.substr(0, 15) + '...';
                                } else {
                                    data = data.length > 20 ? data.substr(0, 20) + '...' : data;
                                }
                                return '<a href="' + url + '" title="' + name + '">' + data + '</a>';
                            }

                        } else {
                            return name;
                        }
                    }
                },
                {orderable: false, targets: [7]}
            ],
            drawCallback: function () {
                $('.pagination li:not(.disabled)', this.api().table().container())
                    .on('click', function () {
                        $('.table .text-center').removeClass('text-center');
                        columns = $('.table tr').length;
                        rows = $('.table th').length;
                        shapeTable(rows, columns);
                        showProductName()
                    });
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    title: "@t('price_comparison') - Pricefeed",
                    filename: "@t('price_comparison') - Pricefeed",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7],
                    },
                    customize: function (doc) {
                        doc.content[1].margin = [50, 0, 0, 0];
                        doc.styles.tableHeader.alignment = 'left';
                        doc.styles.tableBodyEven.alignment = 'left';
                        doc.styles.tableBodyOdd.alignment = 'left';

                        doc['footer'] = (function (page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: ['@t("date"): ', {text: (new Date().toDateString())}]
                                    },
                                    {
                                        alignment: 'right',
                                        text: ['@t("page") ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                    }
                                ],
                                margin: 100
                            }
                        });
                        var objLayout = {};

                        objLayout['paddingLeft'] = function (i) {
                            return 15;
                        };
                        objLayout['paddingRight'] = function (i) {
                            return 5;
                        };
                        doc.content[0].layout = objLayout;

                        doc['footer'] = (function (page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: ['@t("date"): ', {text: "{{ date('d.m.Y') }}"}]
                                    },
                                    {
                                        alignment: 'right',
                                        text: ['@t("page") ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                    }
                                ],
                                margin: 20
                            }
                        });
                    }
                },
                {
                    extend: 'excel',
                    title: "@t('price_comparison') - Pricefeed",
                    filename: "@t('price_comparison') - Pricefeed",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7],
                    },
                },
                {
                    extend: 'csv',
                    title: "@t('price_comparison') - Pricefeed",
                    filename: "@t('price_comparison') - Pricefeed",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7],
                    },
                }
            ],
        });
        showProductName();
        if ($(window).resize()) {
            showProductName()
        }

        function showProductName() {
            let width = $(window).width();
            if (width > 1366) {
                $('.laptop-size').hide()
                $('.desktop-size').show()
            } else {
                $('.desktop-size').hide()
                $('.laptop-size').show()
            }
        }

        setTimeout(function () {
            $('.dt-buttons').css('float', 'left !important');
        }, 300)
    </script>

    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
