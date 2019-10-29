@extends('layouts.app')

@section('styles')
    <style>
        .form-group label {
            text-transform: uppercase;
            color: #818594;
        }

        .hover-on-icon:hover {
            cursor: pointer;
        }

        .block {
            background: transparent;
        }

        .title-only-for-mobile .fa {
            background: #1a203a;
        }

        .authorization-icons {
            padding-left: 10px;
        }

        .authorization-icons img {
            max-height: 27px;
            padding-right: 8px;
        }

        @media screen and  (max-width: 767px) {
            .submit-btn-area {
                text-align: center !important;
            }

            .settings-info {
                color: #fff;
                font-weight: bold;
                font-family: Roboto, sans-serif;
            }

            .settings-info .fa {
                font-size: 25px;
            }

            .users-section strong {
                text-transform: uppercase;
                padding: 10px;
                font-size: 14px;
            }

            .users-section .col-xs-12 {
                padding-bottom: 10px !important;
            }

            .hr-color-1 {
                border-top: 2px solid #414860;
                margin: 0;
                padding-bottom: 10px;
            }

            .widget {
                padding-top: 10px;
            }

            a.btn.btn-green {
                background: #07b8b1;
                border: #07b8b1;
                width: 175px;
                font-size: 10px;
                display: inline-block;
                text-align: right;
                margin-left: 45px;
                height: 45px;
                -webkit-text-fill-color: #fff !important;
            }

            a.btn.btn-green .fa {
                background: transparent;
                -webkit-text-fill-color: #fff !important;
            }
        }
    </style>
@stop
@section('content')
    <div class="row" id="row-container">

        <div class="title-only-for-mobile" id="profile-title">
            <h3>@t('profile')
                <a class="pull-right"
                ><i class="fa fa-angle-left fa-2x" id="profile-icon"></i>
                </a>
            </h3>
        </div>


        <div class="col-lg-12 hide-div-only-for-mobile" id="profile-content">
            <div class="widget">
                <div class="col-xs-12">
                    @include('profiles.form')
                </div>
            </div>
        </div>


        <div class="title-only-for-mobile" id="settings-title">
            <h3>@t('settings')
                <a class="pull-right">
                    <i class="fa fa-angle-left fa-2x" id="settings-icon"></i>
                </a>
            </h3>
        </div>

        <div class="col-lg-12 hide-div-only-for-mobile" id="settings-content">
            <div class="widget">
                <div class="col-xs-12">
                    @include('settings.form')
                </div>
            </div>
        </div>


        <div class="title-only-for-mobile" id="users-title">
            <h3>
                @t('users')
                @if(\App\User::requestCheck('userCreate'))
                    <a id="user-create-button" class="btn btn-green" href="{{ route('users.create') }}" style="display: none">
                        <div style="display: inline-block; vertical-align: super; padding-right: 10px"><i
                                    class="fa fa-plus-circle fa-2x"></i></div>
                        <div style="display: inline-block;color: #fff!important;">{!! insertBrTagToWords(t('add_new_sub_user')) !!}</div>
                    </a>
                @endif
                <a class="pull-right">
                    <i class="fa fa-angle-left fa-2x" id="users-icon"></i>
                </a>
            </h3>
        </div>

        <div class="col-lg-12 hide-div-only-for-mobile" id="users-content">

            @foreach ($subUsers as $user)
                <div class="widget users-section">
                    <div class="col-xs-12 no-padding">
                        <strong class="text-orange">@t('team_member'):</strong>
                    </div>
                    <div class="col-xs-12 no-padding">
                        <strong class="header-purple" style="text-transform: none">{{ $user->name }}</strong>
                    </div>

                    <div style="padding: 0 10px">
                        <hr class="hr-color-1">
                    </div>

                    <div class="col-xs-12 no-padding">
                        <strong>@t('authorization'):</strong>
                    </div>
                    <div class="col-xs-12 no-padding">
                        <div class="authorization-icons">

                            @if(!$user->permissions->has_any_permission)
                                --
                            @else
                                @if($user->permissions->add_product)
                                    <img src="{{ asset('img/icons/product_add.png') }}"
                                         alt="@t('add_product')" title="@t('add_product')">
                                @endif
                                @if($user->permissions->edit_product)
                                    <img src="{{ asset('img/icons/product_edit.png') }}"
                                         alt="@t('edit_product')" title="@t('edit_product')">
                                @endif
                                @if($user->permissions->delete_product)
                                    <img src="{{ asset('img/icons/product_delete.png') }}"
                                         alt="@t('delete_product')" title="@t('delete_product')">
                                @endif
                                @if($user->permissions->add_competitor)
                                    <img src="{{ asset('img/icons/comp_add.png') }}"
                                         alt="@t('add_competitor')" title="@t('add_competitor')">
                                @endif
                                @if($user->permissions->edit_competitor)
                                    <img src="{{ asset('img/icons/comp_edit.png') }}"
                                         alt="@t('edit_competitor')" title="@t('edit_competitor')">
                                @endif
                                @if($user->permissions->delete_competitor)
                                    <img src="{{ asset('img/icons/comp_delete.png') }}"
                                         alt="@t('delete_competitor')" title="@t('delete_competitor')">
                                @endif
                                @if($user->permissions->add_new_sub_user)
                                    <img src="{{ asset('img/icons/user_add.png') }}"
                                         alt="@t('add_new_sub_user')" title="@t('add_new_sub_user')">
                                @endif
                                @if($user->permissions->view_invoice_and_payment_system)
                                    <img src="{{ asset('img/icons/invoice.png') }}"
                                         alt="@t('view_invoice_and_payment_system')"
                                         title="@t('view_invoice_and_payment_system')"
                                         style="vertical-align: -webkit-baseline-middle">
                                @endif
                            @endif

                        </div>
                    </div>

                    <div style="padding: 0 10px">
                        <hr class="hr-color-1">
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <div class="col-xs-12 no-padding">
                                <strong>@t('email'):</strong>
                            </div>
                            <div class="col-xs-12 no-padding">
                                <strong style="text-transform: none"> {{ $user->email }}</strong>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="col-xs-12 no-padding">
                                <strong>@t('verified'):</strong>
                            </div>
                            <div class="col-xs-12 no-padding" style="padding-left: 5px !important;">
                                @if($user->email_verified_at != null)
                                    <div class="custom-icon-check" style="height: 20px; width: 20px"></div>
                                @else
                                    <div class="custom-icon-time"></div>
                                    <a href="javascript:void(0)"
                                       onclick="toggleModal('{{ $user->verification->token }}')">
                                        <div class="custom-icon-link"
                                             style="width: 22px; height: 21px; vertical-align: super; cursor: pointer"></div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0 10px; margin-top: -10px">
                        <hr class="hr-color-1">
                    </div>

                    <div class="col-xs-12 no-padding">
                        <strong class="text-orange">@t('actions'):</strong>
                    </div>
                    <div class="col-xs-12 no-padding" style="padding-left: 10px !important;">
                        <a href="{{ route('users.view', $user->id) }}" style="padding-right: 10px">
                            <i class="fa fa-eye" style="color: #ccc; font-size: 20px"></i>
                        </a>

                        <a href="{{ route('users.edit', $user->id) }}">
                            <i class="fa fa-pencil" style="color: #ccc; font-size: 20px"></i>
                        </a>
                    </div>

                    <div style="padding: 0 10px">
                        <hr class="hr-color-1">
                    </div>
                </div>
            @endforeach
        </div>


    </div>

