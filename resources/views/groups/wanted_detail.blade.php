@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/comment.css')}}">
@endsection
@section('content')
    <section class="bg-gray200 pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <article class="card">

                        <div class="card-body">
                            <div id="comments" class="mt-5">
                                <li id="comment-2"
                                    class="comment even thread-even depth-1 parent media">
                                    <div class="media-body card mt-3 " id="div-comment-2">
                                        <div class="card-header hoverable">
                                            <div class="flex-center">
                                                <a href="{{route('users.detail',['username'=>$wanted->user->username])}}"
                                                   class="media-object float-left">
                                                    <img alt=""
                                                         onerror="this.src='{{$wanted->user->image_url}}'"
                                                         src="{{url('/storage/'.$wanted->user->image_url)}}"
                                                         class="avatar avatar-50 photo comment_avatar rounded-circle"
                                                         height="50" width="50"></a>
                                                <h4 class="media-heading ">{{$wanted->user->username}}</h4>
                                            </div>
                                            <div class="comment-metadata flex-center">
                                                <a class="hidden-xs-down"
                                                   href="{{route('users.detail',['username'=>$wanted->user->username])}}">
                                                    <time
                                                        class=" small btn btn-secondary chip waves-effect waves-light"
                                                        datetime="{{$wanted->created_at}}">
                                                        {{$wanted->created_at->format('d/m/Y')}}
                                                    </time>
                                                </a>

                                            </div><!-- .comment-metadata -->
                                        </div>
                                    </div>
                                </li>
                            </div>
                            <h1 class="card-title display-4">
                                {{$wanted->content}} </h1>
                            <ul>

                                <li><strong>Bitiş Tarihi:{{$wanted->deadline->format('d/m/Y')}}</strong>
                                </li>

                            </ul>
                            @if(auth()->user()->isAdmin($record)||auth()->user()->isOwnerOf($record))

                                <div class="col-md-12 answer">
                                    <div class="col-md-3 offset-9">
                                        <a href="{{route($pageUrl.'.wanted.sticks.create',['group'=>$record->id, 'wanted'=>$wanted->id])}}"
                                           class="btn btn-gray200 btn-sm">Cevapla</a>
                                    </div>

                                </div>

                            @endif


                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <h5 class="font-weight-bold">Bu İsteğe Gelen Cevaplar</h5>
                <div class="card-columns">
                    @foreach($wanted->sticks as $stick)
                        @include('includes.stick')
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{url('js/comment.js')}}"></script>
@endsection
