@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/wanted.css')}}">
@endsection
@section('content')
    <div class="profile-pic ">
        <img src="{{url('storage/'.$record->image_path)}}" onerror="this.src='{{$record->image_path}}'" alt="">
        @if(Auth::user()->username==$record->creator->username)
            <div class="edit"><a data-toggle="modal" data-target="#userPhoto" href="#"><i class="fas fa-edit fa-lg"></i></a>
            </div>
        @endif
    </div>
    <div class="container mb-4">
        <div class="row" style="padding-top: 50px;">
            <div class="col">
                <h1 class="font-weight-bold title">{{$record->name}}</h1>
            </div>
            <div class="col">
                @if(Auth::user()->isBanned($record))
                <div class="text-danger">Bu gruptan atıldınız</div>
                @elseif(Auth::user()->isOwnerOf($record)|| Auth::user()->isAdmin($record))
                    @include('components.edit_button')
                    @include('components.create_board_button')
                    @include('components.create_stick_button')
                    @include('components.create_wanted_button')

                @elseif(Auth::user()->isMemberOfThis($record))

                    @include('components.create_stick_button')
                    @include('components.create_wanted_button')
                    @include('components.unfollow_group_button')
                @else
                    @include('components.follow_group_button')
                @endif

            </div>
        </div>


        <p>
            {{$record->description}}
        </p>

    </div>
    <div class="col-md-12">
        @if(count($record->wantedAds()->get())>0)
            @include('includes.card-carousel')
            <h4 style="text-align: center">Grup üyelerinden gelen istekler</h4>
        @endif
    </div>



    <div class="container mb-4">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-white pl-2 pr-2">
                <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarsExplore" aria-controls="navbarsDefault" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExplore">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ (strpos($currentRouteName, 'groups.detail') !== false) ? 'active' : '' }}"
                               href="{{route('groups.detail',['id'=>$record->id])}}">Güncel Stickler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (strpos($currentRouteName, 'groups.boards.index') !== false) ? 'active' : '' }}"
                               href="{{route('groups.boards.index',['group'=>$record->id])}}">Boardlar</a>
                        </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (strpos($currentRouteName, 'groups.users.index') !== false) ? 'active' : '' }}"
                                   href="{{route('groups.users.index',['group'=>$record->id])}}">Kullanıcılar</a>
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
     'field'=>'image_path',
     'route'=>$pageUrl.'.update_photo',
     'id'=>['record'=>$record->id],
     'photo_name'=>'image_url'
     ])

    @include('includes.create_stick',[
    'modal_id'=>'createStick',
    'boards'=>$record->boards,
    'route'=>$pageUrl.'.create_stick',
    'id'=>['record'=>$record->id],
    ])
@endsection
@section('scripts')
    <script src="{{url('js/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('js/wanted.js')}}"></script>
    <script>
        $(document).ready(function () {
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


