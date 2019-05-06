<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="{{ route($route, $id) }}" method="POST" >
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">İşlemi Onaylayın</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>

                <div class="modal-body">
                    <input type="file" name="{{$photo_name}}" id="image">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-success">Yükle</button>
                </div>
            </form>
        </div>
    </div>
</div>
