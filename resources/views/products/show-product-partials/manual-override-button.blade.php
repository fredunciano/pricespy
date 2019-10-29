<div class="form-group">

    <div class="col-md-12 no-padding" style="padding-bottom: 5px!important;">
        <label class="padding-top-for-mobile" for="manual_override">@t('allow_automatic_price_override')</label>
    </div>

</div>
<div class="col-xs-3 no-padding" id="manual_override-area">
    <input type="checkbox" id="manual_override"
           name="manual_override" value="1"
           class="form-group"
           data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
           data-on="@t('yes')" data-off="@t('no')"
           @if (old('manual_override', $product->manual_override)) checked @endif
    >
</div>
<div class="col-xs-2" id="excl-icon">
    <i class="fa fa-exclamation-circle" style="font-size: 35px"></i>
</div>
<div class="col-xs-7 no-padding">
    {!! t('automatic_override_warning') !!}
</div>
