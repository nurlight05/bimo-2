    <!-- BEGIN TOPBAR -->
    <div class="topbar">
        <div class="header-left">
            <div class="topnav">
                <a class="menutoggle" href="#" data-toggle="sidebar-collapsed">
                    <span class="menu__handle">
                        <span>Menu</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="header-right">
            <ul class="header-menu nav navbar-nav">
                <li class="dropdown" id="user-header">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img src="{{ asset('assets/images/avatars/user1.png') }}" alt="user image">
                        <span class="username">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="icon-user"></i> <span>My Profile</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="icon-calendar"></i> <span>My Calendar</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="icon-settings"></i> <span>Account Settings</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="icon-logout"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </li>
                <!-- END USER DROPDOWN -->
            </ul>
        </div><!-- header-right -->
    </div>
    <!-- END TOPBAR -->