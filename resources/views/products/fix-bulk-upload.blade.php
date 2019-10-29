@extends('layouts.app')
@section('page-title')
    @t('import_from_csv')
@stop
@section('content')
    <div id="product-list" class="row">
        <bulk-upload-fix :bulk_product="{{ json_encode($bulkProductUploadHasError) }}"
                         :total="{{ 0 }}"
                         :shops="{{ json_encode($shops) }}"
                         :categories="{{ json_encode($categories) }}"
                         :deleted="{{ 0 }}"
                         :uploaded="{{ 0 }}"
                         :auth_id="{{ json_encode($auth_id) }}"
                         :back_url="{{ json_encode(url()->previous()) }}"
        ></bulk-upload-fix>
    </div>
    {{--@include('partials.back', ['back' => url()->previous()])--}}
@endsection
@section('page-button')

    <a href="#" class="btn btn-custom-3" data-toggle="modal" data-target="#filterProduct">
        <div class="row">
            <div class="col-md-4" style="padding-right: 0; padding-left: 0">
                <i class="fa fa-bars" style="font-size: 50px"></i>
            </div>
            <div class="col-md-8" style="padding-right: 0; padding-left: 0">
                <div class="text">@tbl('batch_process')</div>
            </div>
        </div>

    </a>

@stop
@section('scripts')
    @if(isset($bulkProductUploadHasError))
        <script src="{{ asset('/js/lang.js') }}"></script>
        <script src="{{ asset('js/products/create/bulk-upload-fix.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            $('.full').removeClass('block');

            let selector = $('#shop_system');

            selector.on('change', function () {
                let selected = parseInt(selector.val());
                if (selected > 1) {
                    $('#default').css('display', 'none')
                    $('#alter').css('display', 'block')
                } else {
                    $('#default').css('display', 'block')
                    $('#alter').css('display', 'none')
                }

                if (selected === 2 || selected === 3 || selected === 6) {
                    $('#delimiter').html('{{ t('ins_comma') }}')
                } else {
                    $('#delimiter').html('{{ t('ins_semi_colon') }}')
                }
            })
        })
    </script>
@endsection