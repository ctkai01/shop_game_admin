<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    {{--  --}}
                    <!-- End User Profile-->
                </li>
                <!-- User Profile-->
                
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"><i class="mdi mdi-home-variant"></i><span class="hide-menu">Dashboard</span></a></li>
                </li>
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('users.index') }}" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Users management</span></a></li></li> --}}
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('categories.index')}}" aria-expanded="false"><i class="mdi mdi-star-circle"></i><span class="hide-menu">Categories Management</span></a></li></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('products.index')}}" aria-expanded="false"><i class="mdi mdi-shopping"></i><span class="hide-menu">Products Management</span></a></li></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('detail-products.index')}}" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Detail Products Management</span></a></li></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('recharges.index')}}" aria-expanded="false"><i class="mdi mdi-coin"></i><span class="hide-menu">Recharge Management</span></a></li></li>
            

                {{-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-cog" style="font-size: 20px"></i> Setting </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('config.banner') }}" class="sidebar-link"><i class="fas fa-home" style="font-size: 14px"></i><span class="hide-menu">Config Banner</span></a></li>
                        <li class="sidebar-item"><a href="{{ route('config.tastiest.dish') }}" class="sidebar-link"><i class="mdi mdi-calendar"></i><span class="hide-menu">Config Tastiest Dish </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('term.condition') }}" class="sidebar-link"><i class="mdi mdi-calendar"></i><span class="hide-menu">Terms & Condition</span></a></li>
                        <li class="sidebar-item"><a href="{{ route('policy') }}" class="sidebar-link"><i class="mdi mdi-calendar"></i><span class="hide-menu">Policy</span></a></li>
                    </ul>
                </li>  --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
