<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env("APP_NAME")}} | @stack('title')</title>
    <link rel="icon" href="{{asset('assets/images')}}/fav.png" sizes="32x32"/>
    <link rel="icon" href="{{asset('assets/images')}}/fav.png"
          sizes="192x192"/>
    <link rel="apple-touch-icon" href="{{asset('assets/images')}}/fav.png"/>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tempusdominus Bootstrap 5 -->
    <link rel="stylesheet" href="{{asset("assets/css/tempusdominus-bootstrap-4.min.css")}}">
    
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/css/icheck-bootstrap.min.css')}}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/css/OverlayScrollbars.min.css')}}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        /* Modern Sidebar */
        .modern-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            z-index: 1030;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-right: 1px solid var(--border-color);
        }

        .modern-sidebar.collapsed {
            width: 70px;
        }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .modern-sidebar.collapsed .sidebar-brand {
            padding: 0 0.5rem;
        }

        .sidebar-brand img {
            max-height: 40px;
            width: auto;
            transition: all 0.3s ease;
        }

        .modern-sidebar.collapsed .sidebar-brand img {
            max-height: 30px;
        }

        .brand-logo {
            transition: all 0.3s ease;
        }

        .favicon-logo {
            display: none;
        }

        .modern-sidebar.collapsed .main-logo {
            display: none;
        }

        .modern-sidebar.collapsed .favicon-logo {
            display: block;
        }

        .sidebar-menu {
            padding: 1rem 0;
            height: calc(100vh - var(--header-height));
            overflow-y: auto;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--secondary-color) !important;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: var(--light-color);
            color: var(--primary-color) !important;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        }

        .nav-icon {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-content {
            flex: 1;
            transition: all 0.3s ease;
            opacity: 1;
        }

        .modern-sidebar.collapsed .nav-content {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .nav-arrow {
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        .nav-treeview {
            padding-left: 0;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
        }

        .modern-sidebar.collapsed .nav-treeview {
            display: none !important;
        }

        .nav-treeview .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 8px;
        }

        .modern-sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem 0.5rem;
        }

        .modern-sidebar.collapsed .nav-icon {
            margin-right: 0;
            width: auto;
        }

        .modern-sidebar.collapsed .nav-link:hover {
            transform: none;
        }

        /* Modern Header */
        .modern-header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1020;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .modern-header.collapsed {
            left: 70px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 0 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--secondary-color);
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: var(--light-color);
            color: var(--primary-color);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-link {
            color: var(--secondary-color);
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .header-link:hover {
            background: var(--light-color);
            color: var(--primary-color);
        }

        /* Modern Content */
        .modern-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            min-height: calc(100vh - var(--header-height));
            transition: all 0.3s ease;
            padding: 2rem;
        }

        .modern-content.collapsed {
            margin-left: 70px;
        }

        /* Modern Cards */
        .modern-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: 12px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Modern Stats Cards */
        .stats-card {
            background: #fff;
            color: var(--dark-color);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .stats-card.success {
            border-left: 4px solid var(--success-color);
        }

        .stats-card.warning {
            border-left: 4px solid var(--warning-color);
        }

        .stats-card.danger {
            border-left: 4px solid var(--danger-color);
        }

        .stats-card.info {
            border-left: 4px solid var(--info-color);
        }

        .stats-card.secondary {
            border-left: 4px solid var(--secondary-color);
        }

        .stats-icon {
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-sidebar {
                transform: translateX(-100%);
            }

            .modern-sidebar.show {
                transform: translateX(0);
            }

            .modern-header {
                left: 0;
            }

            .modern-content {
                margin-left: 0;
                padding: 1rem;
            }

            .modern-content.collapsed {
                margin-left: 0;
            }
        }

        /* Scrollbar Styling */
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }
    </style>
    
    @stack('css')

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Get the user's timezone
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        // Check if the timezone cookie exists
        if (!getCookie('timezone')) {
            // Set the timezone cookie with a 1-day expiration
            const expires = new Date();
            expires.setDate(expires.getDate() + 1); // Cookie expires in 1 day
            document.cookie = `timezone=${timezone}; expires=${expires.toUTCString()}; path=/`;
        } else if (getCookie('timezone') !== timezone) {
            const expires = new Date();
            expires.setDate(expires.getDate() + 1); // Cookie expires in 1 day
            document.cookie = `timezone=${timezone}; expires=${expires.toUTCString()}; path=/`;
        }
        console.log(getCookie('timezone') + "===" + timezone)
    </script>
</head>
<body>
    <div class="d-flex">
        <!-- Modern Sidebar -->
@include('admin.layouts.sidebar')

        <div class="flex-grow-1">
            <!-- Modern Header -->
            @include('admin.layouts.header')

            <!-- Modern Content -->
            <main class="modern-content" id="mainContent">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.change_password')

<!-- jQuery -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
    
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery UI -->
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

    <!-- Moment.js -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    
<!-- overlayScrollbars -->
<script src="{{asset('assets/js/jquery.overlayScrollbars.min.js')}}"></script>

    <!-- Toastr -->
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>

<script>
        // Sidebar Toggle Functionality
        function toggleSidebar() {
            const sidebar = document.querySelector('.modern-sidebar');
            const header = document.querySelector('.modern-header');
            const content = document.querySelector('.modern-content');
            
            sidebar.classList.toggle('collapsed');
            header.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
            
            // Store state in localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        // Initialize sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarCollapsed) {
                document.querySelector('.modern-sidebar').classList.add('collapsed');
                document.querySelector('.modern-header').classList.add('collapsed');
                document.querySelector('.modern-content').classList.add('collapsed');
            }
        });

        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            const sidebar = document.querySelector('.modern-sidebar');
            sidebar.classList.toggle('show');
        }

        // Toastr Configuration
    @if (Session::has('success'))
        toastr.options = {
        "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
    }
    toastr.success("{{ session('success') }}");
    @endif
        
        @if (Session::has('error'))
        toastr.options = {
        "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
    }
    toastr.error("{{ session('error') }}");
    @endif
        
        @if (Session::has('info'))
        toastr.options = {
        "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
    }
    toastr.info("{{ session('info') }}");
    @endif
        
        @if (Session::has('warning'))
        toastr.options = {
        "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
    }
    toastr.warning("{{ session('warning') }}");
    @endif

    function alertMessage(type, message) {
        toastr.options = {
            "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
        }
        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'error') {
            toastr.error(message);
        } else if (type === 'info') {
            toastr.info(message);
        } else if (type === 'warning') {
            toastr.warning(message);
        }
        }
</script>

@stack('js')
</body>
</html>
