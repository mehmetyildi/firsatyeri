<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  action="{{ route($route, ['user'=>$id, 'stick'=>$stick ]) }}" method="POST" >
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Taşımak istediğiniz boardı şeçin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <div class="form-label-group col-md-12">
                        <label for="name" class=" control-label">Grup</label>
                        <select class="js-example-tags1" style="width: 100%" required name="group_id" id="group_id" tabindex="-1">

                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-label-group col-md-12 ">
                        <label for="name" class=" control-label">Board</label>
                        <select class="js-example-tags1" style="width: 100%" required name="board_id" id="board_id2" tabindex="-1">

                        </select>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-info">Taşı</button>
                </div>
            </form>
        </div>
    </div>
</div>
