<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>PriceFeed</title>

    <meta name="description" content="PriceSpy">
    <meta name="author" content="Nierra">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="css/plugins.css">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="css/app.css">

    <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

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
    <script src="js/vendor/modernizr-3.3.1.min.js"></script>
</head>
<body class="background">
<!-- Login Container -->
<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <img src="{{ asset('img/logo_mini.png') }}" height="40" alt=""> <strong style="font-size: 28px">@tl('welcome-to') {{ config('template.template.name') }}</strong>
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
            <h2>@t('sign-in')</h2>
{{--            {{dd($errors)}}--}}
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


    <!-- Login Form -->
        <form id="form-login" action="{{ route('login') }}" method="post" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text" id="login-email" name="email" class="form-control" placeholder="@t('email')"
                           value="{{ old('email') }}" tabindex="1" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" id="login-password" name="password" class="form-control"
                           placeholder="@t('password')" tabindex="2" required>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-8">
                    <label class="csscheckbox csscheckbox-primary">
                        <input type="checkbox" id="login-remember-me"
                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span></span>
                    </label>
                    <span style="padding-left:5px;" class="pointer" onkeydown="remember(event)" onclick="remember()"
                          tabindex="3">@tl('remember-me')</span>
                </div>
                <div class="col-xs-4 text-right">
                    <button type="submit" class="btn btn-effect-ripple btn-sm btn-success" tabindex="4">@t('sign-in')
                    </button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->
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
<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/app.js"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyLogin.js"></script>
<script>$(function () {
        ReadyLogin.init();
    });</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"
        integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script>
    function remember(event) {
        if (typeof event === 'undefined' || event.which === 32) {
            $('#login-remember-me').click()
        }
    }

    (function () {
        var minutes = true;
        var interval = minutes ? 60000 : 1000;
        var IDLE_TIMEOUT = 10; // 10 minutes
        var idleCounter = 0;

        document.onmousemove = document.onkeypress = function () {
            idleCounter = 0;
        };

        window.setInterval(function () {
            if (++idleCounter >= IDLE_TIMEOUT) {
                window.location.reload(); // or whatever you want to do
                console.log('session_expired')
            }
        }, interval);
    }());

    window.startTime = moment().format("DD/MM/YYYY HH:mm:ss");

    window.setInterval(function () {
        var now = moment().format("DD/MM/YYYY HH:mm:ss");
        var difference = moment.utc(moment(now, "DD/MM/YYYY HH:mm:ss").diff(moment(window.startTime, "DD/MM/YYYY HH:mm:ss"))).format("m");
        if (parseInt(difference) > 10) {
            console.log(startTime, now, difference, 'expired')
            window.location.reload()
        } else {
            console.log(startTime, now, difference, 'not-yet')
        }
    }, 60000 * 5)
</script>
</body>
</html>