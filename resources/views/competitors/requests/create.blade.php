@extends('layouts.app')
@section('page-title')
    @t('request_competitor')
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('competitors.requests.store') }}" method="post" class="">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">@t('name')*</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="@t('name')" minlength="3" maxlength="100" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                        <b class="help-block">{{ $errors->first('name') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="url">@t('url')*</label>
                    <input type="text" id="url" name="url" class="form-control" placeholder="https://example.com" minlength="3" maxlength="100" value="{{ old('url') }}" required>
                    @if ($errors->has('url'))
                        <b class="help-block">{{ $errors->first('url') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="remarks">@t('remarks')</label>
                    <textarea id="remarks" name="remarks" class="form-control" placeholder="@t('remarks')" maxlength="1000">{{ old('remarks') }}</textarea>
                    @if ($errors->has('remarks'))
                        <b class="help-block">{{ $errors->first('remarks') }}</b>
                    @endif
                </div>

                <div class="form-group form-actions pull-right">
                    <button type="submit" class="btn btn-effect-ripple btn-success" style="overflow: hidden; position: relative;">@t('submit')</button>
                </div>
            </form>
        </div>
    </div>
    @include('partials.back', ['back' => url()->previous()])
@endsection
@section('scripts')
    <script>
        window.isSubmitting = false;
    </script>
@endsection