@extends('layouts.app')
@section('styles')
    <style>
        .btn-default {
            background-color: white
        }

        .custom-div {
            padding: 8px;
            width: 220px;
            height: 80px;
            opacity: 1;
            background-image: linear-gradient(109.6deg, #4463b1 20.4%, #8908f2 60%, #8908f2 100.2%);
            text-transform: uppercase;
            color: #fff;
            font-family: Roboto Condensed, sans-serif;
            font-weight: 900;
            display: inline-block;
        }

        .custom-div.gray {
            background-image: linear-gradient(109.6deg, #bec6cf 20.4%, #bec6cf 60%, #bec6cf 100.2%);
        }

        .select2-selection__choice {
            height: 25px !important;
        }

        @media screen and  (max-width: 767px) {
            .panel, .panel-default > .panel-heading {
                background-color: transparent;
                border-color: transparent;
            }

            .page-head-title {
                width: 30%;
            }

            .custom-div {
                padding: 5px 10px 0 5px;
                width: 90px;
                height: auto;
                position: absolute;
                text-align: center;
                font-weight: bold;
                /*font-family: "Arial Black", arial-black;*/
            }

            .fa-link {
                font-size: 25px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__rendered {
                min-height: 100px;
            }

            .page-head-title {
                text-transform: uppercase;
                font-weight: normal;
            }

            .row.block {
                margin: 0 15px !important;
                padding: 5px;
            }

            #bind-form .control-label {
                text-transform: uppercase;
            }
        }
    </style>
@stop
@section('page-title')@t('bind_products')@stop
@section('page-button')
    <div class="custom-div gray desktop-linked-area">
        <div class="col-md-5 col-xs-5">
            <i class="fa fa-link fa-4x" style="margin-top: 5px"></i>
        </div>
        <div class="col-md-7 col-xs-7">
            <label for="text">
                <b style="font-size: 30px;font-weight: bolder">{{ $products->count() - $totalBind  }}</b> <b
                    style="font-size: 20px;;font-weight: bolder; vertical-align: center">x</b>
            </label>
            <br>
            @t('not_linked')
        </div>
    </div>
    <div class="custom-div desktop-linked-area">
        <div class="col-md-5 col-xs-5">
            <i class="fa fa-link fa-4x" style="margin-top: 5px"></i>
        </div>
        <div class="col-md-7 col-xs-7">
            <label for="text">
                <b style="font-size: 30px;font-weight: bolder">{{ $totalBind  }}</b> <b
                    style="font-size: 20px;;font-weight: bolder; vertical-align: center">x</b>
            </label>
            <br>
            @t('linked')
        </div>
    </div>

    <div class="col-xs-6 no-padding text-uppercase mobile-linked-area" style="padding-right: 12px!important;">
        <b class="text-center" style="padding-left: 10px;">@t('not_linked')</b> <br>
        <div class="custom-div gray mobile-linked-area">
            <label id="linked-area" for="text">
                <b class="linked-number">{{ $products->count() - $totalBind  }}</b>
                <b class="linked-icon">x</b>
            </label>
        </div>
    </div>


    <div class="col-xs-6 no-padding text-uppercase mobile-linked-area" style=" padding-right: 15px!important;">
        <b class="text-center" style="padding-left: 2px">@t('linked')</b> <br>
        <div class="custom-div mobile-linked-area">
            <label id="linked-area" for="text">
                <b class="linked-number">{{ $totalBind  }}</b>
                <b class="linked-icon">x</b>
            </label>
        </div>
    </div>



@stop
@section('content')

    <form method="post" action="{{ route('products.bindings.update') }}" id="bind-form">
        <div class="col-md-12 show-for-mobile" style="padding: 10px 10px">
            <label class="control-label">
                {{ implode(', ', auth()->user()->mainSources->pluck('name')->toArray()) }}
            </label>

            Will show only for mobile

            <select id="main-product-mobile" name="main-product" class="form-control select-select2"
                    style="width: 100%">
                @if(request()->has('product-id'))
                    @php $old = (int) request()->input('product-id') @endphp
                @else
                    @php $old = session('product', null) @endphp
                @endif
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                            @if ($old === $product->id) selected @endif>{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row block">

            {{--Will show only for desktop--}}
            <div class="col-md-12 no-padding show-for-desktop">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b class="text-uppercase ">@t('my_products')</b>
                    </div>
                    <div class="panel-body">
                        <label class="control-label">
                            {{ implode(', ', auth()->user()->mainSources->pluck('name')->toArray()) }}
                        </label>
                        <div class="pull-right mb10"><a href="{{ route('products.my') }}">@t('show_products')</a></div>
                        <select id="main-product" name="main-product" class="form-control select-select2">
                            @if(request()->has('product-id'))
                                @php $old = (int) request()->input('product-id') @endphp
                            @else
                                @php $old = session('product', null) @endphp
                            @endif
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                        @if ($old === $product->id) selected @endif>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 no-padding">
                <div class="panel panel-default">
                    <div class="show-for-mobile">
                        <div class="col-xs-1 no-padding"
                             style="min-height: 30px; padding-left: 10px !important;padding-top: 10px!important;">
                            <i class="fa fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="col-xs-11" style="padding-top: 10px!important;">
                            @t('bind_message_1')
                        </div>
                        <div class="col-xs-12"><br></div>
                        <div class="col-xs-1 no-padding"
                             style="min-height: 30px; padding-left: 10px !important; padding-top: 10px!important;">
                            <i class="fa fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="col-xs-11" style="padding-top: 10px!important;">
                            @t('bind_message_2')
                        </div>
                        <div class="col-xs-12">
                            <hr class="hr-color">
                        </div>
                    </div>

                    <div class="panel-heading">
                        <b class="text-uppercase">@t('stores')</b>
                    </div>

                    <div class="panel-body">


                        @foreach ($sources as $source)
                            @if (count($source->products))
                                <div class="form-group">
                                    <label class="control-label">{{ $source->name }}</label>
                                    <div class="pull-right mb10"><a
                                            href="{{ route('products.index', ['s' => str_replace(' ', '||', $source->name)]) }}" tabindex="-1">@t('show_products')</a>
                                    </div>
                                    <select data-id="{{ $source->id }}" name="products[{{ $source->id }}][]"
                                            class="form-control products" multiple>
                                        @foreach ($source->products->sortBy('name') as $product)
                                            {{--                                            <option id="product-{{ $product->id }}" value="{{ $product->id }}">{{ $product->name }}</option>--}}
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12 no-padding">
                <div class="col-md-12">
                    <hr class="hr-color">
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <button type="reset" id="reset" class="btn btn-secondary-transparent">@t('reset')</button>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    {!! csrf_field() !!}
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-success-custom"
                                style="padding: 5px 8px; height: 33px; min-height: auto">@t('bind')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <input type="hidden" value="{{ json_encode($boundIds) }}" id="boundIds">
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            window.boundIds = $('#boundIds').val()
            initialise();
            loadBindings($('#main-product'));

            responsive()

            function responsive() {
                if ($(window).width() > 766) {
                    $('.desktop-linked-area').show();
                    $('.mobile-linked-area').hide();
                } else {
                    $('.desktop-linked-area').hide();
                    $('.mobile-linked-area').show();
                    $('.full').removeClass('block');
                }
            }

            $(window).on('resize', function () {
                responsive()
            });


        });

        $('#main-product').on('change', function () {
            $('#status-block').hide();
            loadBindings($(this));
        });
        $('#main-product-mobile').on('change', function () {
            $('#status-block').hide();
            loadBindings($(this));
        });

        function loadBindings(source) {
            if (source.val() === null) {
                return false;
            }
            $.post('/products/' + source.val() + '/loadBindings', {_token: getCsrf()}, function (response) {
                $('.products > option').remove();
                $.each(response, function (index, product) {
                    var newOption = new Option(product.name, product.id, true, true);
                    $('.products[data-id=' + product.source + ']').append(newOption).trigger('change');
                });
            });
        }

        function initialise() {
            $('.products').select2({
                width: '100%',
                placeholder: "@t('not_selected')",
                language: {
                    errorLoading: function () {
                        return '@t("the_results_could_not_be_loaded")';
                    },
                    noResults: function () {
                        return '@t("no_result_found")';
                    },
                    searching: function () {
                        return '@t("search")';
                    }
                },
                ajax: {
                    url: function () {
                        var val = $(this).val();
                        return 'load/' + this.data('id') + '/products?bound=' + (val ? val.join(',') : '');
                    },
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true,
                    delay: 150,
                },
                templateSelection: function (data, container) {
                    let id = parseInt(data.id)
                    let ids = JSON.parse(window.boundIds);
                    let bound = ids.includes(id);
                    container.each(function () {
                        $(this).attr('onclick', 'openProductLink(' + id + ')');
                        if (bound) {
                            $(this).addClass('border-design')
                        }
                    });
                    return data.text;
                    {{--return "<a target='_blank' href='{{ url('products') }}/"+ id+"'>" + data.text + " </a>";--}}
                },
            });
        }

        function openProductLink(id) {
            window.open("{{ url('products/') }}" + '/' + id, '_blank')
        }
    </script>
@endsection