@endsection

@section('scripts')
    @include('profiles.scripts')
    @include('settings.scripts')
    @include('users.alert-modal')
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
    <script>
        function toggleModal(token) {
            $('#verificationToken').val(token)
            $('#logOutAlert').modal('toggle');
        }

        $(document).ready(function () {

            $('#profile-title').on('click touch', function () {
                if ($('#profile-content:visible').length) {
                    $('#profile-content').hide("fade", {direction: "up"}, 200);
                    $('#profile-icon').removeClass('fa-angle-down').addClass('fa-angle-left')
                } else {
                    $('#profile-content').show("fade", {direction: "down"}, 500);
                    $('#profile-icon').removeClass('fa-angle-left').addClass('fa-angle-down')
                }
            })
            $('#settings-title').on('click touch', function () {
                if ($('#settings-content:visible').length) {
                    $('#settings-content').hide("fade", {direction: "up"}, 200);
                    $('#settings-icon').removeClass('fa-angle-down').addClass('fa-angle-left')
                } else {
                    $('#settings-content').show("fade", {direction: "down"}, 500);
                    $('#settings-icon').removeClass('fa-angle-left').addClass('fa-angle-down')
                }
            })
            $('#users-title').on('click touch', function () {
                if ($('#users-content:visible').length) {
                    $('#users-content').hide("fade", {direction: "up"}, 200);
                    $('#users-icon').removeClass('fa-angle-down').addClass('fa-angle-left')
                    $('#user-create-button').hide()
                    $('#users-title').css('margin-bottom', '0')
                } else {
                    $('#users-content').show("fade", {direction: "down"}, 500);
                    $('#users-icon').removeClass('fa-angle-left').addClass('fa-angle-down')
                    $('#user-create-button').show()
                    $('#users-title').css('margin-bottom', '30px')
                }
            })


            if ($(window).width() < 767) {
                $('.save-button-for-mobile').removeClass('pull-right')
                $('.settings-info').removeClass('text-right')

                $('.image-delete-label').css('padding-bottom', '10px').css('text-align', 'center')
                $('#avatar-area').css('margin', '0 auto').css('display', 'block')
                $('#country-label').css('width', '100%').css('display', 'block')
                $('.select2-container').css('width', '100%').css('display', 'block')
                $('#settings-form').css('padding-top', '15px')

                $('.icon').addClass('col-xs-2 no-padding');
                $('.info-text').addClass('col-xs-10 no-padding').removeAttr('style');
            }
        });
    </script>
@stop