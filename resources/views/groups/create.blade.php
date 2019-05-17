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
        <h5 class="card-header">Grup Oluştur</h5>
        <form action="{{route('groups.store')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="card-body">
                <div class="row ">

                    <div class="col col-md-6">
                        <div class="button-center">
                            <input type="file" onchange="readURL(this);" name="image_path"/>
                        </div>

                        <br>
                        <div class="button-center">
                            <img id="blah" style="display: none" src="#" alt="your image"/>
                        </div>
                        <div class="error" style="color: red;">{{ $errors->first('image_path') }}</div>

                    </div>
                    <div class="col col-md-6">
                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Grup Adı</label>
                            <input type="text" class="form-control" name="name"/>
                        </div>
                        <div class="error" style="color: red;">{{ $errors->first('name') }}</div>

                        <div class="form-label-group">
                            <label for="about" class=" control-label">Grup Hakkında</label>
                            <textarea class="form-control" rows="3" name="description"></textarea>
                        </div>
                        <div class="error" style="color: red;">{{ $errors->first('description') }}</div>

                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Grubun Amacı</label>
                            <input type="text" class="form-control" name="purpose"/>
                        </div>
                        <div class="error" style="color: red;">{{ $errors->first('purpose') }}</div>

                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Yer</label>
                            <select class="js-example-placeholder-single" style="width: 100%" required
                                    name="city_id" id="city_id" tabindex="-1">
                                <option></option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
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
                        .height(200/ratio);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function () {


            $("#city_id").select2({
                placeholder: "Şehir seçiniz",
                allowClear: true
            });



        });

    </script>
@endsection
