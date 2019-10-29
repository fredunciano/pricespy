@extends('layouts.app')
@section('page-title')
    @t('categories')
@stop
@section('page-button')

    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
    @if(\App\User::requestCheck('competitorCreate'))
        <a class="btn-header-mobile-view" style="margin-top: 5px" href="{{ route('categories.create') }}">
            <div class="col-xs-12 orange page-top-button-area">
                <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                    <i class="fa fa-plus-circle text-light-op"></i>
                </div>
                <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0">
                    <h4 class="widget-text text-right">
                        @t('add_category')
                    </h4>
                </div>
            </div>
        </a>
    @endif
@stop
@section('content')
    <!-- Datatables is initialized in js/categories/uiTables.js -->
    <div class="block full">

        <div class="table-responsive">
            <table class="table table-custom table-vcenter datatable">
                <thead>
                <tr>
                    <th scope="col" class="{{ hc(0) }}">@tbl('name')</th>
                    <th scope="col" class=" {{ hc(1) }}">@tbl('description')</th>
                    <th scope="col" class=" {{ hc(2) }}">
                        <div class="action">
                            @tbl('actions')
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td data-label="@t('name')">
                            <div class="text-orange capital">
                                <a href="{{ route('categories.show', $category->id) }}"
                                   title="{{ $category->description }}">
                                    <strong class="underline-on-hover">{{ $category->name }}</strong>
                                </a>
                            </div>

                        </td>
                        <td data-label="@t('description')" >
                            {{ $category->description ? $category->description : '-' }}
                        </td>
                        <td data-label="@t('actions')" class="action-column" >
                            <a href="{{ route('categories.edit', $category->id) }}" class="icon-push"><i
                                        class="fa fa-pencil" style="color: #fff"></i></a>
                            @if (!($category->pages_count + $category->products_count))
                                <form method="post" action="{{ route('categories.destroy', $category->id) }}"
                                      style="display:inline-block">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <i class="fa fa-times danger pointer"
                                       onclick="$(this).closest('form').submit()"></i>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        if ($(window).width() < 767){
           $('.action-column').addClass('text-left')
        } else {
            $('.action-column').addClass('text-right')
            $('.action').hide()
        }
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