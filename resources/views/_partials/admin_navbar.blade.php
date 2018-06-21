<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        @if (Auth::guard('admin')->check())
            <a class="navbar-brand" href="{{ route('user.dashboard') }}"><img width="150px" height="35px" class="mr-1" src="/images/logo4.png"></a>
        @else
            <a class="navbar-brand" href="{{ route('index') }}"><img width="150px" height="35px" class="mr-1" src="/images/logo4.png"></a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav ml-auto">
                @if (!Auth::guard('admin')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact_us') }}">Contact us</a>
                    </li>
                @else
                    <li class="nav-item dropdown ml-1">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="msg-dropdown" onclick="toggleArrow('arrow-up')">
                            <i class="fas fa-envelope"></i>
                        </a>
                    <i id="arrow-up" class="fas fa-caret-up" style="font-size:30px;position:absolute;top:24px;left:6px;color:#fff;height: 33px;"></i>
                    <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdown">
                        @php
                            $msgs = ('App\AdminMessage')::all();
                        @endphp
                        @if(count($msgs) == 0 )
                            <p class="text-left pl-4 py-2" style="font-size: 14px;">No messages found</p>
                        @endif
                        @foreach ($msgs->sortbyDesc('id') as $msg)
                            <ul class="list-group list-group-scroll">
                                <a class="rm-deco" href="{{route('admin.messages.show', $msg->id)}}">
                                    <li class="list-group-item list-gitem-custom">
                                        <span class="username-msg">{{$msg->user->fname}}</span>
                                        <span class="msg-time float-right">{{$msg->created_at->diffForHumans()}}</span>
                                        <span class="lb drop-msg-body"><i class="fas fa-caret-right"></i>{{$msg->subject}}</span>
                                    </li>
                                </a>
                            </ul>
                        @endforeach
                        <div>
                            <a class="pl-4 py-2 d-block" href="{{ route('admin.messages')}}" style="font-size:12px;display:inline-block">See All Messages</a>
                        </div>
                    </div>
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
