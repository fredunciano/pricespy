<form action="{{ route('settings.update') }}" method="post" id="settings-form">
    @csrf
    {!! method_field('PATCH') !!}
    <div class="row form-group">
        <label for="equality-percent" class="col-md-12">@t('define price tolerance limit'):</label>
        <div class="col-md-6 col-xs-6">
            <div style="display: inline-block" onclick="decreaseValue()" class="hover-on-icon">
                <img src="{{ asset('img/icons/minus.png') }}" alt="" style="max-width: 32px; padding-right: 5px">
            </div>

            <input type="text" id="equality-percent" name="equality_percent" class="form-control"
                   placeholder="3.00" min="0" max="10" step="0.1"
                   style="max-width: 60px; display: inline-block"
                   value="{{ old('equality_percent', auth()->user()->equality_percent) }} %" required>
            @if ($errors->has('equality_percent'))
                <b class="help-block">{{ $errors->first('equality_percent') }}</b>
            @endif

            <div style="display: inline-block" onclick="increaseValue()" class="hover-on-icon">
                <img src="{{ asset('img/icons/plus.png') }}" alt="" style="max-width: 32px; padding-left: 5px">
            </div>
        </div>
        <div class="col-md-6 col-xs-6 settings-info text-right">
            <div class="row">
                <div class="icon" style="display: inline-block">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px; vertical-align: bottom"></i>
                </div>
                <div class="info-text" style="display: inline-block;padding-right: 15px">
                    @t('settings_info_1')
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <hr style="border-top: 1px solid #414860; padding: 0; margin-bottom: 0">
        </div>

    </div>
    <div class="row form-group">
        <label for="after_tax_prices" class="col-md-12 col-xs-12">@t('after_tax_prices'):</label>
        <div class="col-md-6 col-xs-6">
            <input type="checkbox" name="after_tax_prices" value="1"
                   @if (old('after_tax_prices', auth()->user()->after_tax_prices)) checked
                   @endif data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                   data-on="@t('yes')" data-off="@t('no')">

            @if ($errors->has('after_tax_prices'))
                <b class="help-block">{{ $errors->first('after_tax_prices') }}</b>
            @endif
        </div>
        <div class="col-md-6 col-xs-6 settings-info text-right">
            <div class="row">
                <div class="icon" style="display: inline-block">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px; vertical-align: bottom"></i>
                </div>
                <div class="info-text" style="display: inline-block; padding-right: 15px">
                    @t('settings_info_2')
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <hr style="border-top: 1px solid #414860; padding: 0; margin-bottom: 0">
        </div>
    </div>

    <div class="row form-group">
        <label for="language" class="col-md-12">@t('language_settings'):</label><br>
        <div class="col-md-6">

            <div class="radio-inline">
                <input id="radio-1" class="radio-custom" name="locale" type="radio"
                       value="en" name="locale"
                       @if(auth()->user()->locale == 'en') checked @endif>
                <label for="radio-1" class="radio-custom-label" style="text-transform: capitalize">
                    @t('english') </label>
            </div>
            <div class="radio-inline">
                <input id="radio-2" class="radio-custom" name="locale" type="radio"
                       value="de" name="locale"
                       @if(auth()->user()->locale == 'de') checked @endif>
                <label for="radio-2" class="radio-custom-label" style="text-transform: capitalize">
                    @t('german') </label>
            </div>

        </div>

        <div class="col-md-12">
            <hr style="border-top: 1px solid #414860; padding: 0; margin-bottom: 0">
        </div>
    </div>

    <div class="row form-group form-actions">
        @if(url()->current() !== route('settings.for.mobile'))
            <div class="col-md-6">
                @include('partials.back', ['back' => url()->previous()])
            </div>
        @endif
        <div class="col-md-6 col-xs-12 submit-btn-area ">
            <button type="submit" class="btn btn-settings-custom pull-right save-button-for-mobile">@t('save')</button>
        </div>
    </div>
</form>