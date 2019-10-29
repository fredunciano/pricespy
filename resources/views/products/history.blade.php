@extends('layouts.app')
@section('page-title')
    @t('product_history')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    @include('partials.back', ['back' => route('products.my')])
    <textarea id="chart-data" hidden>{{ $chartData }}</textarea>
@endsection
@section('scripts')
    <script>
    var ctx = document.getElementById("myChart");
        var data = JSON.parse($('#chart-data').html());
        var chart= {
            type: 'line',
            data: {
                labels: Object.values(data.labels),
                datasets: data.datasets
            },
            options: {
                scales: {
                    /*yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }],*/
                },
                legend: {
                    position: 'right',
                },
                spanGaps: true,
            },
        };
        console.log(chart);
        var myChart = new Chart(ctx, chart);
    </script>
@endsection