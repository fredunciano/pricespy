@extends('layouts.app')
@section('page-title')
    @t('profile')
@stop
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6/css/select2.min.css"/>
    <style>
        .select2-container .select2-selection--single {
            background-color: #1e202e;
            border-color: #1e202e;
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
            color: #ccc;
        }

        .form-control:focus, .table.table-pricing.table-featured, .table.table-pricing:hover, a.list-group-item.active, a.list-group-item.active:hover, a.list-group-item.active:focus, .pager > li > a:hover, .pagination > li > a:hover, .fc-event, .chosen-container .chosen-drop, .chosen-container-multi .chosen-choices li.search-choice, .chosen-container-active .chosen-single, .chosen-container-active.chosen-with-drop .chosen-single, .chosen-container-active .chosen-choices, div.tagsinput span.tag, .select2-container.select2-container--open .select2-dropdown, .select2-container--default.select2-container--open .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple, .select2-container--default.select2-container--focus.select2-container--open .select2-selection--multiple {
            background-color: #1e202e;
            border-color: #1e202e;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ccc;
        }

        .form-group label {
            text-transform: uppercase;
            color: #818594;
        }

    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('profiles.form')
        </div>
    </div>
@endsection

@section('scripts')
    @include('profiles.scripts')
@endsection