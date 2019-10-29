@extends('layouts.app')

@section('page-title')
    @t('products')
@stop
@section('content')
    <div class="table-responsive statistics">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="{{ hc('red') }}">@tbl('product_name')</th>
                <th class="{{ hc('purple') }}">@tbl('percentage_difference')</th>
                <th class="{{ hc('orange') }}">@tbl('price_difference')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($getProducts as $products)
                @php $product = $products->product @endphp
                @php $mainProduct = $products->mainProduct @endphp
                @php $percentageDifference = round(($products->difference['signed'] / $mainProduct->price) * 100 ,2)@endphp
                <tr>
                    <td>
                        <div class="text-orange capital">
                            <a class="text-orange"
                               href="/products/{{$mainProduct->id}}">
                                <strong class="underline-on-hover"> {{ $products->product->name }} </strong>
                            </a>
                        </div>
                    </td>

                    <td data-sort="{{$percentageDifference}}">
                        <span class="label @if($products->difference['signed'] > 0) increase
                                           @elseif($products->difference['signed'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ showVisualDifference($percentageDifference, true) }}
                        </span>
                    </td>
                    <td data-sort="{{$products->difference['signed'] }}">
                        <span class="label @if($products->difference['signed'] > 0) increase
                                           @elseif($products->difference['signed'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ showVisualDifference(round( $products->difference['signed'] ,3)) }} €
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @include('partials.back', ['back' => route('statistics.trending.data.getCategories')])

@endsection

@section('scripts')
    <script>
        // UiTables.init();
        App.datatables();
        $('.datatable').DataTable(
            {
                language: {
                    "searchPlaceholder": searchString(),
                    "sEmptyTable": emptyTable(),
                    "sInfo": getInfo(),
                    "sInfoEmpty": getEmpty(),
                },
                "order": [[1,2, "desc"]]
            });

        function searchString() {
            return envLang === 'en' ? 'Search...' : 'Suchen...';

        }

        function emptyTable() {
            return envLang === 'en' ? 'No Data Available' : 'Keine Daten vorhanden';
        }

        function getInfo() {
            return envLang === 'en' ? "Showing _START_ to _END_ of _TOTAL_ entries" : "_START_ bis _END_ von _TOTAL_ Einträgen"
        }

        function getEmpty() {
            return envLang === 'en' ? "Showing 0 to 0 of 0 entries" : "Zeige 0 bis 0 von 0 Einträgen"
        }
    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
