@extends('layouts.app')
@section('page-title')
    @t('users')
@stop
@section('styles')
    <style>
        .authorization-icons img {
            max-height: 27px;
            padding-right: 8px;
        }

        .custom-icon-check {
            background-color: #07b8b1;
            width: 26px;
            height: 23px;
            -webkit-mask: url('{{ asset('img/icons/check.png') }}') center center / cover;
            -webkit-mask-size: 100% 100%;
            -webkit-mask-repeat: no-repeat;
            margin: 0 auto;
        }

        .custom-icon-time {
            background-color: #ff4c6a;
            width: 32px;
            height: 30px;
            -webkit-mask: url('{{ asset('img/icons/time.png') }}') center center / cover;
            -webkit-mask-size: 100% 100%;
            -webkit-mask-repeat: no-repeat;
            margin: 0 auto;
        }

    </style>
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
    @if(\App\User::requestCheck('userCreate'))
        <a class="btn-header-mobile-view" style="margin-top: 5px" href="{{ route('users.create') }}">
            <div class="col-xs-12 orange page-top-button-area">
                <div class="col-xs-2 widget-icon-small" style="padding-left:0; padding-right:0">
                    <i class="fa fa-plus-circle text-light-op"></i>
                </div>
                <div class="col-xs-9 col-xs-offset-1" style="padding-left:0; padding-right:0">
                    <h4 class="widget-text text-right">
                        @t('add_new_sub_user')
                    </h4>
                </div>
            </div>
        </a>
    @endif

@stop
@section('content')
    <div class="table-responsive">
        <table class="table table-custom table-vcenter datatable">
            <thead>
            <tr>
                {{--<th class="text-center"></th>--}}
                <th class="{{ hc(0) }}">@tbl('name')</th>
                <th class="{{ hc(1) }}">@tbl('authorization')</th>
                <th class="{{ hc(2) }}">@tbl('email')</th>
                <th class=" {{ hc(3) }}">@tbl('verified')</th>
                @if(\App\User::requestCheck('userCreate'))
                    <th class=" {{ hc(4) }}">@tbl('actions')</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach ($subUsers as $user)
                <tr>
                    {{--<td class="text-center">{{ $loop->index + 1 }}</td>--}}
                    <td data-label="@t('name')">
                        <div class="text-orange capital">
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td data-label="@t('authorization')">
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
                    </td>
                    <td data-label="@t('email')">
                        {{ $user->email }}
                    </td>
                    <td data-label="@t('verified')">
                        @if($user->email_verified_at != null)
                            <div class="custom-icon-check"></div>
                            {{--<img src="{{ asset('img/icons/check.png') }}" alt="" height="20" style="color: #00fdaa">--}}
                        @else
                            <div class="custom-icon-time"></div>
                            <a href="javascript:void(0)" onclick="toggleModal('{{ $user->verification->token }}')">
                                <div class="custom-icon-link"
                                     style="width: 22px; height: 21px; vertical-align: super; cursor: pointer"></div>
                            </a>
                        @endif
                    </td>
                    @if(\App\User::requestCheck('userCreate'))
                        <td data-label="@t('actions')">
                            <a href="{{ route('users.view', $user->id) }}" style="padding-right: 10px">
                                <i class="fa fa-eye" style="color: #ccc"></i>
                            </a>

                            <a href="{{ route('users.edit', $user->id) }}">
                                <i class="fa fa-pencil" style="color: #ccc"></i>
                            </a>

                            {{--<form method="post" action="{{ route('users.destroy', $user->id) }}"--}}
                            {{--style="display:inline-block">--}}
                            {{--{{ method_field('DELETE') }}--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<a href="javascript:void(0)"--}}
                            {{--onclick="if(confirm('Are you sure?')){$(this).closest('form').submit()}"--}}
                            {{--class="btn btn-danger">--}}
                            {{--<i class="fa fa-trash"></i>--}}
                            {{--</a>--}}
                            {{--</form>--}}
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')

    @include('users.alert-modal')

    <script>
        function toggleModal(token) {
            $('#verificationToken').val(token)
            $('#logOutAlert').modal('toggle');
        }

        function goToVerificationLink() {
            let token = $('#verificationToken').val();
            let url = '{{ url('logout-and-verify') }}' + '/' + token;
            window.open(url, '_self')
        }

        UiTables.init({
            columnDefs: [{orderable: false, targets: [1, 2]}],
            drawCallback: function () {
                $('.pagination li:not(.disabled)', this.api().table().container())
                    .on('click', function () {
                        shapeTable();
                    });
            }
        });

    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection