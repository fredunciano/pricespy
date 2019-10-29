@extends('layouts.app')
@section('page-title')
    @t('pages')
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; float: left; padding-right: 20px">
        <button id="toggle-table-view" class="btn btn-info"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
    <a class="btn btn-lightblue" href="{{ route('pages.create') }}"><i class="fa fa-plus"> </i> @t('add_page', true)</a>
@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                {{--<th ></th>--}}
                <th class="{{ hc(0) }}">@tbl('store')</th>
                <th class="{{ hc(1) }}">@tbl('url')</th>
                <th class="{{ hc(2) }}">@tbl('category')</th>
                <th class="{{ hc(3) }}">@tbl('type')</th>
                <th class="{{ hc(4) }}"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pages as $page)
                <tr>
                    {{--<td >{{ $loop->index + 1 }}</td>--}}
                    <td data-label="@t('store')">
                        <div class="text-orange capital">
                            @if($page->source->is_main == 1)
                                <a href="{{ url('my-shop') }}">
                                    <strong class="underline-on-hover">{{ $page->source->name }}</strong>
                                </a>
                            @else
                                <a href="{{ url('products').'?compName='.str_replace(' ', '||', $page->source->name) }}">
                                    <strong class="underline-on-hover">{{ $page->source->name }}</strong>
                                </a>
                            @endif
                        </div>
                    </td>
                    <td data-label="@t('url')">
                        <a href="{{ $page->url }}" title="{{ $page->url }}" target="_blank">
                            {{ strlen($page->url) > 70 ? substr($page->url, 0, 70).'...' : $page->url }}
                        </a>
                    </td>
                    <td data-label="@t('category')"  title="{{ $page->category->description }}">
                        <a href="{{ route('categories.show', $page->category_id) }}">{{ $page->category->name }}</a>
                    </td>
                    <td data-label="@t('type')" >@t($page->type)</td>
                    <td data-label="@t('actions')" style="text-align: right">
                        <a href="{{ route('pages.edit', $page->id) }}" class="icon-push">
                            <i class="custom-icon-pencil"></i>
                        </a>
                        @if ($page->type === 'page')
                            <form method="post" action="{{ route('pages.destroy', $page->id) }}"
                                  style="display:inline-block">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <i class="fa fa-times danger pointer" onclick="$(this).closest('form').submit()"></i>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        UiTables.init({
            columnDefs: [{orderable: false, targets: [1, 4]}],
            drawCallback: function () {
                $('.pagination li:not(.disabled)', this.api().table().container())
                    .on('click', function () {
                        shapeTable();
                    });
            }
        });
    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
