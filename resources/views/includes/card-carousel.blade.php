<div class="carousel">
    <div class="card-carousel">
        @foreach($wanteds as $wanted)
            <div class="my-card">
                <a class="wanted-link" href="{{route($pageUrl.'.wanted.detail',['wanted'=>$wanted->id, 'group'=>$record->id])}}">
                <p>Son Tarih: {{$wanted->deadline->format('d/m/Y')}}</p>
                <p>İstek: {{$wanted->content}}</p>
                @if(count($wanted->sticks()->get())>0)

                        <div class="text-danger"><i class="far fa-comments">{{count($wanted->sticks()->get())}}</i>
                        </div>

                @endif
                </a>
                <div class="col-md-12 answer">
                    <div class="col-md-3 offset-4">
                        <a href="{{route($pageUrl.'.wanted.sticks.create',['group'=>$record->id, 'wanted'=>$wanted->id])}}"
                           class="btn btn-gray200 btn-sm">Cevapla</a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
