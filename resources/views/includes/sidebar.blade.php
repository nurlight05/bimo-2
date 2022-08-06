<div class="sidebar">
    <div class="logopanel">
        <h1>
            <a href="dashboard.html"></a>
        </h1>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-top">
            <form action="search-result.html" method="post" class="searchform" id="search-results">
                <input type="text" class="form-control" name="keyword" placeholder="Search...">
            </form>
        </div>
        <div class="menu-title">
            Навигация
            <div class="pull-right menu-settings">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                    data-close-others="true" data-delay="300">
                    <i class="icon-settings"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" id="reorder-menu" class="reorder-menu">Reorder menu</a></li>
                    <li><a href="#" id="remove-menu" class="remove-menu">Remove elements</a></li>
                    <li><a href="#" id="hide-top-sidebar" class="hide-top-sidebar">Hide user &amp; search</a>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="nav nav-sidebar">
            <li class="@yield('home-active')"><a href="dashboard.html"><i class="icon-home"></i><span
                        data-translate="dashboard">Dashboard</span></a></li>
            <li class="nav-parent @yield('suppliers-active')">
                <a href="#">
                    <i class="icon-puzzle"></i>
                    <span data-translate="builder">Поставщики</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="children collapse">
                    <li class="@yield('suppliers-all-active')">
                        <a href="{{ route('suppliers') }}">Все поставики</a>
                    </li>
                </ul>
            </li>
            <li class="nav-parent @yield('products-active')">
                <a href="#">
                    <i class="icon-puzzle"></i>
                    <span data-translate="builder">Товары</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="children collapse">
                    <li class="@yield('products-all-active')">
                        <a href="{{ route('products') }}">Все товары</a>
                    </li>
                </ul>
            </li>
            <li class="@yield('warehouse-active')">
                <a href="{{ route('warehouse') }}">
                    <i class="icon-puzzle"></i>
                    <span data-translate="builder">
                        Склад
                    </span>
                </a>
            </li>
            <li class="@yield('orders-active')">
                <a href="{{ route('orders') }}">
                    <i class="icon-puzzle"></i>
                    <span data-translate="builder">
                        Заказы
                    </span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer clearfix">
            <a class="pull-left footer-settings" href="#" data-rel="tooltip" data-placement="top"
                data-original-title="Settings">
                <i class="icon-settings"></i></a>
            <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top"
                data-original-title="Fullscreen">
                <i class="icon-size-fullscreen"></i></a>
            <a class="pull-left" href="#" data-rel="tooltip" data-placement="top"
                data-original-title="Lockscreen">
                <i class="icon-lock"></i></a>
            <a class="pull-left btn-effect" href="#" data-modal="modal-1" data-rel="tooltip"
                data-placement="top" data-original-title="Logout">
                <i class="icon-power"></i></a>
        </div>
    </div>
</div>