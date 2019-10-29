<?php
/**
 * page_header.php
 *
 * Author: pixelcave
 *
 * The header of each page
 *
 */
?>
<!-- Header -->
<!-- In the PHP version you can set the following options from inc/config file -->
<!--
    Available header.navbar classes:

    'navbar-default'            for the default light header
    'navbar-inverse'            for an alternative dark header

    'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
        'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

    'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
        'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
-->
<header class="navbar navbar-default navbar-fixed-top">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" id="sidebar-logo-toggle" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                <div id="mini-logo-width">
                    <img src="{{ asset('img/logo.png') }}" alt="logo.png" class="img-responsive" id="mini-logo"
                         style="height: 42px; display: none">
                </div>
            </a>
        </li>

        <!-- END Main Sidebar Toggle Button -->
        <img src="{{ asset('img/logo.png') }}" alt="logo.png" class="img-responsive" id="nav-mobile-logo"
             style="height: 47px; left: 75px;padding-top: 6px; display: none; position: absolute">
    <!-- Header Link -->
        {{--<li class="hidden-xs animation-fadeInQuick">
            <a href=""><strong>Link</strong></a>
        </li>--}}
        <!-- END Header Link -->
    </ul>
    <!-- END Left Header Navigation -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <!-- Search Form -->
        {{--<li>
            <form action="page_ready_search_results.php" method="post" class="navbar-form-custom">
                <input type="text" id="top-search" name="top-search" class="form-control" placeholder="@t('search')..">
            </form>
        </li>--}}
        <!-- END Search Form -->

        <!-- Alternative Sidebar Toggle Button -->
        @if (0)
            <li>
                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">
                    <i class="gi gi-settings"></i>
                </a>
            </li>
    @endif
    <!-- END Alternative Sidebar Toggle Button -->

        <!-- User Dropdown -->
        <li class="dropdown" id="rightSideTopDropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ auth()->user()->getAvatar() }}" alt="avatar">
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    <strong>{{ auth()->user()->name }}</strong>
                </li>

                <li>
                    <a href="{{ route('profiles.edit') }}">
                        <i class="fa fa-user fa-fw pull-right"></i>
                        @t('profile')
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.edit') }}">
                        <i class="gi gi-settings fa-fw pull-right"></i>
                        @t('settings')
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="gi gi-user_add fa-fw pull-right"></i>
                        @t('users')
                    </a>
                </li>
                <li>
                    {{--<a href="{{ route('logs') }}">--}}
                        {{--<i class="fa fa-history fa-fw pull-right"></i>--}}
                        {{--@t('logs')--}}
                    {{--</a>--}}
                    <a href="{{ url('logout') }}">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        @t('logout')
                    </a>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>
<!-- END Header -->
