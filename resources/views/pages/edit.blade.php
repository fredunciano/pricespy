@extends('layouts.app')
@section('page-title')
    @t('edit-page') {{ $page->id }}
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('pages.update', $page->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @php $sourceId = old('source_id') ? : $page->source_id @endphp
                    <label for="source_id">@t('store')</label>
                    <select class="form-control" name="source_id">
                        @foreach ($sources as $source)
                            <option value="{{ $source->id }}" @if ($source->id == $sourceId) selected @endif>{{ $source->url }} ({{ $source->name }})</option>
                        @endforeach
                    </select>
                    @if ($errors->has('source_id'))
                        <b class="help-block">{{ $errors->first('source_id') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="url">@t('url')</label>
                    <input type="text" id="url" name="url" class="form-control" placeholder="Url" minlength="3" maxlength="100" value="{{ old('url') ? : $page->url }}">
                    @if ($errors->has('url'))
                        <b class="help-block">{{ $errors->first('url') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label for="type">@t('type')</label>
                    <select id="type" name="type" class="form-control" disabled>
                        <option name="page" selected>@t('page')</option>
                    </select>
                    @if ($errors->has('type'))
                        <b class="help-block">{{ $errors->first('type') }}</b>
                    @endif
                </div>
                <div class="form-group">
                    <label>Category*</label>
                    @php $categoryId = old('category_id', $page->category_id); @endphp
                    <select id="categories" class="form-control" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id == $categoryId) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <b class="help-block">{{ $errors->first('category_id') }}</b>
                    @endif
                </div>

                <div class="form-group form-actions">
                    <button type="submit" class="btn btn-effect-ripple btn-success" style="overflow: hidden; position: relative;">@t('update')</button>
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