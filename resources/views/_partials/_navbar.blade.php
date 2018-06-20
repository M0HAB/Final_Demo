<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        @if (Auth::check())
            <a class="navbar-brand" href="{{ route('user.dashboard') }}"><img width="150px" height="35px" class="mr-1" src="/images/logo4.png"></a>
        @else
            <a class="navbar-brand" href="{{ route('index') }}"><img width="150px" height="35px" class="mr-1" src="/images/logo4.png"></a>
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
                    <li class="nav-item dropdown ml-1">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="msg-dropdown" onclick="toggleArrow('arrow-up')">
                            <i class="fas fa-envelope"></i>
                        </a>
                    <i id="arrow-up" class="fas fa-caret-up" style="font-size:30px;position:absolute;top:24px;left:6px;color:#fff;height: 33px;"></i>
                    <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="navbarDropdown">
                        @php
                            $msgsNav = messageNav();
                        @endphp
                        @if(count($msgsNav) == 0 )
                            <p class="text-left pl-4 py-2" style="font-size: 14px;">No messages found</p>
                        @endif
                        @foreach ($msgsNav as $msgNav)
                            @php
                                if(Auth::user()->id == $msgNav->user_id){
                                    $msgUser = ('App\User')::find($msgNav->friend_id);
                                }else{
                                    $msgUser = ('App\User')::find($msgNav->user_id);
                                }
                                $msgUser->name = $msgUser->fname .' '.$msgUser->lname;
                                if(strlen($msgNav->body)>15){
                                    $msgNav->body = mb_substr($msgNav->body,0,15,'UTF-8').'...';
                                }
                            @endphp

                            <ul class="list-group list-group-scroll">
                                <a class="rm-deco" href="{{route('messages.show', $msgUser->id)}}">
                                    <li class="list-group-item list-gitem-custom">
                                        <span class="username-msg">{{$msgUser->name}}</span>
                                        <span class="msg-time float-right">{{$msgNav->created_at->diffForHumans()}}</span>
                                        <span class="lb drop-msg-body"><i class="fas fa-caret-right"></i> {{$msgNav->body}}</span>
                                    </li>
                                </a>
                            </ul>

                            {{-- <h6 class="dropdown-header">{{$msgUser->name}}</h6>
                            <a class="dropdown-item" href="{{route('messages.show', $msgUser->id)}}">{{$msgNav->body}}</a>
                            <div class="dropdown-divider"></div> --}}

                        @endforeach
                        <div>
                            <a class="pl-4 py-2 d-block" href="{{ route('messages.index')}}" style="font-size:12px;display:inline-block">See All Messages</a>
                        </div>
                    </div>
                    @if (Request::url() == Route('user.dashboard'))
                        <li class="nav-item">
                            <a class="nav-link d-none" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item {{ Request::url() == Route('user.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->fname }}</a>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" id="user-profile" href="{{ route('user.profile') }}"><i class="fas fa-user space-icon"></i>Profile</a>
                            <a class="dropdown-item" href="{{ route('course.listUserCourses') }}"><i class="fas fa-video space-icon"></i>Courses</a>
                            <a class="dropdown-item" href="{{route('admin.contact.create')}}"><i class="fas fa-cog space-icon"></i>Contact admin</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt space-icon"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav> <!-- End: Navbar -->
