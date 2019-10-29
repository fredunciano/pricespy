@extends('layouts.app')
@section('page-title')
    @t('add_category')
@stop
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">@t('name')*</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="@t('name')" minlength="3" maxlength="100" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                        <b class="help-block">{{ $errors->first('name') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">@t('description')</label>
                    <textarea name="description" class="form-control" placeholder="@t('description')" maxlength="1000">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <b class="help-block">{{ $errors->first('description') }}</b>
                    @endif
                </div>
                <div class="form-group form-actions pull-right">
                    <button type="submit" class="btn btn-effect-ripple btn-success" style="overflow: hidden; position: relative;">@t('submit')</button>
                </div>
            </form>
        </div>
    </div>
    @include('partials.back', ['back' => route('categories.index')])
@endsection
@section('scripts')
    <script>
        window.isSubmitting = false;
    </script>
@endsection