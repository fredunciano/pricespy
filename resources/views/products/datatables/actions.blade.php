@if(\App\User::requestCheck('productEdit'))
    <a href="{{ $product->getEditRoute() }}" class="icon-push"><i class="custom-icon-pencil"></i></a>
@endif
