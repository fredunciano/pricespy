@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/d3-chart-custom.css') }}">
@stop
{{--@section('page-title')--}}
    {{--@t('category_percentage_difference')--}}
{{--@stop--}}
@section('content')
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <button id="export-chart-data"
                    style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"
                    class="btn btn-info">
                @t('csv_export')
            </button>
        </div>
        <div class="col-sm-3 col-xs-12">
            <button id="export-chart-data-in-pdf"
                    style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"

                    class="btn btn-info">
                @t('pdf_export')
            </button>
        </div>
    </div>
    <input type="hidden" id="dataset" value="{{ $dataSet }}">
    <div style="width: 100%; overflow: auto">
        <div style="width: 700px; margin: 0 auto">
            <div id="ulList" class="d3chart"></div>
            <div id="chart" class="chart"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#export-chart-data').on('click', function () {
            window.location.href = '{{ route('statistics.category.percentage.difference.in.csv') }}';
        })

        $('#export-chart-data-in-pdf').on('click', function () {
            window.location.href = '{{ route('statistics.category.percentage.difference.in.pdf') }}';
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.8/d3.min.js"></script>
    <script src="{{ asset('js/custom/d3-chart-for-category-percentage-difference.js') }}"></script>
@endsection