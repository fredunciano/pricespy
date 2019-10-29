@if (storage()->exists($product->image))
    <a class="btn btn-secondary btn-sm" data-toggle="lightbox" href="{{ storage()->url($product->image) }}">
         <i class="custom-icon-image"> </i>
    </a>
@else
    -
@endif
