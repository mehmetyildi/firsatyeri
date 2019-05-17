<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <a class="navbar-brand font-weight-bolder mr-3" href="index.html"><img src="assets/img/logo.png"></a>
    <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsDefault">
        <ul class="navbar-nav mr-auto align-items-center">
            <form class="bd-search hidden-sm-down">
                <input type="text" class="form-control bg-graylight border-0 font-weight-bold" id="search-input" placeholder="Search..." autocomplete="off">
                <div class="dropdown-menu bd-search-results" id="search-results">
                </div>
            </form>
        </ul>
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link {{ (strpos($currentRouteName, 'home') !== false) ? 'active' : '' }}" href="{{route('home')}}">Anasayfam</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (strpos($currentRouteName, 'interests') !== false) ? 'active' : '' }}" href="{{route('users.interests.edit',['user'=>Auth::user()->id])}}"><span class="align-middle">İlgi Alanlarım</span></a>
            </li>
            @if(strpos($currentRouteName,'home')!==false)
            <li class="nav-item">
                <a class="nav-link {{ (strpos($currentRouteName, 'sticks.create') !== false) ? 'active' : '' }}" href="{{route('users.sticks.create',['id'=>Auth::user()->id])}}">Stick</a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ (strpos($currentRouteName, 'groups') !== false) ? 'active' : '' }}" href="{{route('groups.index',['username'=>Auth::user()->username])}}">Gruplar</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (strpos($currentRouteName, 'users.recommended') !== false) ? 'active' : '' }}" href="{{route('users.recommended',['username'=>Auth::user()->username])}}">Kullanıcılar</a>
            </li>

            <li class="nav-item">
                <div class="dropdown profile-element">
                <a  data-toggle="dropdown"
                   class="dropdown-toggle nav-link" href="#">
                    <img class="rounded-circle mr-2" src="{{url('storage/'.Auth::user()->image_url)}}" onerror="this.src='{{Auth::user()->image_url}}'" width="30">
                    {{Auth::user()->username}}
                    <span class="text-muted text-xs block"> <b class="caret"></b></span> </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li>
                        <a href="{{route('users.detail',['username'=>auth()->user()->username])}}">Profilim</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">Çıkış</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                </div>
            </li>
            {{--<li class="nav-item">--}}
                {{--<a href="{{ route('logout') }}"--}}
                   {{--onclick="event.preventDefault();--}}
                                         {{--document.getElementById('logout-form').submit();">Çıkış</a>--}}
                {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                    {{--{{ csrf_field() }}--}}
                {{--</form>--}}
            {{--</li>--}}


        </ul>
    </div>
</nav>
