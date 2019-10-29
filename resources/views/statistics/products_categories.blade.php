@extends('layouts.app')
@section('styles')
    <style>
        @media screen and (max-width: 767px) {
            .page-head-title {
                width: 30%;
            }
            .mobile-responsive-v1 td::before{
                width: 45%;
            }
        }
    </style>
@stop
@section('page-title')
    @t('products')
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass"
                                                                            class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
@stop
@section('content')
    <div class="table-responsive statistics">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                <th class="{{ hc('red') }} ">@tbl('product_name')</th>
                <th class="{{ hc('purple') }} ">@tbl('my_product_price')</th>
                <th class="{{ hc('orange') }} ">@tbl('competitor_price')</th>
                <th class="{{ hc('red') }} ">@tbl('price_difference')</th>
                <th class="{{ hc('green') }} ">@tbl('percentage_difference')</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($getProducts as $products)
                @php $product = $products->product @endphp
                @php $mainProduct = $products->mainProduct @endphp
                @php $percentageDifference = round(($products->difference['signed'] / $mainProduct->price) * 100, 2) @endphp
                <tr>
                    <td data-label="@t('product_name')">
                         <div class="text-orange capital">
                             <a class="text-orange" href="/products/{{$mainProduct->id}}">
                                 <strong class="underline-on-hover">{{ strlen($products->product->name) > 25 ? substr($products->product->name, 0, 22).'...' : $products->product->name }}</strong>
                             </a>
                         </div>
                    </td>
                    <td data-label="@t('my_product_price')"  title="@t(auth()->user()->after_tax_prices ? 'gross' : 'net')"
                        data-order="{{ $mainProduct->showPriceRange() }}">
                        {{ $mainProduct->showPriceRange() }}
                    </td>
                    <td data-label="@t('competitor_price')"  title="@t(auth()->user()->after_tax_prices ? 'gross' : 'net')"
                        data-order="{{ $product->amount }}" style="color:#e4e7de;">
                        {{ $product->showPriceRange() }}
                    </td>
                    <td data-label="@t('price_difference')"   data-order="{{$products->difference['signed']}}">
                        <span class="label @if($products->difference['signed'] > 0) increase
                                           @elseif($products->difference['signed'] == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ formatMoney($products->difference['signed']) }}
                            {{--{{ showVisualDifference($products->difference['signed']) }} €--}}
                        </span>
                    </td>
                    <td data-label="@t('percentage_difference')" data-order="{{$percentageDifference}}">
                        <span class="label @if($percentageDifference > 0) increase
                                           @elseif($percentageDifference == 0) neutral
                                           @else decrease
                                           @endif">
                            {{ showVisualDifference($percentageDifference, true) }}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @include('partials.back', ['back' => route('statistics.competitors.index')])

@endsection

@section('scripts')
    <script>
        App.datatables();
        $('.datatable').dataTable({
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            "order": [[1,2,3,4,"desc"]],
            language: {
                "searchPlaceholder": searchString(),
                "sEmptyTable": emptyTable(),
                "sInfo": getInfo(),
                "sInfoEmpty": getEmpty(),
            },
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
