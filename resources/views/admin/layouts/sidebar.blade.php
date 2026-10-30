<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header flex items-center py-4 px-6 h-header-height">
            <a href="{{ route('admin.dashboard') }}" class="b-brand flex items-center gap-3">
                <img src="{{ asset('vendor/dattaable/assets/images/logo-white.svg') }}" class="img-fluid logo logo-lg" alt="Dubai Tourism">
                <img src="{{ asset('vendor/dattaable/assets/images/favicon.svg') }}" class="img-fluid logo logo-sm" alt="Dubai Tourism">
            </a>
        </div>
        <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption"><label>Navigation</label></li>
                <li class="pc-item">
                    <a href="{{ route('admin.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i data-feather="home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item pc-caption"><label>UI Components</label><i data-feather="feather"></i></li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="edit"></i></span><span class="pc-mtext">Color</span></a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="type"></i></span><span class="pc-mtext">Typography</span></a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="feather"></i></span><span class="pc-mtext">Icons</span></a>
                </li>
                <li class="pc-item pc-caption"><label>Pages</label><i data-feather="monitor"></i></li>
                <li class="pc-item pc-hasmenu">
                    <a href="{{ route('login') }}" class="pc-link"><span class="pc-micon"><i data-feather="lock"></i></span><span class="pc-mtext">Login</span></a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="{{ route('register') }}" class="pc-link"><span class="pc-micon"><i data-feather="user-plus"></i></span><span class="pc-mtext">Register</span></a>
                </li>
                <li class="pc-item pc-caption"><label>Other</label><i data-feather="sidebar"></i></li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="align-right"></i></span><span class="pc-mtext">Menu levels</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="sidebar"></i></span><span class="pc-mtext">Sample page</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
