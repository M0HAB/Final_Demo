<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        @if (Auth::check())
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">E-LMS</a>
        @else
            <a class="navbar-brand" href="{{ route('index') }}">E-LMS</a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav ml-auto">
                @if (!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact_us') }}">Contact us</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-bell"></i></a>
                    </li>
                    @if (Request::url() == Route('admin.dashboard'))
                        <li class="nav-item">
                            <a class="nav-link d-none" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item {{ Request::url() == Route('admin.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->fname }}</a>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" id="user-profile" href="{{ route('admin.profile') }}"><i class="fas fa-user space-icon"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-cog space-icon"></i>Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt space-icon"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav> <!-- End: Navbar -->
