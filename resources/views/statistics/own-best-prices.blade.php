@extends('layouts.app')
@section('page-title')
    @t('own_best_prices') - {{ date('d.m.Y') }}
@stop
@section('page-button')
    <div id='toggle-button' style="display: none;">
        <button id="toggle-table-view" class="btn btn-orange"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
    
@stop
@section('content')
    <div id="price-spy-app">
        <own-best-prices :categories="{{ json_encode($categories) }}"></own-best-prices>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/lang.js') }}"></script>
    <script src="{{ asset('js/statistics/own-best-prices.js') }}"></script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection