
    <li id="comment-2"
        class="comment even thread-even depth-1 parent media">
        <div class="media-body card mt-3 " id="div-comment-2">
            <div class="card-header hoverable">
                <div class="flex-center">
                    <a href="{{route('users.detail',['username'=>$user->username])}}"
                       class="media-object float-left">
                        <img alt=""
                             onerror="this.src='{{$user->image_url}}'"
                             src="{{url('/storage/'.$user->image_url)}}"
                             class="avatar avatar-50 photo comment_avatar rounded-circle"
                             height="50" width="50"></a>
                    <h4 class="media-heading ">{{$user->username}}</h4>


                </div>


            </div>
        </div>
    </li>
