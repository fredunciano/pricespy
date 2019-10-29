@extends('layouts.app')
@section('page-title')
    @t('logs')
@stop
@section('content')
    <div class="row">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="text-center {{ hc(0) }}">@tbl('date')</th>
                <th class="text-center {{ hc(1) }}">@tbl('store')</th>
                <th class="text-center {{ hc(2) }}">@tbl('text')</th>
                <th class="text-center {{ hc(3) }}">@tbl('data')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="text-center">
                        <strong>{{ $log->created_at->format('d/m/Y') }}</strong>
                    </td>
                    <td class="text-center">
                        @if ($log->source)
                            <strong>{{ $log->source->name }}</strong>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span>{{ $log->source->name }} @t($log->text)</span>
                    </td>
                    <td class="text-center">
                        @if (!empty($log->params))
                            @if (isset($log->params['parsedCount']))
                                <strong style="display:block">@t('total_updated'): {{ $log->params['parsedCount'] }}</strong>
                            @endif
                            @if (isset($log->params['difference']))
                                <strong style="display:block">@t('products_amount_difference'): {{ $log->params['difference'] }}</strong>
                            @endif
                            @if (isset($log->params['new']))
                                <strong style="display:block">@t('new_products'): {{ $log->params['new'] }}</strong>
                            @endif
                            @if (isset($log->params['deleted']))
                                <strong style="display:block">@t('deleted_products'): {{ $log->params['deleted'] }}</strong>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {{ $logs->render() }}
    </div>
    <!-- END Datatables Block -->
@endsection
@section('scripts')
    <script>
        UiTables.init();
    </script>
@endsection