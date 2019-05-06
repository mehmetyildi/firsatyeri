@extends('layouts.app')

@section('content')
    <div class="profile-pic">
        <img src="{{url('storage/'.$record->main_image)}}" alt="">
        <div class="edit"><a data-toggle="modal" data-target="#userPhoto" href="#"><i class="fas fa-edit fa-lg"></i></a></div>
    </div>
    <div class="container mb-4">
        <img src="{{url('storage/'.$record->image_url)}}" style="position: absolute;" class="mt-neg100 mb-4 rounded-circle" width="128">
        <div class="row" style="padding-top: 50px;">
            <div class="col">
                <h1 class="font-weight-bold title">{{$record->username}}</h1>
            </div>
            <div class="col">
                @if($record==Auth::user())
                    @include('components.edit_button')
                    @include('components.create_stick_button')
                    @include('components.create_board_button')
                @elseif(!Auth::user()->follows($record->username))
                    @include('components.follow_user_button')
                @else
                    @include('components.unfollow_user_button')
                @endif

            </div>
        </div>



        <p>
            {{$record->about}}
        </p>
    </div>
    <div class="container mb-4">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-white pl-2 pr-2">
                <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExplore" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExplore">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="{{ (strpos($currentRouteName, 'users.detail') !== false) ? 'active' : '' }} nav-link" href="{{route('users.detail',['username'=>$record->username])}}">Güncel Stickler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (strpos($currentRouteName, 'users.boards.index') !== false) ? 'active' : '' }}" href="{{route('users.boards.index',['username'=>$record->username])}}">Boardlar</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">İlgi Alanları</a>
                            <div class="dropdown-menu shadow-lg" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="#">Astronomy</a>
                                <a class="dropdown-item" href="#">Nature</a>
                                <a class="dropdown-item" href="#">Cooking</a>
                                <a class="dropdown-item" href="#">Fashion</a>
                                <a class="dropdown-item" href="#">Wellness</a>
                                <a class="dropdown-item" href="#">Dieting</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="card-columns">
                @foreach($sticks as $stick)
                    @include('includes.stick')
                @endforeach
            </div>
        </div>
    </div>
    @include('includes.user_photo_modal',[
    'modal_id'=>'userPhoto',
    'field'=>'main_image',
    'route'=>$pageUrl.'.update_main_image',
    'id'=>['record'=>$record->id],
    'photo_name'=>'main_image'
    ])


@endsection
@section('scripts')
    <script src="{{url('js/bootstrap-datepicker.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });
            $('.input-group.date2').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1
            });
            $(".js-example-tags").select2({
                tags: true
            });

        });

    </script>

@endsection

