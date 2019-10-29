<strong>
    @if (strlen($product->name) > 75)
        <strong title="{{ $product->name }}">{{ substr($product->name, 0, 75) }}...</strong>
    @else
        <strong>{{ $product->name }}</strong>
    @endif
</strong>
