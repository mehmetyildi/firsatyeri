<div class="card card-pin col-md-3 col">
    <div class="board-preview-container">
        <div class="board-preview-grid">

            <div class="board-preview-row">

                <div class="board-preview-cell">
                    <img @if(count($board->sticks)>0) src="{{"/storage/".$board->sticks[0]->image_path}}"  onerror="this.src='{{$board->sticks[0]->image_path}}';" @endif >
                </div>

                <div class="board-preview-cell">
                    <img @if(count($board->sticks)>1) src="{{"/storage/".$board->sticks[1]->image_path}}" onerror="this.src='{{$board->sticks[1]->image_path}}';" @endif>
                </div>
            </div>
            <div class="board-preview-row board-preview-row--mid">
                <div class="board-preview-cell">
                    <img @if(count($board->sticks)>2)src="{{"/storage/".$board->sticks[2]->image_path}}" onerror="this.src='{{$board->sticks[2]->image_path}}';" @endif>
                </div>
                <div class="board-preview-cell">
                    <img @if(count($board->sticks)>3) src="{{"/storage/".$board->sticks[3]->image_path}}" onerror="this.src='{{$board->sticks[3]->image_path}}';" @endif>
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
