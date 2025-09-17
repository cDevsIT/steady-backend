<aside class="modern-sidebar">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
        <img src="{{asset('assets/images/logo.png')}}" alt="Logo" class="brand-logo main-logo">
        <img src="{{asset('assets/images/fav.png')}}" alt="Favicon" class="brand-logo favicon-logo">
    </div>

    <!-- Sidebar Menu -->
    <nav class="sidebar-menu mt-3">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{route('admin.dashboard')}}" 
                   class="nav-link {{ session('lsbsm') == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <span class="nav-content">Dashboard</span>
                </a>
            </li>

            <!-- Customers -->
            <li class="nav-item">
                <a href="{{route('admin.customers')}}" 
                   class="nav-link {{ session('lsbsm') == 'customers' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <span class="nav-content">Customers</span>
                </a>
            </li>

            <!-- Companies -->
            <li class="nav-item">
                <a href="{{route('admin.companies')}}" 
                   class="nav-link {{ session('lsbsm') == 'companies' ? 'active' : '' }}">
                    <i class="nav-icon far fa-building"></i>
                    <span class="nav-content">Companies</span>
                </a>
            </li>

            <!-- Orders Dropdown -->
            <li class="nav-item {{ session('lsbm') == 'orders' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#ordersSubmenu">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <span class="nav-content">Orders</span>
                    <i class="nav-arrow fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ session('lsbm') == 'orders' ? 'show' : '' }}" id="ordersSubmenu">
                    <ul class="nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orders',['type'=>'active']) }}" 
                               class="nav-link {{ session('lsbsm') == 'orders_active' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Active Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders',['type'=>'expired']) }}" 
                               class="nav-link {{ session('lsbsm') == 'orders_expired' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Expired Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders',['type'=>'fail']) }}" 
                               class="nav-link {{ session('lsbsm') == 'fail' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Unpaid or Failed</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Transitions -->
            <li class="nav-item">
                <a href="{{route('admin.transitions')}}" 
                   class="nav-link {{ session('lsbsm') == 'transitions' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-hand-holding-dollar"></i>
                    <span class="nav-content">Transitions</span>
                </a>
            </li>

            <!-- State Fees -->
            <li class="nav-item">
                <a href="{{route('admin.fees.index')}}" 
                   class="nav-link {{ session('lsbsm') == 'fees' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-flag-usa"></i>
                    <span class="nav-content">State Fees</span>
                </a>
            </li>

            <!-- Admin Users -->
            <li class="nav-item">
                <a href="{{route('admin.user')}}" 
                   class="nav-link {{ session('lsbsm') == 'admins' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <span class="nav-content">Admin Users</span>
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item">
                <a href="{{route('admin.settings.index')}}" 
                   class="nav-link {{ session('lsbsm') == 'settings' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <span class="nav-content">Settings</span>
                </a>
            </li>

            <!-- Blog Management Dropdown -->
            <li class="nav-item {{ session('lsbm') == 'blogs' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#blogSubmenu">
                    <i class="nav-icon fas fa-blog"></i>
                    <span class="nav-content">Blog Management</span>
                    <i class="nav-arrow fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ session('lsbm') == 'blogs' ? 'show' : '' }}" id="blogSubmenu">
                    <ul class="nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('blogs.index') }}" 
                               class="nav-link {{ session('lsbsm') == 'blogs' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Blogs</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" 
                               class="nav-link {{ session('lsbsm') == 'categories' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Categories</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Tickets Dropdown -->
            <li class="nav-item {{ session('lsbm') == 'tickets' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#ticketsSubmenu">
                    <i class="nav-icon fas fa-ticket-alt"></i>
                    <span class="nav-content">Tickets</span>
                    <i class="nav-arrow fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ session('lsbm') == 'tickets' ? 'show' : '' }}" id="ticketsSubmenu">
                    <ul class="nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('tickets.index',['status'=>'Open'])}}" 
                               class="nav-link {{ session('lsbsm') == 'ticketsOpen' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Open Tickets</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tickets.index',['status'=>'Close'])}}" 
                               class="nav-link {{ session('lsbsm') == 'ticketsClose' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Closed Tickets</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tickets.index', ['create' => 1]) }}"
                               class="nav-link {{ session('lsbsm') == 'ticketsCreate' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-circle"></i>
                                <span class="nav-content">Create Ticket</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Try to Register -->
            <li class="nav-item">
                <a href="{{route('admin.try_to_register_list')}}" 
                   class="nav-link {{ session('lsbsm') == 'primaryContact' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-globe"></i>
                    <span class="nav-content">Try to Register</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Section -->
    <div class="mt-auto px-3 py-3 border-top border-light">
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <span class="nav-content">Log Out</span>
        </a>
    </div>
</aside>
