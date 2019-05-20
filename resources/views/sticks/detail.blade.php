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

                        <img class="card-img-top mb-2" src="{{url('/storage/'.$stick->image_path)}}"
                             onerror="this.src='{{$stick->image_path}}'" alt="Card image">
                        <div class="card-body">
                            <div align="right">
                            @if($stick->creator->username==Auth::user()->username)

                                    <div class="dropdown show">
                                        @include('components.edit_stick_button')
                                        @include('components.stick_delete_button')
                                        @include('components.move_stick_button')
                                    </div>

                            @else
                                @include('components.save_stick_button')
                            @endif
                            </div>
                            <div id="comments" class="mt-5">
                                @if($stick->group_id!=null &&  !(strpos($currentRouteName, 'groups') !== false) )
                                    <a href="{{route('groups.detail',['id'=>$stick->group_id])}}">
                                        {{$stick->group->name}}
                                    </a> adlı grupta paylaşıldı
                                @endif
                                <li id="comment-2"
                                    class="comment even thread-even depth-1 parent media">
                                    <div class="media-body card mt-3 " id="div-comment-2">
                                        <div class="card-header hoverable">
                                            <div class="flex-center">
                                                <a href="{{route('users.detail',['username'=>$stick->creator->username])}}"
                                                   class="media-object float-left">
                                                    <img alt=""
                                                         onerror="this.src='{{$stick->creator->image_url}}'"
                                                         src="{{url('/storage/'.$stick->creator->image_url)}}"
                                                         class="avatar avatar-50 photo comment_avatar rounded-circle"
                                                         height="50" width="50"></a>
                                                <h4 class="media-heading ">{{$stick->creator->username}}</h4>


                                            </div>

                                            <div class="comment-metadata flex-center">

                                                <a class="hidden-xs-down"
                                                   href="{{route('users.detail',['username'=>$stick->creator->username])}}">
                                                    <time
                                                        class=" small btn btn-secondary chip waves-effect waves-light"
                                                        datetime="{{$stick->created_at}}">
                                                        {{$stick->created_at->format('d/m/Y')}}
                                                    </time>
                                                </a>

                                            </div><!-- .comment-metadata -->
                                        </div>
                                    </div>
                                </li>
                            </div>

                            <h1 class="card-title display-4">
                                {{$stick->name}} </h1>
                            <p>{!! $stick->content !!}</p>
                            <ul>
                                @if($stick->city_id>0)
                                <li><strong>Yer: {{$stick->district->name."/".$stick->city->name}}</strong></li>
                                @endif
                                <li><strong>Eski Fiyat: {{$stick->before_price." ₺"}}</strong></li>
                                <li><strong>Fırsat Fiyatı: {{$stick->sale_price." ₺"}}</strong></li>
                                <li><strong>Fırsat
                                        Zamanı: {{$stick->begin_date->format('d/m/Y')." - ".$stick->end_date->format('d/m/Y')}}</strong>
                                </li>

                            </ul>
                            @if(strlen($stick->link)>0)
                                <small class="d-block">
                                    <a class="btn btn-sm btn-gray200" href="{{$stick->link}}">
                                        <i class="fas fa-external-link-alt"></i>
                                        Fırsatın Olduğu Siteye Gir
                                    </a>
                                </small>
                            @endif
                            <div class="comment-area">
                                <form action="{{route('sticks.comments.store',['id'=>$stick->id])}}">
                                    {{csrf_field()}}
                                    <textarea class="form-control" placeholder="Yorum bırakın..." name="content" id=""
                                              rows="4"></textarea>
                                    <div class="col-md-12 text-center">
                                        <button class="btn-two" type="submit">Yorum yaz</button>
                                    </div>
                                </form>

                            </div>
                            @if($stick->comments->count()==0)
                                Bu stick'e henüz yorum yapılmamış. Ilk yorum yapan siz olun
                            @else
                                <div class="col-md-12 ">
                                    <div id="comments" class="mt-5">

                                        <h2>{{$stick->comments->count()}} yorum yapılmış</h2>

                                        <ol class="medias py-md-2 my-md-2 px-sm-0 mx-sm-0">
                                            @foreach($stick->comments as $comment)
                                                @include('includes.comment')
                                            @endforeach

                                        </ol>


                                    </div>
                                </div>

                            @endif


                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    @include('includes.delete_stick_modal',[
     'modal_id'=>'deleteStick',
     'route'=>'sticks.delete',
     'id'=>$stick->id,
     'parent_id'=>$record->id,
     'return_url'=>$pageUrl
     ])
@endsection
@section('scripts')
    <script src="{{url('js/comment.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#board_id").select2({
                tags: true,
            });

            $("#board_id2").select2({
                tags: true,
            });

            $("#group_id").select2({

                allowClear: true
            });

            $('#group_id').on('change', function () {

                var group = $(this).val();
                if (group) {
                    $.ajax({
                        type: "GET",
                        url: "{{url('get_groupboard_list')}}?group_id=" + group,
                        success: function (res) {
                            if (res) {
                                $("#board_id2").empty();
                                $.each(res, function (key, value) {
                                    $("#board_id2").append('<option value="' + key + '">' + value + '</option>');
                                });

                            } else {
                                $("#board_id2").empty();
                            }
                        }
                    });
                } else {
                    $("#board_id2").empty();
                }

            });
            $('#group_id').trigger('change');
        })
    </script>
@endsection
