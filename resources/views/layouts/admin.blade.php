<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Firebase App (the core Firebase SDK) -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-analytics-compat.js"></script>

    <!-- Custom Firebase Initialization -->
    <script src="{{ asset('js/firebase-init.js') }}"></script>

    <style>
        body {
            overflow-x: hidden;
            padding-top: 56px;
            background-color: #dddddd;
            /* Add padding for fixed navbar */
        }

        .sidebar {
            position: fixed;
            top: 56px;
            /* Start below navbar */
            bottom: 0;
            left: 0;
            z-index: 1020;
            /* Below navbar */
            padding: 0;
            /* Remove top padding */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #ffc107;
            width: 250px;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            flex: 1;
            overflow-x: hidden;
            overflow-y: auto;
            padding-top: .5rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: #333;
            transition: all 0.3s;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link[data-bs-toggle="collapse"] {
            cursor: pointer;
        }

        .sidebar .nav-link[data-bs-toggle="collapse"] i.fa-chevron-down {
            transition: transform 0.3s;
        }

        .sidebar .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] i.fa-chevron-down {
            transform: rotate(180deg);
        }

        .sidebar .collapse .nav-link {
            padding-left: 3rem;
            font-size: 0.9rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #2470dc;
            background-color: #f8f9fa;
        }

        .sidebar .collapse .nav-link:hover,
        .sidebar .collapse .nav-link.active {
            background-color: #f1f3f5;
        }

        .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
            padding: 0.5rem 1rem;
        }

        .navbar {
            padding: 0.5rem 1rem;
            background-color: #fff !important;
            border-bottom: 1px solid #dee2e6;
            height: 56px;
            /* Fixed height for navbar */
            z-index: 1030;
            /* Ensure navbar is above other elements */
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            padding: 0.5rem 1rem;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-nav .nav-link {
            color: #333;
            padding: 0.5rem;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: #2470dc;
        }

        .navbar-nav .nav-link .badge {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .navbar .dropdown-menu {
            position: absolute;
            right: 0;
            left: auto;
            min-width: 200px;
            margin-top: 0.5rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: all 0.3s;
            position: relative;
            z-index: 1;
            /* Ensure content is below navbar */
        }

        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
                top: 56px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Update user menu styles */
        .user-menu {
            position: relative;
            width: 100%;
            background: #fff;
            border-top: 1px solid #dee2e6;
            padding: 1rem;
            margin-top: auto;
        }

        .user-menu .dropdown {
            position: relative;
        }

        .user-menu .dropdown-menu {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            width: 100%;
            margin-bottom: 0.5rem;
            z-index: 1030;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }

        .user-menu .dropdown-toggle {
            width: 100%;
            text-align: left;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
        }

        .user-menu .dropdown-toggle:hover {
            background: #e9ecef;
        }

        .user-menu .dropdown-toggle::after {
            float: right;
            margin-top: 0.5rem;
        }

        .user-menu .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .user-menu .dropdown-item:hover {
            background: #f8f9fa;
        }

        .user-menu .dropdown-divider {
            margin: 0.5rem 0;
        }

        /* Add these new styles */
        .modal-backdrop {
            z-index: 1040;
            opacity: 0.5;
        }

        .modal {
            z-index: 1050;
            padding-right: 0 !important;
        }

        .modal-dialog {
            z-index: 1051;
            margin: 1.75rem auto;
        }

        .modal-content {
            z-index: 1052;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);
        }

        .dropdown-menu {
            z-index: 1060;
        }
        
        /* Prevent body shifting when modal opens */
        body.modal-open {
            overflow: hidden;
            padding-right: 0 !important;
        }
        
        /* Fix for multiple modal backdrops */
        .modal-backdrop + .modal-backdrop {
            display: none;
        }
        
        /* Center modals properly */
        .modal {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        
        .modal-dialog {
            margin: 0;
            max-width: 500px;
            width: 100%;
        }
        
        /* Prevent backdrop problems */
        .modal-static .modal-dialog {
            transform: scale(1.02);
            transition: transform 0.3s ease-out;
        }
        
        /* Make sure modals remain above other elements */
        .modal, .modal-backdrop {
            transition: opacity 0.15s linear;
        }
        
        /* Fix for Bootstrap modal padding issue */
        .modal.show .modal-dialog {
            transform: none !important;
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <!-- Left side - Logo -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Right side - Notifications and User Menu -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger">3</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="{{ Auth::user()->name }}" width="32" height="32">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Mobile toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar">
        <div class="sidebar-sticky">
            <!-- Navigation -->
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>

                <!-- Location Management -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#locationMenu" role="button">
                        <i class="fas fa-map-marker-alt"></i>
                        Location Management
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.emirates.*') || request()->routeIs('admin.districts.*') || request()->routeIs('admin.neighbours.*') ? 'show' : '' }}" id="locationMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.emirates.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.emirates.*') ? 'active' : '' }}">
                                    <i class="fas fa-globe"></i>
                                    Emirates
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.districts.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.districts.*') ? 'active' : '' }}">
                                    <i class="fas fa-map"></i>
                                    Districts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.neighbours.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.neighbours.*') ? 'active' : '' }}">
                                    <i class="fas fa-building"></i>
                                    Neighbours
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Market Management -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#marketMenu" role="button">
                        <i class="fas fa-store"></i>
                        Market Management
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.markets.*') || request()->routeIs('admin.branches.*') ? 'show' : '' }}" id="marketMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.markets.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.markets.*') ? 'active' : '' }}">
                                    <i class="fas fa-store"></i>
                                    Markets
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.branches.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                                    <i class="fas fa-code-branch"></i>
                                    Branches
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Offer Management -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#offerMenu" role="button">
                        <i class="fas fa-tag"></i>
                        Offer Management
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.offers.*') || request()->routeIs('admin.offer-categories.*') ? 'show' : '' }}" id="offerMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.offer-categories.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.offer-categories.*') ? 'active' : '' }}">
                                    <i class="fas fa-tags"></i>
                                    Offer Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.offers.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}">
                                    <i class="fas fa-tag"></i>
                                    Offers
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Communication -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#communicationMenu" role="button">
                        <i class="fas fa-comments"></i>
                        Communication
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.newsletters.*') || request()->routeIs('admin.notifications.*') ? 'show' : '' }}" id="communicationMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.newsletters.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.newsletters.*') ? 'active' : '' }}">
                                    <i class="fas fa-envelope"></i>
                                    Newsletters
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.notifications.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                                    <i class="fas fa-bell"></i>
                                    Notifications
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Content Management -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#contentMenu" role="button">
                        <i class="fas fa-file-alt"></i>
                        Content Management
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.blog.*') ? 'show' : '' }}" id="contentMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.pages.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i>
                                    Pages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.blog.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                                    <i class="fas fa-blog"></i>
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- User Management -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#userMenu" role="button">
                        <i class="fas fa-users"></i>
                        User Management
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.permission-groups.*') ? 'show' : '' }}" id="userMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i>
                                    Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permission-groups.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.permission-groups.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-shield"></i>
                                    Permission Groups
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="statusMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Direct modal handler - fixes all modal issues -->
    <script>
        // Wait for DOM and Bootstrap to be fully loaded
        window.addEventListener('load', function() {
            // First remove all existing modal backdrops and cleanup
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({overflow: '', paddingRight: ''});
            
            // Remove all existing click handlers on modal triggers
            $(document).off('click.bs.modal.data-api', '[data-bs-toggle="modal"]');
            $('[data-bs-toggle="modal"]').off('click');
            
            // Pages now use .modal-trigger class for their buttons
            // Leaving this handler for backward compatibility
            $(document).on('click', '[data-bs-toggle="modal"]:not(.modal-trigger)', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get the target modal ID
                const targetId = $(this).data('bs-target') || $(this).attr('href');
                if (!targetId) return;
                
                // Get the modal element
                const modalEl = document.querySelector(targetId);
                if (!modalEl) return;
                
                // First clean up any open modals
                $('.modal.show').each(function() {
                    const instance = bootstrap.Modal.getInstance(this);
                    if (instance) {
                        instance.hide();
                    }
                });
                
                // Force clean up backdrops and body class
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css({overflow: '', paddingRight: ''});
                
                // Make sure modal has proper classes and is centered
                $(modalEl).addClass('fade');
                $(modalEl).find('.modal-dialog').addClass('modal-dialog-centered');
                
                // Ensure proper accessibility - remove aria-hidden when shown
                $(modalEl).attr('aria-hidden', 'false');
                
                $(modalEl).css({
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                });
                
                // Dispose any existing modal instance to avoid conflicts
                const existingModal = bootstrap.Modal.getInstance(modalEl);
                if (existingModal) {
                    existingModal.dispose();
                }
                
                // Create and show a new modal instance
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
                
                modal.show();
                
                // Fix accessibility after modal is shown
                setTimeout(function() {
                    $(modalEl).attr('aria-hidden', 'false');
                    // Set focus to first focusable element
                    const focusable = $(modalEl).find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').first();
                    if (focusable.length) {
                        focusable.focus();
                    }
                }, 300);
                
                // Prevent event from bubbling up to parent elements
                return false;
            });
            
            // Make sure modals are properly cleaned up when closed
            $('.modal').on('hidden.bs.modal', function() {
                // First check if any maps need to be cleaned
                const mapEl = this.querySelector('[id^="map"]');
                if (mapEl) {
                    mapEl.innerHTML = '';
                }
                
                // Reset aria attributes
                $(this).attr('aria-hidden', 'true');
                
                // Then clean up modal backdrop
                setTimeout(function() {
                    if ($('.modal.show').length === 0) {
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open').css({overflow: '', paddingRight: ''});
                    }
                }, 100);
            });
            
            // Add escape key handler to force close modals if stuck
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && ($('.modal.show').length > 0 || $('.modal-backdrop').length > 0)) {
                    $('.modal.show').each(function() {
                        const instance = bootstrap.Modal.getInstance(this);
                        if (instance) instance.hide();
                    });
                    
                    setTimeout(function() {
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open').css({overflow: '', paddingRight: ''});
                    }, 100);
                }
            });
        });
    </script>

    <!-- Custom Scripts -->
    <script>
        window.addEventListener('load', function() {
            // Initialize Select2
            if ($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap-5'
                });
            }

            // Initialize all collapse elements with parent
            const collapseElements = document.querySelectorAll('.collapse');
            collapseElements.forEach(collapse => {
                new bootstrap.Collapse(collapse, {
                    toggle: false
                });
            });

            // Handle collapse functionality
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link[data-bs-toggle="collapse"]');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetCollapse = document.querySelector(targetId);
                    
                    // Close all other collapses
                    collapseElements.forEach(collapse => {
                        if (collapse !== targetCollapse) {
                            bootstrap.Collapse.getInstance(collapse)?.hide();
                        }
                    });
                    
                    // Toggle the clicked collapse
                    const collapseInstance = bootstrap.Collapse.getInstance(targetCollapse) || new bootstrap.Collapse(targetCollapse);
                    collapseInstance.toggle();
                });
            });

            // Explicitly initialize dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
            
            // User dropdown specific initialization
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                userDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdown = bootstrap.Dropdown.getInstance(userDropdown) || new bootstrap.Dropdown(userDropdown);
                    dropdown.toggle();
                });
            }

            // Sidebar toggle functionality - improved
            const sidebarToggle = document.querySelector('.navbar-toggler');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                    
                    // Adjust main content when sidebar is toggled on mobile
                    if (window.innerWidth < 768) {
                        if (sidebar.classList.contains('show')) {
                            mainContent.style.marginLeft = '250px';
                        } else {
                            mainContent.style.marginLeft = '0';
                        }
                    }
                });
                
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && 
                        sidebar.classList.contains('show') && 
                        !sidebar.contains(e.target) && 
                        !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                        mainContent.style.marginLeft = '0';
                    }
                });
            }

            // Responsive handling
            const handleResize = function() {
                if (window.innerWidth >= 768) {
                    mainContent.style.marginLeft = '250px';
                } else if (!sidebar.classList.contains('show')) {
                    mainContent.style.marginLeft = '0';
                }
            };
            
            window.addEventListener('resize', handleResize);
            // Initial call
            handleResize();
        });
    </script>

    @if(session('success'))
    <script>
        window.addEventListener('load', function() {
            const toastElement = document.getElementById('statusToast');
            if (toastElement) {
                const toast = new bootstrap.Toast(toastElement);
                document.getElementById('statusMessage').textContent = "{{ session('success') }}";
                toast.show();
            }
        });
    </script>
    @endif

    @yield('scripts')
</body>

</html>