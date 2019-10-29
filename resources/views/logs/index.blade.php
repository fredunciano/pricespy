@extends('layouts.app')
@section('page-title')
    @t('logs')
@stop
@section('content')
    @foreach ($logs as $day => $group)
        <h3>{{ $day }}</h3>
        <div class="row">
            @foreach ($group as $log)
                <table class="table table-custom datatable">
                    <thead>
                    <tr class="{{ hc(0) }}">
                        <th colspan="4">
                            {{ $log->source->name }} @t($log->text)
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @if (!empty($log->params))
                            @if (isset($log->params['parsedCount']))
                                <td style="width:25%">@t('total_updated'): {{ $log->params['parsedCount'] }}</td>
                            @endif
                            @if (isset($log->params['difference']))
                                <td style="width:25%">@t('products_amount_difference'): {{ $log->params['difference'] }}</td>
                            @endif
                            @if (isset($log->params['new']))
                                <td style="width:25%">@t('new_products'): {{ $log->params['new'] }}</td>
                            @endif
                            @if (isset($log->params['deleted']))
                                <td style="width:25%">@t('deleted_products'): {{ $log->params['deleted'] }}</td>
                            @endif
                        @endif
                    </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
    @endforeach
    <div class="row mt20">
        <div class="col-md-12">
            <div class="text-right">
                <a href="{{ route('logs.history') }}" class="btn btn-primary">@t('view_history')</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        UiTables.init();
    </script>
@endsection