@extends('layouts.app')
@section('page-title')
    @t('options_binding')
@stop
@section('content')

    @if ($mainSource && $sources->count())
        <div class="row">
            <form class="form-horizontal" method="post" action="{{ url('option-binding') }}">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-1">
                        <div class="form-group">
                            <label class="control-label">@t('main_store')</label>
                            <a href="{{ route('options-overview', ['s' => $mainSource->id]) }}" style="float:right; display:block">@t('show_listing')</a>
                            <select id="main-option" name="main-option" class="form-control">
                                @foreach ($options as $option)
                                    <option value="{{ $option->id }}">
                                        {{ $option->category }} {{ $option->name }} ( +{{ $option->showPrice() }} )
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4 col-xs-offset-1">
                        @foreach ($sources as $source)
                            @if (count($source->options))
                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label">{{ $source->name }}</label>
                                        <a href="{{ route('options-overview', ['s' => $source->id]) }}" style="float:right; display:block">@t('show_listing')</a>
                                        <select name="options[{{ $source->id }}][]" class="form-control options" style="max-height:150px;">
                                            <option value="">@t('none')</option>
                                            @foreach ($source->options->sortBy('name') as $option)
                                                <option id="option-{{ $option->id }}" value="{{ $option->id }}">
                                                    {{ $option->category }} {{ $option->name }} ( +{{ $option->showPrice() }} )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="form-group">
                            <div class="text-right" style="padding-top:10px;">
                                <button class="btn btn-success">@t('bind')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        <h2>
            @tl('no_data_yet')
        </h2>
    @endif
@endsection
@section('scripts')
    <!-- Load and execute javascript code used only in this page -->
    <script src="/js/pages/uiTables.js"></script>
    <script>$(function(){ UiTables.init(); });</script>
    <script>
        $(document).ready(function() {
            $('.options').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                buttonWidth: '100%',
            });
            loadOptionBindings($('#main-option'));
        });
        $('#main-option').on('change', function() {
            $('#status-block').hide();
            loadOptionBindings($(this));
        });

        function loadOptionBindings(source) {
            let option = source.val();
            $.post('/options/' + option + '/loadBindings', {_token: getCsrf()},  function(response) {
                $('.options > option').prop('selected', false);
                $.each(response, function(index, value) {
                    $('#option-' + value).prop('selected', true).closest('select').multiselect('refresh');
                });
                $('select:not(#main-option)').multiselect('refresh');
            });
        }
    </script>
@endsection