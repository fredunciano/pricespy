<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>PriceSpy</title>

    <meta name="description" content="PriceSpy">
    <meta name="author" content="Nierra">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('') }}img/favicon.png">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ asset('') }}img/icon180.png" sizes="180x180">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="{{ asset('') }}css/bootstrap.min.css">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="{{ asset('') }}css/plugins.css">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="{{ asset('') }}css/app.css">

<!-- Include a specific file here from {{ asset('') }}css/themes/ folder to alter the default theme of the template -->

    <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
    <!-- END Stylesheets -->
{{--    <style>
        .btn-primary {
            border-color: darkcyan;
            background-color: darkcyan;
        }
        .text-primary, .text-primary:hover, a, a:hover, a:focus, a.text-primary, a.text-primary:hover, a.text-primary:focus {
            color: darkcyan;
        }
        .csscheckbox-primary input:checked + span:after {
            background-color: darkcyan;
        }
        .pointer {
            cursor: pointer;
        }
    </style>--}}

<!-- Modernizr (browser feature detection library) -->
    <script src="{{ asset('') }}js/vendor/modernizr-3.3.1.min.js"></script>
</head>
<body class="background">
<!-- Login Container -->
<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <i class="fa fa-cube"></i> <strong>@tl('welcome-to') {{ config('template.template.name') }}</strong>
    </h1>
    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuickInv">
        <!-- Login Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <!--a href="page_ready_reminder.html" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Forgot your password?"><i class="fa fa-exclamation-circle"></i></a>
                <a href="page_ready_register.html" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Create new account"><i class="fa fa-plus"></i></a-->
            </div>
            <h2>@t('set_password')</h2>
            @if (count($errors))
                <ul class="list-group">
                    @foreach($errors->all() as $error)
                        <li class="list-group-item" style="color: #1a203a">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!-- END Login Title -->

        @if (session('status'))
            <div style="margin: 20px 0;padding: 20px; background: #2ea8cf; color: #1a203a">
                {{ session('status') }}
            </div>
        @endif
        @if (session('warning'))
            <div style="margin: 20px 0;padding: 20px; background: #cc4444; color: #ccc">
                {{ session('warning') }}
            </div>
        @endif


        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" role="form" method="POST"
              action="{{ route('password.set') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} password">
                <label for="password" class="col-md-4 control-label">@t('password')</label>

                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @t('password_strength'): <b id="result">N/A</b>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} password">
                <label for="password-confirm" class="col-md-4 control-label">@t('confirm_password')</label>
                <div class="col-md-8">
                    <input id="password_confirmation" type="password" class="form-control"
                           name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                    <div id="passwordMatch"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        @t('Set Password')
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- END Login Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        <small><span id="year-copy"></span>
            &copy; {{ config('template.template.name') }} {{ config('template.template.version') }}</small>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Login Container -->

<!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
<script src="{{ asset('') }}js/vendor/jquery-2.2.4.min.js"></script>
<script src="{{ asset('') }}js/vendor/bootstrap.min.js"></script>
<script src="{{ asset('') }}js/plugins.js"></script>
<script src="{{ asset('') }}js/app.js"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="{{ asset('') }}js/pages/readyLogin.js"></script>
<script>$(function () {
        ReadyLogin.init();
    });</script>

<style>
    .password .short {
        color: #FF0000;
    }

    .password .weak {
        color: #E66C2C;
    }

    .password .good {
        color: #2D98F3;
    }

    .password .strong {
        color: #006400;
    }
</style>
<script>
    $(document).ready(function () {

        let password = $('#password');

        password.keyup(function () {
            $('#result').html(checkStrength(password.val()))
        })

        $('#password, #password_confirmation').keyup(checkPasswordMatch);

        function checkStrength(password) {
            //initial strength
            var strength = 0

            let result = $('#result');

            //if the password length is less than 6, return message.
            if (password.length < 5) {
                result.removeAttr('class')
                result.addClass('short')
                return '{{ t('Too short') }}'
            }

            //length is ok, lets continue.

            //if length is 8 characters or more, increase strength value
            if (password.length > 5) strength += 1
            //if password contains both lower and uppercase characters, increase strength value
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
            //if it has numbers and characters, increase strength value
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
            //if it has one special character, increase strength value
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
            //if it has two special characters, increase strength value
            if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
            //now we have calculated strength value, we can return messages

            //if value is less than 2
            result.removeAttr('class')
            if (strength < 2) {
                result.addClass('weak')
                return '{{ t('Weak') }}'
            } else if (strength === 2) {
                result.addClass('good')
                return '{{ t('Good') }}'
            } else {
                result.addClass('strong')
                return '{{ t('Strong') }}'
            }
        }

        function checkPasswordMatch() {
            let password = $('#password').val();
            let confirmPassword = $('#password_confirmation').val();

            if (password.length === 0 || confirmPassword.length === 0) {
                $("#passwordMatch").hide();
                return false
            }

            if (password != confirmPassword)
                $("#passwordMatch").show().removeAttr('class').addClass('weak').html("{{ t('Please confirm password.') }}");
            else
                $("#passwordMatch").show().removeAttr('class').addClass('good').html("{{ t('Passwords matched.') }}");
        }
    });
</script>
</body>
</html>

