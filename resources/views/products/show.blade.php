@extends('layouts.app')
@section('styles')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i');

        .chartWrapper canvas{
            padding-right: 30px
        }

        .page-head-title {
            width: 65%;
        }

        .description-area {
            margin-right: 0px;
        }

        .quantity_discount {
            padding-top: 30px;
        }

        .calender-label {
            padding: 10px;
        }

        .input-group {
            min-width: 180px;
            max-width: 180px;
        }

        .form-control[disabled], .select2-container--default.select2-container--disabled .select2-selection--multiple {
            background: #1e202e;
            color: #ccc !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #ccc;
            background: #414b70;
        }

        .input-group.custom-input {
            float: left;
            min-width: 100%;
            min-height: 100%;
        }

        label {
            text-transform: uppercase;
        }

        .custom-div {
            padding: 8px;
            width: 200px;
            height: 80px;
            opacity: 1;
            background-image: linear-gradient(109.6deg, #4463b1 20.4%, #8908f2 80%, #8908f2 100.2%);
            text-transform: uppercase;
            color: #fff;
            font-family: Roboto Condensed, sans-serif;
            font-weight: 900;
        }

        .file-upload-area {
            min-height: 100px;
            float: left;
            margin: 0 auto;
        }

        .file-upload-area .fa {
            padding: 35px 35px 30px 35px;
            text-align: center;
        }

        .font-roboto-bold {
            font-size: 10pt !important;
        }

        @media screen and (max-width: 1680px) {
            .file-upload-area .fa {
                padding: 25px 25px 20px 25px;
                text-align: center;
            }
        }

        #linked-area {
            font-family: Roboto, sans-serif;
        }

        #linked-area .linked-number {
            font-size: 30px;
            font-weight: normal;
        }

        #linked-area .linked-icon {
            font-size: 20px;
            font-weight: normal;
            vertical-align: center
        }

        .fa-link {
            font-size: 50px;
        }

        #desktop-linked-area {
            display: block;
        }

        .mobile-linked-area, .remove-for-desktop {
            display: none;
        }

        #image {
            max-height: 170px;
        }

        .btn-desktop {
            min-height: 25px;
            font-size: 12px;
            padding: 10px 15px;
        }

        .store-row {
            padding-left: 10px !important;
        }

        @media screen and  (max-width: 767px) {
            tr td .capital {
                white-space: normal;
            }

            .store-row {
                padding-left: 0 !important;
            }

            .input-group {
                max-width: 85px;
            }

            .from-calender {
                max-width: 140px;
            }

            .to-calender {
                min-width: 140px;
            }

            .from-calender .calender-label, .to-calender .calender-label {
                padding: 0 !important;
            }

            .btn-desktop {
                min-height: auto;
                font-size: 12px;
                padding: 6px;
            }

            #desktop-linked-area {
                display: none;
            }

            .mobile-linked-area, .remove-for-desktop {
                display: block;
            }

            #image {
                max-height: 100%;
            }

            .custom-div {
                padding: 5px;
                width: 110px;
                height: auto;
                position: absolute;
                text-align: center;
                font-weight: bold;
                /*font-family: "Arial Black", arial-black;*/
            }

            #linked-area {
                text-align: center;
                font-family: Roboto, sans-serif;
            }

            #linked-area .linked-number {
                font-size: 20px;
                font-weight: normal;
            }

            #linked-area .linked-icon {
                font-size: 10px;
                font-weight: normal;
                vertical-align: text-top;
            }

            .padding-top-for-mobile {
                padding-top: 10px;
            }

            .fa-link {
                font-size: 25px;
            }

            .info-row {
                padding: 0 15px 0 30px;
            }

            .break-line-hide {
                display: none;
            }

            .title-only-for-mobile .fa {
                background: #1a203a;
            }

            .block {
                margin: 15px !important;
            }

            .category-row {
                padding-right: 15px !important;
            }

        }

        .file-icon {
            background-color: #CCCCCC;
            -webkit-mask: url('{{ asset('img/icons/file-picker.png') }}') center center / cover;
            -webkit-mask-size: 100% 100%;
            -webkit-mask-repeat: no-repeat;
            margin: 0 auto;
        }


    </style>
@endsection
@section('page-title')
    <b style="text-transform: uppercase; font-weight: 200">@t('product_details') <br> <b
            style="color: #fff">{{ $product->name }}</b></b>
@stop
@section('page-button')
    <div class="custom-div" id="desktop-linked-area">
        <div class="col-md-5 col-xs-3">
            <i class="fa fa-link" style="margin-top: 5px"></i>
        </div>
        <div class="col-md-7 col-xs-9">
            <label id="linked-area" for="text">
                <b id="total-connected" class="linked-number">{{ count($selected) - 1  }}</b>
                <b class="linked-icon">x</b>
            </label>
            <br>
            @t('connected')
        </div>
    </div>


    <div class="col-md-12 text-uppercase mobile-linked-area">
        @t('connected')
    </div>

    <div class="custom-div mobile-linked-area">
        <label id="linked-area" for="text">
            <b class="linked-number">{{ count($selected) - 1  }}</b>
            <b class="linked-icon">x</b>
        </label>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-2">
            @if ($product->image)
                <div class="text-center">
                    <label for="fileImage">
                        <img id="image" src="{{ storage()->url($product->image) }}" class="img-responsive"/>
                    </label>
                </div>

            @else
                <label for="fileImage" id="file-picker"
                       style="width: 100%;min-height: 140px; background: #474d64; text-align: center">
                    <br>
                    <div class="file-icon" style="width: 50px; padding: 50px;"></div>
                </label>

                <div class="row">
                    @if ($errors->has('image'))
                        <div class="col-md-12">
                            <b class="help-block text-center">{{ $errors->first('image') }}</b>
                        </div>
                    @endif
                </div>
            @endif
            <label for="fileImage">
                <img src="http://via.placeholder.com/150" id="image" width="200"
                     style="display: none;padding-top: 20px; margin: 0 auto; width: 100%; height: auto;">
            </label>


            <input type="file" id="fileImage" class="form-control" name="image"
                   accept="image/*"
                   onchange="readURL(this);"
                   style="display: none">
        </div>

        <div class="col-md-10 info-row">
            <div class="row description-area">
                <div class="form-group">
                    <label for="description">@t('description')</label>
                    <textarea name="description" id="description" class="form-control"
                              rows="3">{{ $product->description }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-xs-12 no-padding category-row">
                    <div class="form-group">
                        <label for="category">@t('category')</label>
                        {{--<input type="text" disabled value="{{ $product->category->name }}" class="form-control">--}}
                        <select id="category" class="form-control select-select2" multiple disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @if ($category->id === $product->category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div
                    class="@if($product->source->is_main) col-md-7 @else col-md-10 @endif col-xs-12 store-row">
                    <div class="form-group">
                        <label for="stores">@t('stores')</label>
                        <select id="stores" class="form-control select-select2" multiple disabled>
                            @foreach ($stores as $store)
                                <option value="{{ $store->name }}"
                                        @if (in_array($store->name, $selected) == true) selected @endif>{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if($product->source->is_main)
                    <div class="col-md-3 col-xs-12 text-right linked-button-row" style="padding-left: 0">
                        <br class="break-line-hide">
                        <a class="btn btn-success-custom"
                           href="{{ url('/binding?product-id='.$product->id) }}"
                           style="min-height: 25px;font-size: 12px;margin-top: 4px;padding: 5px 8px;color: #ccc">
                            @t('show_linked_product')
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <div class="col-md-12">
            <hr class="hr-color">
        </div>

        <div class="product-price-info-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="link">@t('product_link')</label>
                    <div class="input-group custom-input">
                        <input name="link" id="productLink" class="form-control" value="{{ $product->link }}">
                        <span class="input-group-addon">
                        <a href="{{ $product->link }}" target="_blank"><i
                                class="custom-icon-link"></i></a></span>
                    </div>
                </div>
            </div>

            <div class="@if($product->amount_with_prices) col-md-6 @else col-md-3 @endif col-xs-12">

                <label class="padding-top-for-mobile" for="price">@t('current_price') (&euro;)</label>
                <div class="input-group custom-input">
                    <input type="text" id="current-price" name="current_price"
                           data-price="{{ $product->amount * 100 }}"
                           data-formatted-price="{{ formatMoney($product->amount * 100) }}"
                           onfocus="setPrice()"
                           value="{{ formatMoney($product->amount * 100) }}"
                           class="form-control">
                    <span class="input-group-addon">
                    <button class="btn btn-success-custom"
                            onclick="updatePrice()"
                            style="min-height: 20px; font-size: 12px; padding: 5px 10px; margin-top: -6px">@t('update')</button>
                </span>
                </div>
                @if($product->amount_with_prices)
                    <br>
                    @include('products.show-product-partials.manual-override-button')
                @endif
            </div>

            <div
                class="col-xs-12 @if($product->amount_with_prices == null) col-md-5 @else col-md-2 quantity_discount @endif text-right">
                @if($product->amount_with_prices == null)
                    @include('products.show-product-partials.manual-override-button')
                @else
                    <button class="btn btn-success-custom"
                            data-toggle="modal" data-target="#price-range-modal"
                            style="min-height: 30px; font-size: 12px; padding: 5px 4px; margin-top: -6px">
                        <i class="custom-icon-tags"></i> @t('quantity_discount')
                    </button>
                @endif
            </div>
        </div>

        <div class="col-md-12" id="desktop-block">
            <hr class="hr-color">
        </div>

        <div class="col-xs-12 remove-for-desktop" style="color: #10b7b0; text-align: center; padding-bottom: 15px">
            <hr class="hr-color">
            <label for="last_update">@t('last_update')</label>
            {{ $product->fetched_at->format('d.m.Y - h.i')}} @t('clock')
        </div>

        <div class="col-md-3 col-xs-6">
            <button class="btn btn-secondary-transparent" onclick="reset()">@t('reset')</button>
        </div>

        <div class="col-md-7 col-xs-6 text-right pull-right">
            <div class="col-md-4 remove-for-mobile"></div>
            <div class="col-md-6 remove-for-mobile" style="color: #10b7b0;">
                <label for="last_update">@t('last_update'): </label>
                <br>
                {{ $product->fetched_at->format('d.m.Y - h.i')}} @t('clock')
            </div>
            <div class="col-md-2 col-xs-6 pull-right" style="padding-right: 0">
                <button class="btn btn-success-custom btn-desktop pull-right"
                        style="min-height: 30px; font-size: 12px; padding: 5px 10px; min-width: 100px"
                        onclick="update()">
                    @t('save')
                </button>
            </div>
        </div>
    </div>
@endsection
@section('content-custom')

    <div class="title-only-for-mobile" id="chart-title">
        <h3>@t('product')@t('history') <br/> <b style="color: #fff">TRENDLINE</b>
            <a class="pull-right">
                <i class="fa fa-angle-left fa-2x" id="chart-icon"></i>
            </a>
        </h3>
    </div>

    <div class="block full hide-div-only-for-mobile" id="chart-content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                @if (count($history['labels']))
                    <div class="form-group from-calender" style="display: inline-block">
                        <label class="calender-label" for="Period">@t('period'):</label>
                        <div class='input-group'>
                            <input type='text' class="form-control calender" id="one"
                                   placeholder="{{ strtoupper(t('date_placeholder')) }}"/>
                            <span class="input-group-addon" id="calender1" style="background-color: #1e202e">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group to-calender" style="display: inline-block">
                        <label class="calender-label" for="To">@t('to'):</label>
                        <div class='input-group'>
                            <input type='text' class="form-control calender" id="two"
                                   placeholder="{{ strtoupper(t('date_placeholder')) }}"/>
                            <span class="input-group-addon" id="calendar2" style="background-color: #1e202e">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group export pad-left-10" style="display: inline-block;">
                        <button id="export-chart-data"
                                style="margin-top: -5px;background: #373d58; color: #ccc; border-color: #373d58"
                                class="btn btn-info">
                            @t('csv_export')
                        </button>
                    </div>

                    <div class="form-group export pad-left-10" style="display: inline-block;">
                        <button id="export-chart-data-in-pdf"
                                style="margin-top: -5px;background: #373d58; color: #ccc; border-color: #373d58"

                                class="btn btn-info">
                            @t('pdf_export')
                        </button>
                    </div>

                    <div style="overflow-x: auto; width: 100%">
                        <div class="chartWrapper">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <i>@t('no_history_available')</i>
                    </div>
                @endif
            </div>
        </div>
        @if ($product->source->is_main)
            <div class="row remove-for-mobile">
                <div class="col-md-12">
                    <div class="pull-right">
                        @if ($product->is_watched)
                            <form method="post" action="{{ route('products.watch.destroy', $product) }}">
                                @csrf
                                @method('delete')
                                <a onclick="$(this).closest('form').submit()" class="btn btn-warning">@t('stop_watching')</a>
                            </form>
                        @else
                            <form method="post" action="{{ route('products.watch.store', $product) }}">
                                @csrf
                                <a onclick="$(this).closest('form').submit()" class="btn btn-primary">@t('watch')</a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    {{--<textarea id="chart-data" hidden>{{ json_encode($history) }}</textarea>--}}
    <input id="chart-data" type="hidden" value="{{ json_encode($history) }}"/>
@stop
@section('actions-bottom')
    <div class="remove-for-mobile">
        @include('partials.back', ['back' => route('products.my')])
    </div>
@stop
@section('scripts')
    @include('products.show-product-partials.price-range-modal')

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-de.js"></script>
    <script type="text/javascript">
        function setPrice() {
            let selector = $('#current-price');
            let price = selector.data('price');
            selector.val(price);
        }

        $(document).on("focusout", "#current-price", function (e) {
            let enteredPrice = parseFloat(e.target.value)
            let selector = $('#current-price');
            let price = selector.data('formatted-price');
            if (parseFloat(price) === enteredPrice) {
                selector.val(price);
            } else {
                const formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR'
                })
                selector.val(formatter.format(enteredPrice));
                selector.data('price', enteredPrice)
                selector.data('formatted-price', formatter.format(enteredPrice))
            }
        });

        $(document).ready(function () {

            responsive()

            function responsive() {
                if ($(window).width() > 766) {
                    $('#mobile-image-picker').remove();
                } else {
                    $('#image-picker').remove();
                }

                if ($(window).width() < 767) {
                    $('.save-button-for-mobile').removeClass('pull-right').css('text-align', 'center').css('padding-top', '10px')
                    $('.remove-for-mobile').hide()
                    $('#excl-icon').removeClass('col-xs-1').addClass('col-xs-2')
                    $('#manual_override-area').addClass('col-xs-4')
                    $('.export').removeClass('pad-left-10')
                }
            }

            $(window).on('resize', function () {
                responsive()
            });

            $('#chart-title').on('click touch', function () {
                if ($('#chart-content:visible').length) {
                    $('#chart-content').hide("fade", {direction: "up"}, 200);
                    $('#chart-icon').removeClass('fa-angle-down').addClass('fa-angle-left')
                } else {
                    $('#chart-content').show("fade", {direction: "down"}, 500);
                    $('#chart-icon').removeClass('fa-angle-left').addClass('fa-angle-down')
                }
            })

            let startDate = '{!! $startDate !!}';
            startDate = JSON.parse(startDate)
            let calender = $(".calender");
            calender.datepicker({
                dateFormat: "dd.mm.yy",
                maxDate: new Date,
                minDate: startDate
            });
            calender.datepicker('option', 'dateFormat', 'dd.mm.yy');
            if (envLang === 'en') {
                calender.datepicker($.datepicker.regional['en']);
            } else {
                calender.datepicker($.datepicker.regional['de']);
            }
            $('#calender1').click(function () {
                $("#one").focus();
            });
            $('#calendar2').click(function () {
                $("#two").focus();
            });

            $('#export-chart-data').on('click', function () {
                var url = '{{ route('products.product.chart.export', ['product' => $product->id]) }}';
                url = url + '?linked=' + parseInt($('#total-connected').text());
                window.location.href = url;
            })

            $('#export-chart-data-in-pdf').on('click', function () {
                var url = '{{ route('products.product.chart.export.in.pdf', ['product' => $product->id]) }}';
                url = url + '?linked=' + parseInt($('#total-connected').text());
                window.location.href = url;
            })

        });
    </script>

    <script src="{{ asset('js/chartjs-plugin-annotation.js') }}"></script>
    <script>
        $('#one, #two').on('change', function () {
            let fromDate = $('#one').val();
            let toDate = $('#two').val();
            if (fromDate !== '' && toDate !== '') {
                var url = '{{ url()->current() }}' + '?from=' + fromDate + '&to=' + toDate;
                $.ajax({
                    url: url,
                    cache: true,
                    success: function (response) {
                        showPriceHistory(response);
                    }
                });
            }

        });

        showPriceHistory();
        var myChart;

        async function showPriceHistory(data = 0) {
            if (myChart !== undefined) {
                myChart.destroy();
            }

            var ctx = document.getElementById("myChart");
            if (data === 0) {
                data = JSON.parse($('#chart-data').val());
            }

            var labels = Object.values(data.labels);

            async function dateCheck(updateDate) {
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

            var datasets = [];
            var annotations = [];
            if (data.labels.length) {
                await buildAnnotations();
                datasets = data.datasets
            } else {
                let fromDate = $('#one').val() ? $('#one').val().split('/').join('.').substring(0, 6) : null;
                let toDate = $('#two').val() ? $('#two').val().split('/').join('.').substring(0, 6) : null;
                labels = [fromDate, toDate];
                data = {
                    min: 0,
                    max: 20
                }
            }

            await setCanvasHeight(datasets.length);


            var chart = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function (item) {
                                    const formatter = new Intl.NumberFormat('de-DE', {
                                        style: 'currency',
                                        currency: 'EUR'
                                    })
                                    return formatter.format(item);
                                },
                                beginAtZero: true,
                                suggestedMin: data.min < 0 ? -5 : data.min,
                                suggestedMax: data.max,
                                padding: 50,
                            },
                        }],
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                    legend: {
                        position: 'bottom',
                        onClick: async function (e, legendItem) {
                            let label = legendItem.text
                            var index = annotations.findIndex(await function (ann) {
                                return ann.label.content === getShopName(label + ' Trendline');
                            });
                            if (index > -1) {
                                removedAn = annotations[index]
                                annotations.splice(index, 1)
                            } else {
                                await buildAnnotations()
                            }
                            myChart.data.datasets.forEach(await function (ds) {
                                if (label === ds.label) {
                                    ds.hidden = !ds.hidden;
                                }
                                if (ds.hidden === true) {
                                    ds.clicked = 1
                                } else {
                                    ds.clicked = 0;
                                }
                            });
                            myChart.options.annotation.annotations = annotations;
                            myChart.update()
                        },
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
                        },
                    },
                    hover: function (e) {
                        myChart.config.options.elements.point.radius = 8
                    },
                    spanGaps: true,
                    annotation: {
                        drawTime: 'afterDatasetsDraw',
                        events: ['click', 'mouseenter', 'mouseleave'],
                        annotations: annotations
                    }
                },
            };

            async function buildAnnotations() {

                annotations = []
                for (i = 0; i < data.datasets.length; i++) {
                    let ann = {
                        type: 'line',
                        id: `${i}`,
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: data.datasets[i].trendLineData.start,
                        endValue: data.datasets[i].trendLineData.end,
                        borderColor: data.datasets[i].borderColor,
                        borderWidth: 2,
                        label: {
                            enabled: true,
                            content: getShopName(data.datasets[i].label + ' Trendline'),
                            yAdjust: 0,
                            xAdjust: 50,
                            backgroundColor: data.datasets[i].backgroundColor,
                            position: 'left'
                        },
                        defaultColor: data.datasets[i].backgroundColor,
                        hoverColor: data.datasets[i].hoverColor,
                        onClick: async function (e) {
                            let anId = parseInt(this.id);
                            var shopName = myChart.data.datasets[anId].label;

                            var chart = this;
                            var radius = 0;
                            myChart.data.datasets.forEach(function (ds) {
                                if (shopName !== ds.label && (ds.clicked === 0 || ds.clicked === undefined)) {
                                    ds.hidden = !ds.hidden;
                                }
                                if (shopName === ds.label) {
                                    if (ds.active === undefined || ds.active === false) {
                                        ds.active = true;
                                        chart.options.borderColor = chart.options.hoverColor;
                                        chart.options.label.backgroundColor = chart.options.hoverColor;
                                        radius = 8;
                                    } else {
                                        ds.active = false;
                                        chart.options.borderColor = chart.options.defaultColor;
                                        chart.options.label.backgroundColor = chart.options.defaultColor;
                                        radius = 0;
                                    }
                                }
                            });
                            myChart.config.options.elements.point.radius = radius;
                            myChart.update();
                        },
                        onMouseenter: async function (e) {
                            // let anId = parseInt(this.id);
                            // this.options.borderColor = this.options.hoverColor;
                            // this.options.label.backgroundColor = this.options.hoverColor;
                            // var shopName = myChart.data.datasets[anId].label;
                            // myChart.data.datasets.forEach(function (ds) {
                            //     if (shopName !== ds.label && (ds.clicked === 0 || ds.clicked === undefined)) {
                            //         ds.hidden = !ds.hidden;
                            //     }
                            // });
                            // myChart.config.options.elements.point.radius = 8;
                            // myChart.update();
                        },
                        onMouseleave: function (e) {
                            // this.options.borderColor = this.options.defaultColor;
                            // this.options.label.backgroundColor = this.options.defaultColor;
                            // myChart.config.options.elements.point.radius = 0;
                            // myChart.data.datasets.forEach(function (ds) {
                            //     if (ds.hidden === true && (ds.clicked === 0 || ds.clicked === undefined)) {
                            //         ds.hidden = false
                            //     }
                            // });
                            // myChart.update();
                        },
                    };
                    annotations.push(ann);
                }
            }

            function getShopName(str){

                if ($(window).width() > 800) {
                    return str;
                } else {
                    return str.length > 60 ? str.substr(0, 56) + '...' : str;
                }
            }

            if (datasets.length) {
                myChart = new Chart(ctx, chart);
            }

            if (getParam() !== null) {
                myChart.data.datasets.forEach(function (ds) {
                    var name = getParam();
                    var main = data.datasets[0].label;
                    if (name !== ds.label) {
                        ds.hidden = !ds.hidden;
                    }
                    if (main === ds.label) {
                        ds.hidden = !ds.hidden;
                    }
                });
                myChart.update();
            }

            Chart.plugins.register({
                afterDraw: function (chart) {
                    if (datasets.length === 0) {
                        // No data is present
                        var ctx = chart.chart.ctx;
                        var width = chart.chart.width;
                        var height = chart.chart.height
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.font = "20px Roboto";
                        ctx.fillStyle = Chart.defaults.global.scaleFontColor;
                        ctx.fillText('@t("no_data_for_this_time_period")', width / 2, height / 2);
                        ctx.restore();
                    }
                }
            });

            function setCanvasHeight(length) {
                let windowSize = $(window).width();
                let defaultHeight = 120;
                if (windowSize > 1366) {
                    if (length > 5 && length < 10) {
                        defaultHeight *= 1.2
                    } else if (length > 10 && length < 15) {
                        defaultHeight *= 1.6
                    } else if (length > 15) {
                        defaultHeight *= 2
                    }
                } else if (windowSize < 1367 && windowSize > 700) {
                    if (length > 5 && length < 10) {
                        defaultHeight *= 1.5
                    } else if (length > 10 && length < 15) {
                        defaultHeight *= 3
                    } else if (length > 15) {
                        defaultHeight *= 5
                    }
                } else {
                    if (length > 5 && length < 10) {
                        defaultHeight *= 2.5
                    } else if (length > 10 && length < 15) {
                        defaultHeight *= 5
                    } else if (length > 15) {
                        defaultHeight *= 7.5
                    }
                }

                $('#myChart').attr('height', parseInt(defaultHeight))
            }

            function getParam() {
                var param = window.location.href.slice(window.location.href.indexOf('?') + 1).split('=')[1];
                if (param) {
                    return param.split('-').join(' ');
                }
                return null;
            }
        }
    </script>

    <script>
        function reset() {
            $('#description').val('{{ $product->description }}');
            let link = '{{ $product->link }}';
            $('#productLink').val(link);
            $('#current-price').val('{{ $product->amount * 100 }}');
            let defVal = '{{ $product->manual_override }}';
            $("#manual_override").prop("checked", parseInt(defVal) === 1).change();
        }

        function updatePrice() {
            let currentPrice = $('#current-price').data('price');
            if (currentPrice === '') {
                return alert("@t('price_required')")
            }
            let productId = '{{ $product->id }}';
            let url = '{{ url('products') }}' + '/' + productId + '/product-price-update';
            $.ajax({
                url: url,
                type: 'PATCH',
                data: {price: currentPrice, _token: '{{ csrf_token() }}'}
            }).done(function (response) {
                alert("@t('success')")
            });
        }

        function update() {
            let currentPrice = $('#current-price').data('price');
            if (currentPrice === '') {
                return alert("@t('price_required')")
            }
            let formData = new FormData();
            $imageVal = $('#fileImage')[0].files[0];
            if ($imageVal !== undefined) {
                formData.append("image", $('#fileImage')[0].files[0]);
            }
            formData.append("price", currentPrice);
            let description = $('textarea#description').val();
            formData.append("description", description);
            let link = $('#productLink').val();
            formData.append("link", link);
            let manualOverride = $('#manual_override').prop('checked');
            formData.append("manualOverride", manualOverride);
            formData.append("_token", "{{ csrf_token() }}");
            let productId = '{{ $product->id }}';
            let url = '{{ url('products') }}' + '/' + productId + '/update-product-info';
            $.ajax({
                url: url,
                type: 'post',
                contentType: false,
                processData: false,
                data: formData
            }).done(function (response) {
                alert("@t('success')")
            });
        }


    </script>

    <script type="text/javascript" src="{{ mix('/js/prices.js') }}"></script>
    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image')
                        .attr('src', e.target.result).show();
                    $('#file-picker').hide()

                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
