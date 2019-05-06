<div class="modal fade bd-example-modal-lg" id="{{ $modal_id }}"  role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="{{ route($route, $id) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Fırsatı Stickle!</h4>

                    <div class="form-label-group col-md-4 offset-5">
                        <label for="city_id" class="col-sm-3 control-label">Board</label>
                        <div class="col-md-12">
                            <select class="js-example-tags" style="width: 100%" required name="board_id" id="board_id" tabindex="-1">

                                @foreach($boards as $board)
                                    <option value="{{ $board->id }}">{{ $board->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">
                    <div class="row ">

                        <div class="col col-md-6">
                            <input type="file" name="image_url"/>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-label-group ">
                                <label for="name" class=" control-label">Stick Adı</label>
                                <input type="text" class="form-control" name="name"/>
                            </div>
                            <div  class="form-label-group">
                                <label for="about"  class=" control-label">İçerik</label>
                                <textarea class="form-control" rows="3" name="about"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-label-group col-md-6 col-sm-12">
                                    <label for="name" class=" control-label">Önceki Fiyat</label>
                                    <input type="text" class="form-control" name="before_price"/>
                                </div>
                                <div class="form-label-group col-md-6 col-sm-12">
                                    <label for="last_name"  class="control-label">Fırsat Fiyatı</label>
                                    <input type="text" class="form-control" name="sale_price"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-label-group col-md-6 col-sm-12">
                                    <label for="name" class=" control-label">İl</label>
                                    <input type="text" class="form-control" name="city"/>
                                </div>
                                <div style="display: none" class="form-label-group col-md-6 col-sm-12">
                                    <label for="last_name"  class="control-label">İlçe</label>
                                    <input type="text" class="form-control" name="district"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Başlangıç</label>
                                    <div class="input-group date date1 col-sm-8">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="publish_at" autocomplete="off">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Bitiş</label>
                                    <div class="input-group date date1 col-sm-8">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="publish_until" autocomplete="off">
                                    </div>
                                </div>
                                </div>
                            </div>

                        </div>


                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-success">Yükle</button>
                </div>
            </form>
        </div>
    </div>
</div>
