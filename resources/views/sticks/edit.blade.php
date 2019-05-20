@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/create-stick.css')}}">
    <link rel="stylesheet" href="{{url('css/datepicker3.css')}}">
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
          rel="stylesheet" type="text/css"/>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <style>
        article, aside, figure, footer, header, hgroup,
        menu, nav, section {
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="card stick-create-card">
        <h5 class="card-header">Stickle</h5>
        <form action="{{route('sticks.update',['stick'=>$stick->id,'type'=>$type, 'record'=>$record])}}" method="POST"
              enctype="multipart/form-data">
            {{csrf_field()}}

            <hr>
            <div class="card-body">
                <div class="row ">

                    <div class="col col-md-6">


                        <div style="margin-top: 30px" class="button-center">
                            <img id="blah" src="{{url('/storage/'.$stick->image_path)}}"
                                 onerror="this.src='{{$stick->image_path}}'" alt="your image"/>
                        </div>

                        <div class="button-center">

                            <button type="button" data-toggle="modal" data-target="#userPhoto" class="btn btn-gray200">
                                Değiştir
                            </button>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Stick Adı</label>
                            <input type="text" value="{{$stick->name}}" class="form-control" name="name"/>
                        </div>
                        <div class="error" style="color: red;">{{ $errors->first('name') }}</div>
                        <div class="form-label-group">
                            <label for="about" class=" control-label">İçerik</label>
                            <textarea class="form-control" rows="3" name="content">{{$stick->content}}</textarea>
                        </div>
                        <div class="error" style="color: red;">{{ $errors->first('content') }}</div>
                        <div class="row">
                            <div class="form-label-group col-md-6 col-sm-12">
                                <label for="name" class=" control-label">Önceki Fiyat</label>
                                <input type="number" value="{{$stick->before_price}}" class="form-control"
                                       name="before_price"/>
                            </div>
                            <div class="form-label-group col-md-6 col-sm-12">
                                <label for="last_name" class="control-label">Fırsat Fiyatı</label>
                                <input type="number" class="form-control" value="{{$stick->sale_price}}"
                                       name="sale_price"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-label-group col-md-6 col-sm-12">
                                <label for="name" class=" control-label">İl</label>
                                <select class="js-example-placeholder-single" style="width: 100%"
                                        name="city_id" id="city_id" tabindex="-1">
                                    <option></option>
                                    @foreach($cities as $city)
                                        <option
                                            value="{{ $city->id }}" {{$stick->city_id==$city->id ? 'selected': ''}}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($stick->city_id>0)
                                <div id="district_div" class="form-label-group col-md-6 col-sm-12">
                                    <label for="last_name" class="control-label">İlçe</label>
                                    <select class="js-example-placeholder-single" style="width: 100%"
                                            name="district_id" id="district_id" tabindex="-1">
                                        @foreach($districts as $district)
                                            <option
                                                value="{{ $district->id }}" {{$stick->district_id==$district->id ? 'selected': ''}}>{{ $district->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Link</label>
                            <input type="text" value="{{$stick->link}}" class="form-control" name="link"/>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Başlangıç</label>
                                <div class="input-group date date1">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                        type="text" class="form-control" value="{{ $stick->begin_date ? convertDate($stick->begin_date) : '' }}"
                                        name="begin_date" autocomplete="off">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-md-6">
                                <label class="control-label">Bitiş</label>
                                <div class="input-group date date1">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                        type="text" class="form-control" value="{{ $stick->end_date ? convertDate($stick->end_date) : '' }}" name="end_date"
                                        autocomplete="off">
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
    @include('includes.user_photo_modal',[
    'modal_id'=>'userPhoto',
    'field'=>'image_path',
    'route'=>$pageUrl.'.update_photo',
    'id'=>['stick'=>$stick->id],
    'photo_name'=>'image_path'
    ])

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
                    img.onload = function () {
                        ratio = img.width / img.height;
                        console.log(ratio);

                    };

                    img.src = reader.result;

                    $('#blah')
                        .show()
                        .attr('src', e.target.result)
                        .width(200)
                        .height(1 / ratio);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function () {

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

            $('#city_id').on('change', function () {

                var city = $(this).val();
                $('#district_div').show();
                if (city) {
                    $.ajax({
                        type: "GET",
                        url: "{{url('get_district_list')}}?city_id=" + city,
                        success: function (res) {
                            if (res) {
                                $("#district_id").empty();
                                $.each(res, function (key, value) {
                                    $("#district_id").append('<option value="' + key + '">' + value + '</option>');
                                });

                            } else {
                                $("#district_id").empty();
                            }
                        }
                    });
                } else {
                    $("#district_id").empty();
                }

            });

        });

    </script>
@endsection
