<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div style="height: 64px" class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" style="background-color: #017FFF" href="{{ route('dashboard') }}">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    {{-- <img src="{{ asset('xtreme-admin/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" /> --}}
                    <img style="margin-right: 10px;width: 45px" src="https://divineshop.vn/assets/resources/logo_divine_pure_white.png" alt="homepage" class="light-logo" />
                    <!-- Light Logo icon -->
                    {{-- <img src="{{ asset('xtreme-admin/assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" /> --}}
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                     <!-- dark Logo text -->
                     <img style="width: 100px;" src="https://divineshop.vn/assets/resources/logo-divineshop.png" alt="homepage" class="light-logo" />
                     <!-- Light Logo text -->
                     {{-- <img src="{{ asset('xtreme-admin/assets/images/logo-light-text.png') }}" class="light-logo" alt="homepage" /> --}}
                </span>
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                <!-- ============================================================== -->

            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="https://thumbs.dreamstime.com/b/user-icon-person-black-symbol-human-avatar-silhouette-admin-profile-picture-illustration-vector-isolated-white-203619043.jpg" alt="user" class="rounded-circle" width="45" height="45"></a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <span class="with-arrow"><span class="bg-primary"></span></span>
                        <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                            <div class=""><img src="https://thumbs.dreamstime.com/b/user-icon-person-black-symbol-human-avatar-silhouette-admin-profile-picture-illustration-vector-isolated-white-203619043.jpg" alt="user" class="img-circle" width="60" height="60" style="border-radius: 50%"></div>
                            <div class="m-l-10">
                                @if(\Auth::user())
                                    <h4 class="m-b-0">{{ \Auth::user()->name }}</h4>
                                    <p class=" m-b-0">{{ \Auth::user()->email }}</p>
                                @endif
                            </div>
                        </div>
                        {{--  <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>  --}}

                        <a style="font-size: 16px" class="dropdown-item" href="{{ route('admin.setting') }}"><i class="ti-settings m-r-5 m-l-5"></i>Profile</a>
                        <a style="font-size: 16px" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i>Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                        {{--  <div class="dropdown-divider"></div>  --}}
                        {{--  <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div>  --}}
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
