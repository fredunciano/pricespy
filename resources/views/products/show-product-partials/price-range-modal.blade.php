<!-- Modal -->
<div id="price-range-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@t('quantity_discount')</h4>
            </div>
            <div class="modal-body">
                <table class="table table-custom table-vcenter datatable">
                    <thead>
                    <tr>
                        <th class="{{ hc(0) }}">@tbl('quantity')</th>
                        <th class="{{ hc(1) }}">@tbl('price')</th>
                        <th class="{{ hc(2) }}">@tbl('discount')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($product->formattedQuantityDiscount() as $discount)
                        <tr>
                            <td data-label="@t('amount')">
                                <div class="text-orange capital">
                                    {{ $discount['amount'] }}
                                </div>
                            </td>
                            <td data-label="@t('price')">
                                {{ $discount['price'] }}
                            </td>
                            <td data-label="@t('discount')">
                                <span class="label"
                                      @if($discount['discount']) style="background: {{ getGradient($discount['discount']) }}" @endif>
                                    {{ $discount['discount'] ? showVisualDifference($discount['discount'], true) : '-' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>
                    * {{ $product->source->netto ? trans('general.exclude_vat_message') : trans('general.include_vat_message') }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue" data-dismiss="modal">@t('close')</button>
            </div>
        </div>

    </div>
</div>
