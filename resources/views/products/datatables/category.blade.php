<td class="text-center" title="{{ $product->category->description }}">
    <a href="{{ route('categories.show', $product->category_id) }}">{{ $product->category->name }}</a>
</td>