@extends('layouts.app')
@section('page-title')
    @t('import_from_csv')
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

        @media screen and (min-width: 769px) {
            .block {
                min-height: 500px;
            }
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12 block" style="padding: 20px 15px; border-radius: 3px">
                <form id="csvFileUploadForm" action="{{ route('products.csv.store') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="shop_system">@t('shop_system')</label>
                        <div class="row">
                            <div class="col-md-6">
                                <select name="shop_system" id="shop_system" class="form-control">
                                    <option value="1">PriceFeed-Vorlage</option>
                                    <option value="2">Magento 2</option>
                                    <option value="3">BigCommerce</option>
                                    <option value="4">OpenCart</option>
                                    <option value="5">PrestaShop</option>
                                    <option value="6">Shopify</option>
                                    <option value="7">Shopware</option>
                                </select>
                            </div>
                            <div class="col-md-6" style="padding-top: 5px">
                                <a href="{{ asset('file/priceFeed_product_template.csv') }}"
                                   style="text-transform: uppercase; text-decoration: underline; font-size: 13px">
                                    @t('Product_Bulk_Upload_Template')
                                </a>
                            </div>
                        </div>

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
                        <button type="button" onclick="toggleModal()" class="btn btn-effect-ripple btn-info"
                                style="overflow: hidden; position: relative;">@t('upload')
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="col-md-12 no-padding">
                <i class="fa fa-exclamation-circle" style="font-size: 24px"></i>
                <b style="font-size: 20px;">@t('instructions'):</b>
                <br>
                <br>
            </div>
            <div id="csv-import-info-box">
                <div id="pricefeed" style="display: block; text-align: justify">@t('priceFeed_ins')</div>
                <div id="magento" style="display: none; text-align: justify">@t('magento_ins')</div>
                <div id="magento2" style="display: none; text-align: justify">@t('magento2_ins')</div>
                <div id="bigCommerce" style="display: none; text-align: justify">@t('bigCommerce_ins')</div>
                <div id="openCard" style="display: none; text-align: justify">@t('openCard_ins')</div>
                <div id="prestaShop" style="display: none; text-align: justify">@t('prestaShop_ins')</div>
                <div id="shopify" style="display: none; text-align: justify">@t('shopify_ins')</div>
                <div id="shopware" style="display: none; text-align: justify">@t('shopware_ins')</div>
                <div id="jtl" style="display: none; text-align: justify">@t('jtl_ins')</div>
            </div>


        </div>
    </div>
    @include('partials.back', ['back' => url()->previous()])
@endsection
@section('scripts')

    <div id="overrideModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@t('improve_product_pricing_modal')</h4>
                </div>
                <div class="modal-body">
                    <p>
                        @t('enable_automatic_price_override')
                    </p>

                    <input type="checkbox"
                           id="enable_automatic_price_override"
                           name="enable_automatic_price_override" value="1"
                           class="form-control"
                           data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-on="@t('yes')" data-off="@t('no')" checked
                    >

                </div>
                <div class="modal-footer">
                    <hr class="hr-color">
                    <button type="button" onclick="submitImportForm()" class="btn btn-success-custom pull-left"
                            style="display: inline-block">
                        @t('apply_and_start_import')
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.full').removeClass('block');

            let selector = $('#shop_system');

            selector.on('change', function () {
                let selected = parseInt(selector.val());
                $('#csv-import-info-box div').hide()
                if (selected === 1) {
                    $('#pricefeed').css('display', 'block')
                } else if (selected === 2) {
                    $('#magento2').css('display', 'block')
                } else if (selected === 3) {
                    $('#bigCommerce').css('display', 'block')
                } else if (selected === 4) {
                    $('#openCard').css('display', 'block')
                } else if (selected === 5) {
                    $('#prestaShop').css('display', 'block')
                } else if (selected === 6) {
                    $('#shopify').css('display', 'block')
                } else if (selected === 7) {
                    $('#shopware').css('display', 'block')
                }
            });

            $('input[type="file"]').change(function (e) {
                var fileName = e.target.files[0].name;
                $('#file-name').html(fileName)
                $('#file-selector').val('@t("Change_File")')
            });
        })


        function toggleModal() {
            $('#overrideModal').modal('toggle');
        }

        function submitImportForm() {
            toggleModal();
            let selected = $('#enable_automatic_price_override').prop('checked') === true ? 1 : 0;
            $('#enable_price_override').val(selected);
            $('#csvFileUploadForm').submit();
        }
    </script>
@endsection