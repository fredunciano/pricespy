@extends('layouts.app')
@section('page-title')
    @t('edit_product')
@stop
@section('styles')
    <style>
        label {
            text-transform: uppercase;
            color: #818594;
            font-size: 13px;
        }

        #mobile-image-picker {
            display: none;
        }

        @media screen and  (max-width: 767px) {
            .submit-btn-area {
                text-align: center !important;
            }

            #image-picker {
                display: none;
            }

            #mobile-image-picker {
                display: block;
            }

            #product-form label {
                color: #818594;
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
@stop
@section('content')
    <div class="row">
        <form id="product-form" action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">

            <div class="row" style="padding: 0 30px" id="mobile-image-picker">
                <label for="">@t('product')@t('image')</label>
                <br>

                @if($product->image == null)
                    <label for="fileImage" id="file-picker"
                           style="width: 100%;min-height: 140px; background: #474d64; text-align: center">
                        <br>
                        <div class="file-icon" style="width: 50px; padding: 50px;"></div>
                    </label>

                    <label for="fileImage" style="margin: 0 auto; width: 100%; padding-bottom: 10px">
                        <img src="http://via.placeholder.com/150" id="image"
                             style="display: none;padding-top: 20px; margin: 0 auto; width: 100%; height: auto;">
                    </label>
                @else
                    <label for="fileImage" style="float: right">
                        <img src="{{ storage()->url($product->image) }}" id="image"
                             style="padding-top: 20px; margin: 0 auto; width: 100%; height: auto;">
                    </label>
                    <div class="col-md-12 text-right" style="float: right">
                        <input value="1" type="checkbox" name="delete-image"> @tl('delete_existing_image')
                    </div>
                @endif


                <input type="file" id="fileImage" class="form-control" name="image"
                       accept="image/*"
                       onchange="readURL(this);"
                       style="display: none">

                @if ($errors->has('image'))
                    <div class="col-md-12">
                        <b class="help-block text-center">{{ $errors->first('image') }}</b>
                    </div>
                @endif
            </div>

            <div class="col-md-4 pull-right" id="image-picker">
                <div class="col-md-12">
                    @if($product->image == null)
                        <label class="file-upload-area" for="fileImage">
                            <i class="fa fa-file-o fa-5x" style="font-size: 100px">
                                <br>
                                <div class="file-upload-text font-roboto-bold">
                                    @if(auth()->user()->locale == 'en')
                                        Click here to <br>
                                        add product image
                                    @else
                                        hier klicken + <br>
                                        produktbild <br>
                                        hinzufügen
                                    @endif
                                </div>
                            </i>

                        </label>
                        <label for="fileImage" style="float: right">
                            <img src="http://via.placeholder.com/150" id="image" height="300"
                                 style="display: none;padding-top: 20px">
                        </label>
                    @else
                        <label for="fileImage" style="float: right">
                            <img src="{{ storage()->url($product->image) }}" id="image" height="300"
                                 style="padding-top: 20px; margin: 0 auto">
                        </label>
                        <div class="col-md-12 text-right" style="float: right">
                            <input value="1" type="checkbox" name="delete-image"> @tl('delete_existing_image')
                        </div>
                    @endif


                    <input type="file" id="fileImage" class="form-control" name="image"
                           accept="image/*"
                           onchange="readURL(this);"
                           style="display: none">
                </div>

                @if ($errors->has('image'))
                    <div class="col-md-12">
                        <b class="help-block text-center">{{ $errors->first('image') }}</b>
                    </div>
                @endif
            </div>
            <div class="col-md-8">

                @csrf
                {!! method_field('PATCH') !!}
                <div class="form-group">
                    <label for="name">@t('product_alt')*</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="@t('name')" maxlength="1000" value="{{ old('name', $product->name) }}" required>
                    @if ($errors->has('name'))
                        <b class="help-block">{{ $errors->first('name') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="link">@t('link')</label>
                    <input type="text" id="link" name="link" class="form-control" placeholder="@t('link')"
                           maxlength="1000" value="{{ old('link', $product->link) }}">
                    @if ($errors->has('link'))
                        <b class="help-block">{{ $errors->first('link') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="source_id">@t('store')</label>
                    @php $sourceId = old('source_id', $product->source_id) @endphp
                    <select id="source"  name="source_id" class="form-control">
                        @foreach ($stores as $store)
                            <option data-vat="{{ $store->getVatAmplifier() }}" value="{{ $store->id }}" @if ($store->id == $sourceId) selected @endif>{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('source_id'))
                        <b class="help-block">{{ $errors->first('source_id') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label>@t('category')*</label>
                    @php $categoryId = old('category_id', $product->category_id); @endphp
                    <select id="categories" class="form-control" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id == $categoryId) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <b class="help-block">{{ $errors->first('category_id') }}</b>
                    @endif
                    <hr class="hr-color show-for-mobile">
                </div>
                <div class="form-group">
                    <label for="vat_price">@t('gross_price') (&euro;)*</label>
                    <input type="number" id="vat_price" name="vat_price" class="form-control" placeholder="10.00"
                           min="0" max="999999999" step="0.01" value="{{ old('vat_price', $product->vat_price) }}"
                           required>
                    @if ($errors->has('vat_price'))
                        <b class="help-block">{{ $errors->first('vat_price') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="price">@t('net_price') (&euro;)*</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="10.00" min="0" max="9999999999" step="0.01" value="{{ old('price', $product->price) }}" required>
                    @if ($errors->has('price'))
                        <b class="help-block">{{ $errors->first('price') }}</b>
                    @endif
                </div>

                @if($product->source->is_main)
                <div class="form-group">
                    <label for="min_price">@t('min_price') (&euro;)*</label>
                    <input type="number" id="min_price" name="min_price" class="form-control" placeholder="10.00"
                           min="0" max="999999999" step="0.01" value="{{ old('min_price', $product->min_price) }}">
                    @if ($errors->has('min_price'))
                        <b class="help-block">{{ $errors->first('min_price') }}</b>
                    @endif
                </div>
                    <div class="form-group">
                        <label for="max_price">@t('max_price') (&euro;)*</label>
                        <input type="number" id="max_price" name="max_price" class="form-control" placeholder="10.00"
                               min="0" max="999999999" step="0.01" value="{{ old('max_price', $product->max_price) }}">
                        @if ($errors->has('max_price'))
                            <b class="help-block">{{ $errors->first('max_price') }}</b>
                    @endif
                </div>
                @endif
                <div class="form-group">
                    <label for="vat_price">@t('shipping_cost') (&euro;)*</label>
                    <input type="number" id="shipping_cost" name="shipping_cost" class="form-control" placeholder="10.00" min="0" max="999999999" step="0.01" value="{{ old('shipping_cost', $product->shipping_cost) }}">
                    @if ($errors->has('shipping_cost'))
                        <b class="help-block">{{ $errors->first('shipping_cost') }}</b>
                    @endif
                </div>

                @if($product->source->is_main)
                <div class="form-group">
                    <label for="purchase_price">@t('purchase_price') (&euro;)*</label>
                    <input type="number" id="purchase_price" name="purchase_price" class="form-control"
                           placeholder="10.00" min="0" max="999999999" step="0.01"
                           value="{{ old('purchase_price', $product->purchase_price) }}">
                    @if ($errors->has('purchase_price'))
                        <b class="help-block">{{ $errors->first('purchase_price') }}</b>
                    @endif
                </div>
                @endif

                <div class="form-group">
                    <div class="col-md-12 no-padding" style="padding-bottom: 5px!important;">
                        <label for="manual_override">@t('allow_automatic_price_override')</label>
                    </div>

                    <div class="col-md-2 no-padding" id="manual_override-area">
                        <input type="checkbox" id="manual_override"
                               name="manual_override" value="1"
                               class="form-group"
                               data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                               data-on="@t('yes')" data-off="@t('no')"
                               @if (old('manual_override')) checked @endif
                        >
                    </div>
                    <div class="col-xs-1" id="excl-icon">
                        <i class="fa fa-exclamation-circle" style="font-size: 35px"></i>
                    </div>
                    <div class="col-xs-6 no-padding">
                        {!! t('automatic_override_warning') !!}

                    </div>
                    @if ($errors->has('manual_override'))
                        <b class="help-block">{{ $errors->first('manual_override') }}</b>
                    @endif
                </div>

            </div>

            <div class="col-md-12" style="margin-top: 30px">
                <div class="col-md-6 no-padding remove-for-mobile">
                    <div class="form-group">
                        <a class="btn btn-secondary-transparent" href="{{ url()->previous() }}">@t('back')</a>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group save-button-for-mobile form-actions pull-right">
                        <button type="submit" class="btn btn-lightblue"
                                style="overflow: hidden; position: relative;">@t('save')
                        </button>

                        <a href="{{ route('products.csv.index') }}" class="btn btn-blue remove-for-mobile">
                            @t('add_product_from_csv')
                        </a>
                    </div>
                </div>
            </div>

            </form>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ mix('/js/prices.js') }}"></script>
    <script>
        window.isSubmitting = false;

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image')
                        .attr('src', e.target.result).show();
                    $('.file-upload-area').hide()

                };

                reader.readAsDataURL(input.files[0]);
            }
        }

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
            }
        }

        $(window).on('resize', function () {
            responsive()
        });
    </script>
@stop