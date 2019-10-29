@extends('layouts.app')
@section('page-title')
    @t('category') "{{ $category->name }}"
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass"
                                                                            class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
@stop
@section('content')
    <!-- Datatables Block -->
    <!-- Datatables is initialized in js/categories/uiTables.js -->
    <div class="block full">
        <div class="row">
            <div class="col-xs-12">
                <div class="text-right separator-s">
                    <a class="btn btn-info" href="{{ route('categories.edit', $category->id) }}"><i class="fa fa-pencil"> </i> @t('edit_category')</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-vcenter table-custom">
                        <tr>
                            <td><b>@t('name')</b></td>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@t('products')</b></td>
                            <td>{{ $category->products()->count() }}</td>
                        </tr>
                        <tr>
                            <td><b>@t('listings')</b></td>
                            <td>{{ $category->listings()->count() }}</td>
                        </tr>
                        <tr>
                            <td><b>@t('pages')</b></td>
                            <td>{{ $category->sps()->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('partials.back', ['back' => route('categories.index')])
@endsection

@section('scripts')
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection