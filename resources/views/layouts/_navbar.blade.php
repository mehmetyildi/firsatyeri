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
                <a class="nav-link active" href="{{route('home')}}">Anasayfam</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.sticks.create',['id'=>Auth::user()->id])}}">Stick</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('groups.index',['username'=>Auth::user()->username])}}">Gruplar</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('users.detail',['username'=>Auth::user()->username])}}"><img class="rounded-circle mr-2" src="{{url('storage/'.Auth::user()->image_url)}}" onerror="this.src='{{Auth::user()->image_url}}'" width="30"><span class="align-middle">{{Auth::user()->username}}</span></a>
            </li>

        </ul>
    </div>
</nav>
