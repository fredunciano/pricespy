@extends('layouts.app')
@section('page-title')
    @t('comparison_table')
@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="text-center" style="width: 50px;">ID</th>
                <th>@t('product_name')</th>
                <th>@t('category')</th>
                <th style="width: 60px;">@t('main_store')</th>
                <th style="width: 60px;">@t('competitor')</th>
                <th style="width: 120px;">@t('competitor_price')</th>
                <th style="width: 60px;">@t('price_difference')</th>
                <th style="width: 60px;">@t('link')</th>
                <th style="width: 60px;">@t('since')</th>
                <th style="width: 15px;">@t('actions')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($bindings as $binding)
                @php $option = $binding->option @endphp
                @php $mainOption = $binding->mainOption @endphp
                <tr>
                    <td class="text-center">{{ $option->id }}</td>
                    <td><strong>{{ $option->name }}</strong></td>
                    <td>
                        <a href="{{ route('categories.show', $option->category_id) }}">{{ $option->category->name }}</a>
                    </td>
                    <td class="text-center">
                        {{ $mainOption->showPrice() }} @if ($mainOption->has_vat_calculated_manually) <span title="@t('vat_calculated_manually')">*</span> @endif
                    </td>
                    <td>
                        {{ $option->source->name }}
                    </td>
                    <td class="text-center">
                        {{ $option->showPrice() }} @if ($option->has_vat_calculated_manually) <span title="@t('vat_calculated_manually')">*</span> @endif
                    </td>
                    <td class="text-center">
                        @if (!$option->price || !$mainOption->price)
                            -
                        @else
                            @if ($mainOption->price == $option->price)
                                <span class="label label-info">0 &euro;</span>
                            @else
                                <span class="label @if ($mainOption->price < $option->price) label-success @else label-danger @endif">
                                    {{ $mainOption->price < $option->price ? '+' : '-' }} {{ formatMoney($option->price - $mainOption->price) }} &euro;
                                </span>
                            @endif
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ $option->link }}" target="_blank">
                            <button class="btn btn-default btn-sm">@t('link') <i class="fa fa-sign-out"> </i></button>
                        </a>
                    </td>
                    <td>{{ $option->fetched_at->format('d.m.Y') }}</td>
                    <td class="text-center">
                        <i onclick="unbind($(this), '{{ $binding->id }}')" class="fa fa-times" style="color:red; font-size:17px; cursor:pointer"></i>
                    </td>
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
    <script>
        function unbind(source, id)
        {
            $.post('/option-binding/' + id + '/delete', {_token: getCsrf()}, function(response) {
                if (response) {
                    source.closest('tr').remove()
                }
            });
        }
    </script>
@endsection