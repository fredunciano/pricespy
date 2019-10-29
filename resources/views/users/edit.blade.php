@extends('layouts.app')
@section('page-title')
    @t('edit_sub_user')
@stop
@section('styles')
    <style>
        label {
            text-transform: uppercase;
            color: #818594;
            font-size: 13px;
        }

        .authorization-div {
            border-right: 1px solid;
            border-right-color: #414860;
        }

        @media screen and  (max-width: 767px) {
            .submit-btn-area {
                text-align: center !important;
            }

            .authorization-div {
                border-bottom: 2px solid;
                border-bottom-color: #414860;
                margin-bottom: 10px;
                border-right: none;
            }

            .authorization-div label {
                min-height: 40px;
            }

            label {
                font-size: 11px;
            }
        }
    </style>
@stop
@section('content')
    <div class="row">
        <form action="{{ url()->current() }}" method="post">
            <div class="col-md-10 col-md-offset-1">
                @csrf
                <input type="hidden" name="permission_id" value="{{ $userData->permissions->id }}">

                <div class="row">
                    <div class="col-md-12">
                        <h5 style="color: white; text-transform: uppercase;">@t('personal'):</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">@t('first_name')</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John"
                                   minlength="2" maxlength="100" value="{{ old('first_name', $userData->first_name) }}">
                            @if ($errors->has('first_name'))
                                <b class="help-block">{{ $errors->first('first_name') }}</b>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">@t('last_name')</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe"
                                   minlength="2" maxlength="100" value="{{ old('last_name', $userData->last_name) }}">
                            @if ($errors->has('last_name'))
                                <b class="help-block">{{ $errors->first('last_name') }}</b>
                            @endif
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">@t('email')</label>
                            <input type="email" id="email" name="email" class="form-control"
                                   placeholder="janedoe@email.com" disabled
                                   value="{{ old('email', $userData->email) }}">
                            @if ($errors->has('email'))
                                <b class="help-block">{{ $errors->first('email') }}</b>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5 style="color: white; text-transform: uppercase;">@t('authorization'):</h5>
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <div class="col-md-12 col-xs-4 authorization-div" style="padding-left: 0;">

                            <label for="add_product">@t('add_product'):</label>
                            <br>
                            <input type="checkbox" id="add_product"
                                   name="add_product" value="1"
                                   @if(old('add_product', $userData->permissions->add_product)) checked @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >

                            <br>
                            <br>
                        </div>

                        <div class="col-md-12 col-xs-4 authorization-div" style="padding-left: 0;">

                            <label for="edit_product">@t('edit_product'):</label>
                            <br>
                            <input type="checkbox" id="edit_product"
                                   name="edit_product" value="1"
                                   @if(old('edit_product', $userData->permissions->edit_product)) checked @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>

                        <div class="col-md-12 col-xs-4 authorization-div" style="padding-left: 0;">

                            <label for="delete_product">@t('delete_product'):</label>
                            <br>
                            <input type="checkbox" id="delete_product"
                                   name="delete_product" value="1"
                                   @if(old('delete_product', $userData->permissions->delete_product)) checked @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-12">

                        <div class="col-md-12 col-xs-4 authorization-div" style="padding-left: 0;">

                            <label for="add_competitor">@t('add_competitor'):</label>
                            <br>
                            <input type="checkbox" id="add_competitor"
                                   name="add_competitor" value="1"
                                   @if(old('add_competitor', $userData->permissions->add_competitor)) checked @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>

                        <div class="col-md-12 col-xs-4 authorization-div" style="padding-left: 0;">

                            <label for="edit_competitor">@t('edit_competitor'):</label>
                            <br>
                            <input type="checkbox" id="edit_competitor"
                                   name="edit_competitor" value="1"
                                   @if(old('edit_competitor', $userData->permissions->edit_competitor)) checked @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>

                        <div class="col-md-12 col-xs-4 authorization-div" style="padding-left: 0;">
                            <label for="delete_competitor">@t('delete_competitor'):</label>
                            <br>
                            <input type="checkbox" id="delete_competitor"
                                   name="delete_competitor" value="1"
                                   @if(old('delete_competitor', $userData->permissions->delete_competitor)) checked
                                   @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-12">

                        <div class="col-md-12 col-xs-4" style="padding-left: 0;">

                            <label for="add_new_sub_user">@t('add_new_sub_user'):</label>
                            <br>
                            <input type="checkbox" id="add_new_sub_user"
                                   name="add_new_sub_user" value="1"
                                   @if(old('add_new_sub_user', $userData->permissions->add_new_sub_user)) checked @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>

                        <div class="col-md-12 col-xs-4" style="padding-left: 0;">
                            <label for="view_invoice_and_payment_system">@t('view_invoice_and_payment_system'):</label>
                            <br>
                            <input type="checkbox" id="view_invoice_and_payment_system"
                                   name="view_invoice_and_payment_system" value="1"
                                   @if(old('view_invoice_and_payment_system', $userData->permissions->view_invoice_and_payment_system)) checked
                                   @endif
                                   class="form-group"
                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                   data-on="@t('yes')" data-off="@t('no')"
                            >
                            <br>
                            <br>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 row">
                <div class="row form-group form-actions">

                    <div class="col-md-6" id="back-button">
                        @include('partials.back', ['back' => url()->previous()])
                    </div>

                    <div class="col-md-6 col-xs-12 submit-btn-area">
                        <button type="submit" class="btn btn-settings-custom pull-right">@t('send_and_save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        window.isSubmitting = false;
        if ($(window).width() < 767) {
            $('.btn-settings-custom').removeClass('pull-right').css('text-align', 'center')
            $('#back-button').css('visibility', 'hidden')
        }
    </script>
@endsection