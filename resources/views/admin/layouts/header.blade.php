<header class="modern-header">
    <div class="header-content">
        <!-- Left Side -->
        <div class="header-left">
            <!-- Sidebar Toggle -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Mobile Sidebar Toggle -->
            <button class="sidebar-toggle d-md-none" onclick="toggleMobileSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Right Side -->
        <div class="header-right">
            <!-- Notifications -->
            <div class="position-relative me-3">
                <a href="#" class="header-link notification-link" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge">
                        3
                    </span>
                </a>
            </div>
            
            <!-- Website Link -->
            <a href="https://beta.steadyformation.com/" class="header-link website-link me-3" target="_blank" title="Visit Website">
                <i class="fas fa-globe"></i>
            </a>
            
            <!-- User Profile Dropdown -->
            <div class="dropdown">
                <button class="header-link dropdown-toggle user-profile-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center">
                        {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                    </div>
                    <span class="user-name d-none d-md-block">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end modern-dropdown">
                    <li class="dropdown-header">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item modern-dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editPassword">
                            <i class="fas fa-key me-3 text-primary"></i> 
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item modern-dropdown-item text-danger" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-3"></i> 
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</header>

<style>
.modern-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    border-bottom: 1px solid #e9ecef;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    max-width: 100%;
}

.header-left, .header-right {
    display: flex;
    align-items: center;
}

.sidebar-toggle {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #6c757d;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.2s ease;
}

.sidebar-toggle:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-1px);
}

.header-link {
    color: #6c757d;
    text-decoration: none;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    position: relative;
}

.header-link:hover {
    color: #495057;
    background: #f8f9fa;
    transform: translateY(-1px);
}

.notification-link {
    position: relative;
}

.notification-badge {
    font-size: 0.65rem;
    padding: 0.25rem 0.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.user-profile-toggle {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
    color: #495057;
}

.user-profile-toggle:hover {
    background: #e9ecef;
    color: #212529;
    transform: translateY(-1px);
}

.user-avatar {
    width: 36px;
    height: 36px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 2px solid #dee2e6;
}

.user-name {
    color: #495057;
    font-weight: 500;
    font-size: 0.9rem;
}

.dropdown-arrow {
    font-size: 0.75rem;
    transition: transform 0.2s ease;
    color: #6c757d;
}

.user-profile-toggle[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg);
}

.modern-dropdown {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    background: white;
    padding: 0.5rem 0;
    min-width: 280px;
    margin-top: 0.5rem;
    border: 1px solid #e9ecef;
}

.dropdown-header {
    padding: 1rem 1.25rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin: 0 0.5rem 0.5rem 0.5rem;
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: #e9ecef;
}

.modern-dropdown-item {
    padding: 0.75rem 1.25rem;
    color: #495057;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 8px;
    margin: 0 0.5rem;
    display: flex;
    align-items: center;
}

.modern-dropdown-item:hover {
    background: #f8f9fa;
    color: #495057;
    transform: translateX(3px);
}

.modern-dropdown-item.text-danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

@media (max-width: 768px) {
    .header-content {
        padding: 1rem;
    }
    
    .user-name {
        display: none;
    }
    
    .modern-dropdown {
        min-width: 250px;
    }
}
</style>
