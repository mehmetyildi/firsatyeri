<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> 
                    <span>
                        <img alt="image" class="img-circle img-responsive" width="48" 
                            src="{{  url('storage/'.auth()->user()->image_url)  }}"
                        />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ auth()->user()->name }}</strong>
                     </span> <span class="text-muted text-xs block"> <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">

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
                <div class="logo-element">
                    P
                </div>
            </li>
            <li class="{{ (strpos($currentRouteName, 'home') !== false) ? 'active' : '' }}">
                <a href="{{ route('cms.home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Anasayfa</span></a>
            </li>

            <li class="{{ (strpos($currentRouteName, 'interests') !== false) ? 'active' : '' }}">
                <a href="{{ route('cms.interests.index') }}"><i class="fa fa-italic"></i> <span class="nav-label">İlgi Alanları</span></a>
            </li>

            {{--<li class="{{ (strpos($currentRouteName, 'ranks') !== false) ? 'active' : '' }}">--}}
                {{--<a href="{{ route('cms.ranks.index') }}"><i class="fa fa-star"></i> <span class="nav-label">Rütbeler</span></a>--}}
            {{--</li>--}}

            <li class="{{ (strpos($currentRouteName, 'users') !== false) ? 'active' : '' }}">
                <a href="{{ route('cms.users.index') }}"><i class="fa fa-user"></i> <span class="nav-label">Kullanıcılar</span></a>
            </li>

            <li class="{{ (strpos($currentRouteName, 'groups') !== false) ? 'active' : '' }}">
                <a href="{{ route('cms.groups.index') }}"><i class="fa fa-users"></i> <span class="nav-label">Gruplar</span></a>
            </li>

        </ul>
    </div>
</nav>
