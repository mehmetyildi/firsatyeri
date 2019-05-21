@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/board.css')}}">
@endsection
@section('content')
    <div class="profile-pic ">
        <img src="{{url('storage/'.$record->image_path)}}" onerror="this.src='{{$record->image_path}}'" alt="">
        <div class="edit"><a data-toggle="modal" data-target="#userPhoto" href="#"><i class="fas fa-edit fa-lg"></i></a>
        </div>
    </div>
    <div class="container mb-4">
        <div class="row" style="padding-top: 50px;">
            <div class="col">
                <h1 class="font-weight-bold title">{{$record->username}}</h1>
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
                        @if($record->creator->username==Auth::user()->username)
                            <li class="nav-item">
                                <a class="nav-link {{ (strpos($currentRouteName, 'groups.users.index') !== false) ? 'active' : '' }}"
                                   href="{{route('groups.users.index',['group'=>$record->id])}}">Kullanıcılar</a>
                            </li>
                        @endif


                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="container-fluid mb-5">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Adı</th>
                <th scope="col">Kullanıcı Adı</th>
                @if($record->creator->username==Auth::user()->username)

                    <th scope="col">Aksiyon</th>
                @endif
            </tr>
            </thead>
            <tbody>

            @foreach($users as $index=> $user)
                <tr>
                    <th scope="row">{{$index+1}}</th>
                    <td><a href="{{route('users.detail',['username'=>$user->username])}}"><img src="{{url('storage/'.$user->image_url)}}" width="30" class="rounded-circle mr-2" onerror="this.src='{{$user->image_url}}'" alt="">{{$user->name.' '.$user->last_name}}</a></td>
                    <td>{{$user->username}}</td>
                    @if($record->creator->username==Auth::user()->username)

                        <td>@if($user->isBanned($record))
                                <div class="text-danger">
                                    Atıldı
                                </div>
                            @else
                                @if($user->isAdmin($record))
                                    <a class="btn btn-warning btn-sm" data-toggle="modal"
                                       data-target="#depromoteUser{{ $user->id }}"
                                       href="#">
                                        <i class="fas fa-thumbs-down fa-xs">Normal Üye Yap</i>
                                    </a>
                                @else

                                    <a class="btn btn-info btn-sm" data-toggle="modal"
                                       data-target="#promoteUser{{ $user->id }}"
                                       href="#">
                                        <i class="fas fa-thumbs-up fa-xs">Admin Yap</i>
                                    </a>
                                @endif
                                <a class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#banUser{{ $user->id }}"
                                   href="#">
                                    <i class="fas fa-trash fa-xs">Engelle</i>
                                </a>
                                @include('includes.promote_user_modal',[
                                         'modal_id'=>'promoteUser'. $user->id ,
                                         'route'=>$pageUrl.'.promote_user',
                                         'user'=>$user->id,
                                         'group'=>$record->id,
                                         'photo_name'=>'image_url'
                                         ])
                                @include('includes.promote_user_modal',[
                                         'modal_id'=>'depromoteUser'. $user->id ,
                                         'route'=>$pageUrl.'.depromote_user',
                                         'user'=>$user->id,
                                         'group'=>$record->id,
                                         'photo_name'=>'image_url'
                                         ])
                                @include('includes.ban_user_modal',[
                                         'modal_id'=>'banUser'. $user->id ,
                                         'route'=>$pageUrl.'.ban_user',
                                         'user'=>$user->id,
                                         'group'=>$record->id,
                                         'photo_name'=>'image_url'
                                         ])
                            @endif

                    @elseif(Auth::user()->isAdmin($record))

                        <td>@if($user->isBanned($record))
                                <div class="text-danger">
                                    Atıldı
                                </div>
                            @else
                                @if($user->isAdmin($record))
                                    Grup yöneticisi
                                @else

                                    <a class="btn btn-info btn-sm" data-toggle="modal"
                                       data-target="#promoteUser{{ $user->id }}"
                                       href="#">
                                        <i class="fas fa-thumbs-up fa-xs">Admin Yap</i>
                                    </a>

                                <a class="btn btn-danger btn-sm" data-toggle="modal"
                                   data-target="#banUser{{ $user->id }}"
                                   href="#">
                                    <i class="fas fa-trash fa-xs">Engelle</i>
                                </a>
                                @endif
                                @include('includes.promote_user_modal',[
                                         'modal_id'=>'promoteUser'. $user->id ,
                                         'route'=>$pageUrl.'.promote_user',
                                         'user'=>$user->id,
                                         'group'=>$record->id,
                                         'photo_name'=>'image_url'
                                         ])
                                @include('includes.promote_user_modal',[
                                         'modal_id'=>'depromoteUser'. $user->id ,
                                         'route'=>$pageUrl.'.depromote_user',
                                         'user'=>$user->id,
                                         'group'=>$record->id,
                                         'photo_name'=>'image_url'
                                         ])
                                @include('includes.ban_user_modal',[
                                         'modal_id'=>'banUser'. $user->id ,
                                         'route'=>$pageUrl.'.ban_user',
                                         'user'=>$user->id,
                                         'group'=>$record->id,
                                         'photo_name'=>'image_url'
                                         ])
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    @include('includes.user_photo_modal',[
     'modal_id'=>'userPhoto',
     'field'=>'image_path',
     'route'=>$pageUrl.'.update_photo',
     'id'=>['record'=>$record->id],
     'photo_name'=>'image_url'
     ])




@endsection
@section('scripts')
    <script src="{{url('js/board.js')}}"></script>
    <script src="{{url('js/bootstrap-datepicker.js')}}"></script>
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


