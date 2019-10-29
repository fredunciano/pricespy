@extends('layouts.app')
@section('page-title')
    @t('settings')
@stop
@section('styles')
    <style>

        .form-group label{
            text-transform: uppercase;
            color: #818594;
        }

        .hover-on-icon:hover{
            cursor: pointer;
        }
    </style>
@stop
@section('content')
    <div class="row" id="row-container">
        <div class="col-md-12">
            @include('settings.form')
        </div>

    </div>

@endsection

@section('scripts')
    @include('settings.scripts')
@stop