@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/create-stick.css')}}">
    <link rel="stylesheet" href="{{url('css/datepicker3.css')}}">
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <style>
        article, aside, figure, footer, header, hgroup,
        menu, nav, section { display: block; }
    </style>
@endsection
@section('content')
    <div class="card stick-create-card">
        <h5 class="card-header">Stickle</h5>
        <form action="{{route($pageUrl.'.wanted.sticks.store',['group'=>$group->id, 'wanted'=>$wanted->id])}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-label-group col-md-4 offset-8">
                <label for="city_id" class="col-sm-3 control-label">Board</label>
                <div class="col-md-12">
                    <select class="js-example-tags1" style="width: 100%" required name="board_id" id="board_id" tabindex="-1">

                        @foreach($boards as $board)
                            <option value="{{ $board->id }}">{{ $board->name }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <hr>
            <div class="card-body">
                <div class="row ">

                    <div class="col col-md-6">
                        <div class="button-center">
                            <input type="file" onchange="readURL(this);" name="image_path"/>
                        </div>

                        <br>
                        <div class="button-center">
                            <img id="blah" style="display: none" src="#" alt="your image" />
                        </div>

                    </div>
                    <div class="col col-md-6">
                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Stick Adı</label>
                            <input type="text" class="form-control" name="name"/>
                        </div>
                        <div  class="form-label-group">
                            <label for="about"  class=" control-label">İçerik</label>
                            <textarea class="form-control" rows="3" name="content"></textarea>
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
                                <select class="js-example-placeholder-single" style="width: 100%" required name="city_id" id="city_id" tabindex="-1">
                                    <option></option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="display: none" id="district_div" class="form-label-group col-md-6 col-sm-12">
                                <label for="last_name"  class="control-label">İlçe</label>
                                <select class="js-example-placeholder-single" style="width: 100%" required name="district_id" id="district_id" tabindex="-1">

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Başlangıç</label>
                                <div class="input-group date date1">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="begin_date" autocomplete="off">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-md-6">
                                <label class="control-label">Bitiş</label>
                                <div class="input-group date date1">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="end_date" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <br>
                <hr>
                <div class="col-md-2 offset-10">
                    <button type="submit" class="btn btn-success">Yükle</button>
                </div>

            </div>
        </form>

    </div>

@endsection
@section('scripts')
    <script src="{{url('js/bootstrap-datepicker.js')}}"></script>
    <script>
        function readURL(input) {
            var ratio
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = new Image;
                    img.onload = function() {
                        ratio=img.width/img.height;
                        console.log(ratio);

                    };

                    img.src = reader.result;

                    $('#blah')
                        .show()
                        .attr('src', e.target.result)
                        .width(200)
                        .height(1/ratio);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {

            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });
            $('.input-group.date2').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1
            });
            $("#city_id").select2({
                placeholder: "Şehir seçiniz",
                allowClear: true
            });

            $("#district_id").select2({
                placeholder: "İlçe Seçiniz",
                allowClear: true
            });

            $(".js-example-tags1").select2({
                tags: true
            });

            $('#city_id').on('change',function(){

                var city = $(this).val();
                $('#district_div').show();
                if(city){
                    $.ajax({
                        type:"GET",
                        url:"{{url('get_district_list')}}?city_id="+city,
                        success:function(res){
                            if(res){
                                $("#district_id").empty();
                                $.each(res,function(key,value){
                                    $("#district_id").append('<option value="'+key+'">'+value+'</option>');
                                });

                            }else{
                                $("#district_id").empty();
                            }
                        }
                    });
                }else{
                    $("#district_id").empty();
                }

            });

        });

    </script>
@endsection
