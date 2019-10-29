@extends('layouts.app')
@section('page-title')
    @t('update_product_price_from_csv')
@stop
@section('styles')
    <style>
        div.upload {
            background-color: #1e202e;
            border: 1px solid #1e202e;
            border-radius: 5px;
            display: inline-block;
            height: 40px;
            padding: 4px 40px 3px 3px;
            position: relative;
            width: 100%;
        }

        div.upload:hover {
            opacity: 0.95;
        }

        div.upload input[type="file"] {
            display: inline-block;
            width: 100%;
            height: 30px;
            opacity: 0;
            cursor: pointer;
            position: absolute;
            left: 0;
        }

        .uploadButton {
            background-color: #10b7b0;
            border: none;
            border-radius: 3px;
            color: #FFF;
            cursor: pointer;
            display: inline-block;
            height: 30px;
            margin-right: 15px;
            width: auto;
            padding: 0 20px;
            box-sizing: content-box;
        }

        .fileName {
            font-family: Arial;
            font-size: 14px;
        }

        .upload + .uploadButton {
            height: 38px;
        }

        #csv-import-info-box div p {
            margin-bottom: 0;
        }
    </style>
@endsection
@section('content')
    @if(!isset($bulkPriceUpdate))
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12 block" style="padding: 20px 15px; border-radius: 3px; min-height: 500px">
                    <form id="csvFileUploadForm" action="{{ route('products.price.update.by.file') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <hr style="border-top: 1px solid #414860; margin: 10px 0">
                            @t('Price_Update_Template'): <a href="{{ route('products.price.update.template') }}">PriceFeed-Vorlage.csv</a>
                            <hr style="border-top: 1px solid #414860; margin: 10px 0">
                        </div>
                        <div class="form-group">
                            <label for="file">@t('select_file')</label>
                            <div class="upload">
                                <input type="button" class="uploadButton" id="file-selector" value="@t('Choose_file')"/>
                                <input type="file" name="file" id="fileUpload"/>
                                <span class="fileName" id="file-name">@t('No_file_chosen')</span>
                            </div>

                            @if ($errors->has('file'))
                                <div style="margin: 10px 0;padding: 10px; background: #cc4444; color: #ccc">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                        <input type="hidden" name="enable_price_override" id="enable_price_override" value="0">
                        <div class="form-group form-actions">
                            <button type="submit" class="btn btn-green"
                                    style="overflow: hidden; position: relative;">@t('upload')
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-12">
                    <i class="fa fa-exclamation-circle" style="font-size: 24px"></i>
                    <b style="font-size: 20px;">@t('instructions'):</b>
                    <br>
                    <br>
                </div>
                <div id="csv-import-info-box">
                    <ul>
                        <li>@t('price_update_instruction_1')</li>
                        <li>@t('price_update_instruction_2')</li>
                        <li>@t('price_update_instruction_3')</li>
                        <li>@t('price_update_instruction_4')</li>
                        <li>@t('price_update_instruction_5')</li>
                    </ul>
                </div>


            </div>
        </div>
    @else
        <div id="product-list" class="row">
            <bulk-price-update-fix :bulk_product="{{ json_encode($bulkPriceUpdate) }}"
                                   :solution_type="{{ $solutionType }}"
                                   :shops="{{ json_encode($shops) }}"
                                   :categories="{{ json_encode($categories) }}"
            ></bulk-price-update-fix>
        </div>
    @endif
    @include('partials.back', ['back' => url()->previous()])
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.full').removeClass('block');

            $('input[type="file"]').change(function (e) {
                var fileName = e.target.files[0].name;
                $('#file-name').html(fileName)
                $('#file-selector').val('@t("Change_File")')
            });
        });
    </script>

    @if(isset($bulkPriceUpdate))
        <script src="{{ asset('/js/lang.js') }}"></script>
        <script src="{{ asset('js/products/update/bulk-price-update-fix.js') }}"></script>
    @endif
@endsection