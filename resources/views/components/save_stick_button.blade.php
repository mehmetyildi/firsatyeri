<a style="margin-right:20px;"  href="#" data-toggle="modal"
   data-target="#moveToBoard">
    <i class="fas fa-download fa-2x"></i>
</a>

@include('includes.move_stick_to_board_modal',[
    'modal_id'=>'moveToBoard' ,
    'route'=>'users.sticks.save',
    'id'=>auth()->user()->id,
    'stick'=>$stick->id,
])
