@extends('layouts.app')
@section('page-title')
    @t('options_table')
@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="text-center" style="width: 50px;">ID</th>
                <th style="width:250px;">@t('product_name')</th>
                <th style="width: 120px;">@t('competitor')</th>
                <th style="width: 120px;">@t('price')</th>
                <th style="width: 120px;">@t('link')</th>
                <th style="width: 120px;">@t('since')</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($options as $option)
                <tr>
                    <td class="text-center">{{ $option->id }}</td>
                    <td><strong>
                            {{ $option->fullName }}
                        </strong></td>
                    <td>
                        {{ $option->source->name }}
                    </td>
                    <td class="text-center">
                        {{ $option->showPrice() }} @if ($option->has_vat_calculated_manually) <span title="@t('vat_calculated_manually')">*</span> @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ $option->link }}" target="_blank">
                            <button class="btn btn-default btn-sm">@t('link') <i class="fa fa-sign-out"> </i></button>
                        </a>
                    </td>
                    <td>{{ $option->fetched_at->format('d.m.Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        UiTables.init();
    </script>
@endsection