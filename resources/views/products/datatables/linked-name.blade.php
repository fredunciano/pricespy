<div class="text-orange capital">
    <a href="{{ route('products.show', $product) }}">
        @if (strlen($product->name) > 25)
            <strong class="underline-on-hover" title="{{ $product->name }}">{{ substr($product->name, 0, 25) }}
                ...</strong>
        @else
            <strong class="underline-on-hover">{{ $product->name }}</strong>
        @endif
    </a>
</div>
