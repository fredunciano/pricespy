<span title="@t(auth()->user()->after_tax_prices ? 'gross' : 'net')"
      data-order="{{ $product->showPriceRange() }}">
    {{ $product->showPriceRange() }}
</span>
