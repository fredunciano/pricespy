@extends('layouts.app')
@section('page-title')
    @t('overview')
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
    @if(\App\User::requestCheck('competitorCreate'))
        <a class="btn-header-mobile-view" style="margin-top: 5px" href="{{ route('competitors.requests.create') }}">
            <div class="col-xs-12 orange page-top-button-area">
                <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                    <i class="fa fa-plus-circle text-light-op"></i>
                </div>
                <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0">
                    <h4 class="widget-text text-right">
                        @t('request_competitor')
                    </h4>
                </div>
            </div>
        </a>
    @endif
@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                {{--<th class=" {{ hc(0) }}">@tbl('id')</th>--}}
                <th class="{{ hc(0) }}">@tbl('name')</th>
                <th class=" {{ hc(1) }}">@tbl('link')</th>
                <th class=" {{ hc(2) }}">@tbl('products')</th>
                <th class=" {{ hc(3) }}">@tbl('updated_at')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($competitors as $competitor)
                <tr>
                    {{--<td >{{ $competitor->id }}</td>--}}
                    <td data-label="@t('name')">
                        <div class="text-orange capital">
                            <a href="{{ url('products').'?compName='.str_replace(' ', '||', $competitor->name) }}">
                                <strong class="underline-on-hover">{{ $competitor->name }}</strong>
                            </a>
                        </div>
                    </td>
                    <td data-label="@t('link')" ><a
                                href="{{ $competitor->url }}">{{ $competitor->url }}</a></td>
                    <td data-label="@t('products')" >{{ $competitor->products->count() }}</td>
                    <td data-label="@t('updated_at')"
                        >{{ $competitor->created_at->format('d.m.Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        UiTables.init({
            columnDefs: [{orderable: false, targets: [2]}],
            drawCallback: function () {
                $('.pagination li:not(.disabled)', this.api().table().container())
                    .on('click', function () {
                        $('.table .text-center').removeClass('text-center');
                        columns = $('.table tr').length;
                        rows = $('.table th').length;
                        shapeTable(rows, columns);
                    });
            }
        });
    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection