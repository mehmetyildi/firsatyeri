
    <div class="card card-pin">

        <img class="card-img"
             src="{{url('/storage/'.$stick->image_path)}}"
             alt="Card image">
        <a href="{{route($pageUrl.'.sticks.detail',['stick'=>$stick->id])}}">
        <div class="overlay">
            <h2 class="card-title title">{{$stick->name}}</h2>
            <div class="more">
                    <i class="fas fa-coins" aria-hidden="true"></i> {{$stick->sale_price}} ₺
            </div>
        </div>
        </a>
    </div>

