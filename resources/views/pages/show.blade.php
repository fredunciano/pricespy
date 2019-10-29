@extends('layouts.app')
@section('page-title')
    @t('page') #{{ $page->id }}
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
        <!--div class="text-right separator-s">
                    <a class="btn btn-info" href="{{ route('pages.edit', $page->id) }}"><i class="fa fa-pencil"> </i> @t('edit-page', true)</a>
                </div-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-vcenter table-custom">
                    <tr>
                        <td><b>@t('url')</b></td>
                        <td>{{ $page->url }}</td>
                    </tr>
                    <tr>
                        <td><b>@t('category')</b></td>
                        <td>{{ $page->category->display_name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @include('partials.back', ['back' => route('pages.index')])
@endsection