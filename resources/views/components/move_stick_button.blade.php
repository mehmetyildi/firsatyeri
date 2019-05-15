<a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
   aria-expanded="false">
    <span class="fas fa-people-carry fa-2x"></span><span class="caret"></span>
</a>

<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" data-toggle="modal"
       data-target="#moveToBoard" href="#">Kendi Boarduma</a>
    <a class="dropdown-item" data-toggle="modal"
       data-target="#moveToGroup" href="#">Gruba</a>
</div>

@include('includes.move_stick_to_board_modal',[
    'modal_id'=>'moveToBoard' ,
    'route'=>$pageUrl.'.move_stick_to_board',
    'id'=>$record->id,
    'stick'=>$stick->id,
])

@include('includes.move_stick_to_board_group',[
    'modal_id'=>'moveToGroup' ,
    'route'=>$pageUrl.'.move_stick_to_group',
    'id'=>$record->id,
    'stick'=>$stick->id,
    'board'=>$stick->board_id
])
