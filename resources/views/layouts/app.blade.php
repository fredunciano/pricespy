<!DOCTYPE html>
<html class="no-js" lang="en">
{{--<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->--}}
<head>
    <?php
    /*    $template = config('template.template');
        */?>
    <meta charset="utf-8">

    <title>PriceFeed</title>

    <meta name="description" content="PriceSpy">
    <meta name="author" content="Nierra">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="/img/nfavicon.png">
    <link rel="apple-touch-icon" href="/img/icon57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="/img/icon72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="/img/icon76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="/img/icon114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="/img/icon120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="/img/icon144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="/img/icon152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="/img/icon180.png" sizes="180x180">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="/css/plugins.css">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->

    <link rel="stylesheet"
          href="{{ asset('css/bootstrap-select.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">--}}

<!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
    <link rel="stylesheet" href="/css/themes.css">
    <!-- END Stylesheets -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>

    <link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified JavaScript -->
    <!-- Start of Async Drift Code -->
    {{--HIDES SIDEBAR FOR ONLY CHARTS ON WINDOW--}}
    @if((url()->current() != route('statistics.category.percentage.difference')) && (url()->current() != route('statistics.priceDifferenceByCategory.index')))
        <script>
            "use strict";

            !function () {
                var t = window.driftt = window.drift = window.driftt || [];
                if (!t.init) {
                    if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
                    t.invoked = !0, t.methods = ["identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on"],
                        t.factory = function (e) {
                            return function () {
                                var n = Array.prototype.slice.call(arguments);
                                return n.unshift(e), t.push(n), t;
                            };
                        }, t.methods.forEach(function (e) {
                        t[e] = t.factory(e);
                    }), t.load = function (t) {
                        var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
                        o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
                        var i = document.getElementsByTagName("script")[0];
                        i.parentNode.insertBefore(o, i);
                    };
                }
            }();
            drift.SNIPPET_VERSION = '0.3.1';
            drift.load('att5pv7usktc');
        </script>
@endif
<!-- End of Async Drift Code -->
{{--<link rel="stylesheet" href="/css/bootstrap-select.min.css" />--}}

@yield('styles')

<!-- Modernizr (browser feature detection library) -->
    <script src="/js/vendor/modernizr-3.3.1.min.js"></script>

    <script>
        var baseurl = '{{ url('/') }}'
        var envLang = '{!! auth()->user()->locale !!}'
        var isSubmitting = true;
    </script>

</head>
<body>

<div id="page-wrapper">
    {{--
        <div class="preloader">
            <div class="inner">
                <div class="preloader-spinner themed-background hidden-lt-ie10"></div>

                <h3 class="text-primary visible-lt-ie10"><strong>Laden..</strong></h3>
            </div>
        </div>
    --}}

    <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">

        {{--HIDES SIDEBAR FOR ONLY CHARTS ON WINDOW--}}
        @if((url()->current() != route('statistics.category.percentage.difference')) && (url()->current() != route('statistics.priceDifferenceByCategory.index')))
            @include('layouts.partials.sidebar')
        @endif

        <div id="main-container">
            @if((url()->current() != route('statistics.category.percentage.difference')) && (url()->current() != route('statistics.priceDifferenceByCategory.index')))
                @include('layouts.partials.header');
            @endif
            <div id="page-content" class="widget">
                @hasSection('page-title')
                    <div class="row page-head">
                        <div class="col-md-12">
                            <h1 class="page-head-title">@yield('page-title')</h1>
                            @hasSection('page-button')
                                <div class="pull-right mt20">
                                    @yield('page-button')
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    @yield('page-head')
                @endif
                @yield('actions')
                @include('partials.alerts')
                <div class="block full">
                    @yield('content')
                </div>
                @yield('content-custom')
                <div class="row mb20">
                    <div class="col-md-12">
                        @yield('actions-bottom')
                    </div>
                </div>
            </div>
            @includeIf("layouts.partials.footer")
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/vendor/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/plugins.js"></script>
<script type="text/javascript" src="/js/template.js"></script>
<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
<script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('js/bootstrap-select.min.js') }}"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>--}}


@yield('scripts')

<!-- place this script tag after the Drift embed tag -->
<script>
    (function () {

        var DRIFT_CHAT_SELECTOR = '.drift-open-chat'

        function ready(fn) {
            if (document.readyState != 'loading') {
                fn();
            } else if (document.addEventListener) {
                document.addEventListener('DOMContentLoaded', fn);
            } else {
                document.attachEvent('onreadystatechange', function () {
                    if (document.readyState != 'loading')
                        fn();
                });
            }
        }

        function forEachElement(selector, fn) {
            var elements = document.querySelectorAll(selector);
            for (var i = 0; i < elements.length; i++)
                fn(elements[i], i);
        }

        function openSidebar(driftApi, event) {
            event.preventDefault();
            driftApi.sidebar.open();
            return false;
        }

        ready(function () {
            drift.on('ready', function (api) {
                var handleClick = openSidebar.bind(this, api)
                forEachElement(DRIFT_CHAT_SELECTOR, function (el) {
                    el.addEventListener('click', handleClick);
                });

                api.widget.hide()

                if (window.innerWidth >= 780) {
                    api.widget.show()
                }
            });
        });
    })();
    //change scroller position to left after paginate
    $(document).on("click", "li a", function () {
        $(".datatable").scrollLeft(0)
    })
</script>
</body>
</html>