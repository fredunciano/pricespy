<form action="{{ route('profiles.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    {!! method_field('PATCH') !!}

    <div class="form-group row">
        <h5 class="custom-header">@t('personal'):</h5>

        <div class="col-md-1 col-xs-12 pull-right">

            @if (auth()->user()->avatar)
                <label for="avatar" id="avatar-area">
                    <img id="image" src="{{ storage()->url(auth()->user()->avatar) }}" alt=""
                         style="width: 90px; display: block; margin: auto auto" class="img-responsive">
                </label>
                <div class="control-label image-delete-label">
                    <input value="1" type="checkbox" name="delete-avatar"> @tl('delete_existing_avatar')
                </div>
            @else
                <label for="avatar" id="avatar-area">
                    <img id="image" src="{{ asset('img/user.png') }}" alt=""
                         style="width: 90px; display: block; margin: auto auto" class="img-responsive">
                </label>
            @endif

            <input type="file" id="avatar" class="form-control" value="{{ old('avatar') }}" name="avatar"
                   accept="image/*"
                   onchange="readURL(this);"
                   style="display: none">

            @if ($errors->has('avatar'))
                <div class="alert-danger">{{ $errors->first('avatar') }}</div>
            @endif
        </div>

        <div class="col-md-11 col-xs-12" style="padding-left: 0">

            <div class="col-md-4">
                <label for="first_name">@t('first_name')</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John"
                       minlength="2" maxlength="100"
                       value="{{ old('first_name', auth()->user()->first_name) }}">
                @if ($errors->has('first_name'))
                    <b class="help-block">{{ $errors->first('first_name') }}</b>
                @endif
            </div>

            <div class="col-md-4">
                <label for="last_name">@t('last_name')</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe"
                       minlength="2" maxlength="100"
                       value="{{ old('last_name', auth()->user()->last_name) }}">
                @if ($errors->has('last_name'))
                    <b class="help-block">{{ $errors->first('last_name') }}</b>
                @endif
            </div>

            <div class="col-md-4">
                <label for="email">@t('email')</label>
                <input type="text" id="email" name="email" class="form-control"
                       placeholder="test@mail.com"
                       minlength="2" maxlength="100" value="{{ old('email', auth()->user()->email) }}">
                @if ($errors->has('email'))
                    <b class="help-block">{{ $errors->first('email') }}</b>
                @endif
            </div>
        </div>

        <div class="col-md-12">
            <hr style="border-top: 1px solid #414860; padding: 0; margin-bottom: 0">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-11" style="padding-left: 0">
            <h5 class="custom-header">@t('company'):</h5>

            <div class="col-md-4">
                <label for="company">@t('company')</label>
                <input type="text" id="company" name="company" class="form-control"
                       placeholder="@t('company_gmbh')"
                       minlength="2" maxlength="100" value="{{ old('company', auth()->user()->company) }}">
                @if ($errors->has('company'))
                    <b class="help-block">{{ $errors->first('company') }}</b>
                @endif
            </div>

            <div class="col-md-4">
                <label for="street">@t('street')</label>
                <input type="text" id="street" name="street" value="{{ auth()->user()->street }}"
                       placeholder="@t('Street_No')"
                       class="form-control">
            </div>

            <div class="col-md-4">
                <label for="house_number">@t('house_number')</label>
                <input type="text" id="house_number" name="house_number"
                       placeholder="45 b"
                       value="{{ auth()->user()->house_number }}" class="form-control">
            </div>
        </div>

        <div class="col-md-11" style="padding-left: 0; margin-top: 10px">
            <div class="col-md-4">
                <label for="postal_code">@t('postal_code')</label>
                <input type="text" id="postal_code" name="postal_code"
                       value="{{ auth()->user()->postal_code }}" placeholder="54125"
                       class="form-control">
            </div>

            <div class="col-md-4">
                <label for="place">@t('place')</label>
                <input type="text" id="place" name="place" value="{{ auth()->user()->place }}"
                       placeholder="Frankfurt a. M."
                       class="form-control">
            </div>

            <div class="col-md-4">
                <label for="address">@t('address')</label>
                <input type="text" id="address" name="address" value="{{ auth()->user()->address }}"
                       placeholder="Gebäude H"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-11" style="padding-left: 0; margin-top: 10px">
            <div class="col-md-4 col-xs-12">
                <label for="country" id="country-label">@t('country')</label>
                <select name="country_id" class="form-control" id="country">
                    <option value="">@t('Please Select')</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                                @if(auth()->user()->country_id == $country->id) selected @endif>
                            @if(strtolower($country->name) == 'germany') {{ t('germany') }} @else {{ $country->name }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <hr style="border-top: 1px solid #414860; padding: 0; margin-bottom: 0">
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-11" style="padding-left: 0">
            <h5 class="custom-header">@t('password'):</h5>

            <div class="col-md-4">
                <label for="current_password">@t('current_password')</label>
                <input type="password" id="current_password" name="current_password" class="form-control"
                       placeholder="******">
                @if ($errors->has('current_password'))
                    <b class="help-block">{{ $errors->first('current_password') }}</b>
                @endif
            </div>

            <div class="col-md-4 password">
                <label for="password">@t('new_password')</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="*******">
                @if ($errors->has('password'))
                    <b class="help-block">{{ $errors->first('password') }}</b>
                @endif
                <div id="result"></div>
            </div>

            <div class="col-md-4 password">
                <label for="password_confirmation">@t('confirm_new_password')</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                       placeholder="******">
                @if ($errors->has('password_confirmation'))
                    <b class="help-block">{{ $errors->first('password_confirmation') }}</b>
                @endif
                <div id="passwordMatch"></div>
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
        <div class="col-md-6 col-xs-12 submit-btn-area">
            <button type="submit" class="btn btn-settings-custom pull-right save-button-for-mobile">@t('save')
            </button>
        </div>
    </div>
</form>