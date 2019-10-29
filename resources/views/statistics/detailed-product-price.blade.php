@extends('layouts.app')
@section('page-title')
    @t('detailed_product_price') - {{ date('d.m.Y') }}
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>

@stop
@section('content')
    <div id="price-spy-app">
        <detailed-product-price :categories="{{ json_encode($categories) }}"
                                :products="{{ json_encode($products) }}"></detailed-product-price>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/lang.js') }}"></script>
    <script src="{{ asset('js/statistics/detailed-product-price.js') }}"></script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection