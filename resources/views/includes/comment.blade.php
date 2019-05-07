<li id="comment-2"
    class="comment even thread-even depth-1 parent media">

    <div class="media-body card mt-3 " id="div-comment-2">
        <div class="card-header hoverable">
            <div class="flex-center">
                <a href="{{route('users.detail',['username'=>$comment->user->username])}}" class="media-object float-left">
                    <img alt=""
                         onerror="this.src='{{$comment->user->image_url}}'"
                         src="{{url('/storage/'.$comment->user->image_url)}}"
                         class="avatar avatar-50 photo comment_avatar rounded-circle"
                         height="50" width="50"> </a>
                <h4 class="media-heading ">{{$comment->user->username}}</h4>
            </div>
            <div class="comment-metadata flex-center">
                <a class="hidden-xs-down"
                   href="{{route('users.detail',['username'=>$comment->user->username])}}">
                    <time
                        class=" small btn btn-secondary chip waves-effect waves-light"
                        datetime="{{$comment->created_at}}">
                        {{$comment->created_at->format('d/m/Y')}}
                    </time>
                </a>

            </div><!-- .comment-metadata -->
        </div>
        <div class="card-block">


            <div class="comment-content card-text">
                <p>{{$comment->content}}</p>
            </div>

        </div>
    </div>
</li>
