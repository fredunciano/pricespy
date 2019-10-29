<?php
/**
 * page_sidebar.php
 *
 * Author: pixelcave
 *
 * The main sidebar of each page
 *
 */
?>
<!-- Main Sidebar -->
<div id="sidebar">
    <!-- Sidebar Brand -->
    <div id="sidebar-brand" class="themed-background">
        <a href="/" class="sidebar-title">
            {{--<i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide"><strong> PriceSpy</strong></span>--}}

            <img src="{{ asset('img/logo.png') }}" alt="logo.png" class="img-responsive" style="max-height: 45px">

        </a>
    </div>
    <!-- END Sidebar Brand -->
    <div id="mobile-sidebar-user-section" style="display: none">
        <div class="user-image-section">
            <img src="{{ auth()->user()->getAvatar() }}" alt="avatar" style="width: 50px">
        </div>
        <div class="user-info-section">
            <b>{{ auth()->user()->name }}</b>
            <div class="button-group">
                <button class="btn btn-success-custom "
                        style="display: inline-block; min-height: 25px; min-width: 35px; padding: 3px 6px; border-radius: 1px; font-size: 11px">
                    CHAT <i class="fa fa-comment"></i>
                </button>
                <button class="btn btn-success-custom"
                        style="display: inline-block;min-height: 25px; min-width: 35px; color: #10B7B0; padding: 3px 6px; border-radius: 1px; font-size: 11px">
                    PREMIUM <i class="fa fa-diamond"></i>
                </button>
            </div>
        </div>

        <hr class="hr-color">
    </div>
    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
        @php $menu = getMenu(); @endphp
        @if ($menu)

            <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    @foreach ($menu as $key => $link)
                        @if (isset($link['url']) && $link['url'] === 'separator')
                            <li class="sidebar-separator">
                                <i class="fa fa-ellipsis-h"></i>
                            </li>
                        @else
                            <?php
                            if (isset($link['sub'])) {
                                $routes = array_map(function ($sub) use ($link) {
                                    return +routeHas($sub['route'], isset($link['contains']) ? $link['contains'] : true);
                                }, $link['sub']);
                                $active = array_sum($routes) > 0;
                            } else {
                                $toContain = $link['group'] ?? $link['route'];
                                $active = routeHas($toContain, $link['contains'] ?? true);
                            }
                            ?>

                            <li @if ($active) class="active" @endif
                            @if((isset($link['sub']) ? '#' : url($link['url'])) == url('/settings-for-mobile')) id="mobile-settings-nav" style="display: none" @endif
                            >
                                <a href="{{ isset($link['sub']) ? '#' : url($link['url']) }}"
                                   @if (isset($link['sub'])) class="sidebar-nav-menu" @endif>
                                    @if (isset($link['sub']))
                                        <i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                                    @endif
                                    <i class="{{ $link['icon'] }} sidebar-nav-icon"></i>
                                    <span class="sidebar-nav-mini-hide">{{ $link['name'] }}</span>
                                </a>
                                @if (isset($link['sub']))
                                    <ul>
                                        @foreach ($link['sub'] as $sub)
                                            <li
                                                @if(url($sub['url']) == url('products/bulk-upload')) id="desktop-settings-nav" style="display: block" @endif
                                                @if (routeHas($sub['route'], isset($sub['contains']) ? $sub['contains'] : true)) class="active" @endif
                                            >
                                                <a href="{{ isset($sub['sub']) ? '#' : url($sub['url']) }}">
                                                    @if (isset($sub['sub']))
                                                        <i class="fa fa-chevron-left sidebar-nav-indicator"></i>
                                                    @endif
                                                    {{ $sub['name'] }}
                                                </a>
                                                @if (0)
                                                    <?php if (isset($sub_link['sub']) && $sub_link['sub']) { ?>
                                                    <ul>
                                                        <?php foreach ($sub_link['sub'] as $sub2_link) {
                                                        // Get 3rd level link's vital info
                                                        $url = (isset($sub2_link['url']) && $sub2_link['url']) ? $sub2_link['url'] : '#';
                                                        $active = (isset($sub2_link['url']) && ($template['active_page'] == $sub2_link['url'])) ? ' class="active"' : '';
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo $url; ?>"<?php echo $active ?>><?php echo $sub2_link['name']; ?></a>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php } ?>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!-- END Sidebar Navigation -->
        @endif

        <!-- Color Themes -->

        </div>
        <!-- END Sidebar Content -->
        <div id="mobile-logout-option" style="display: none">
            <hr class="hr-color">

            <a href="{{ url('logout') }}" style="color: #ccc;">
                <i class="fa fa-power-off fa-fw pull-left" style="padding-top: 5px"></i>
                <b>@t('logout')</b>
            </a>
            <div class="pull-right" id="user-locale" style="display: none">
                <a href="@if(auth()->user()->locale == 'en') javascript:void(0) @else {{ route('update.locale', ['locale' => 'en']) }} @endif">
                    <img src="{{ asset('img/icons/en.png') }}" height="24"
                         style="padding-right: 5px; opacity: @if(auth()->user()->locale == 'en') 1 @else 0.3 @endif"
                         alt="en">
                </a>
                <a href="@if(auth()->user()->locale == 'de') javascript:void(0) @else {{ route('update.locale', ['locale' => 'de']) }} @endif">
                    <img src="{{ asset('img/icons/de.png') }}" height="24"
                         style="opacity: @if(auth()->user()->locale == 'de') 1 @else 0.3 @endif"
                         alt="de">
                </a>
            </div>
        </div>
    </div>

    <!-- END Wrapper for scrolling functionality -->

    <!-- Sidebar Extra Info -->
    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">

        <div style="display: block" id="user-locale-desktop">
            <a href="@if(auth()->user()->locale == 'en') javascript:void(0) @else {{ route('update.locale', ['locale' => 'en']) }} @endif">
                <img src="{{ asset('img/icons/en.png') }}" height="24"
                     style="padding-right: 5px; opacity: @if(auth()->user()->locale == 'en') 1 @else 0.3 @endif"
                     alt="en">
            </a>
            <a href="@if(auth()->user()->locale == 'de') javascript:void(0) @else {{ route('update.locale', ['locale' => 'de']) }} @endif">
                <img src="{{ asset('img/icons/de.png') }}" height="24"
                     style="opacity: @if(auth()->user()->locale == 'de') 1 @else 0.3 @endif"
                     alt="de">
            </a>
        </div>

    </div>
    <!-- END Sidebar Extra Info -->
</div>
<!-- END Main Sidebar -->
