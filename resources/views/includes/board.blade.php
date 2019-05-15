<div class="card card-pin col-md-3 col">
    <div class="board-preview-container">
        <div class="board-preview-grid">

            <div class="board-preview-row">

                <div class="board-preview-cell">
                    <img @if(count($board->randomStick())>0) src="{{"/storage/".$board->randomStick()[0]->image_path}}"  onerror="this.src='{{$board->randomStick()[0]->image_path}}';" @endif >
                </div>

                <div class="board-preview-cell">
                    <img @if(count($board->randomStick())>1) src="{{"/storage/".$board->randomStick()[0]->image_path}}" onerror="this.src='{{$board->randomStick()[0]->image_path}}';" @endif>
                </div>
            </div>
            <div class="board-preview-row board-preview-row--mid">
                <div class="board-preview-cell">
                    <img @if(count($board->randomStick())>2)src="{{"/storage/".$board->randomStick()[0]->image_path}}" onerror="this.src='{{$board->randomStick()[0]->image_path}}';" @endif>
                </div>
                <div class="board-preview-cell">
                    <img @if(count($board->randomStick())>3) src="{{"/storage/".$board->randomStick()[0]->image_path}}" onerror="this.src='{{$board->randomStick()[0]->image_path}}';" @endif>
                </div>
            </div>

        </div>
    </div>

    <a href="{{route($pageUrl.'.board.detail',['id'=>$record->id,'board'=>$board->id])}}">
        <div class="overlay">
            <h2 class="card-title title">{{$board->name}}</h2>

        </div>
    </a>

</div>
