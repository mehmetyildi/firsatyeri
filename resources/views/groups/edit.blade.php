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


        <div class="card-body">
            <div class="row ">

                <div class="col col-md-6">


                    <div style="margin-top: 30px" class="button-center">
                        <img id="blah" src="{{url('/storage/'.$group->image_path)}}" onerror="this.src='{{$group->image_path}}'" alt="your image"/>
                    </div>

                    <div class="button-center">

                        <button type="button" data-toggle="modal" data-target="#userPhoto" class="btn btn-gray200">Değiştir</button>
                    </div>
                    <p>(*)1200x400 olarak düzenlenecektir</p>
                </div>
                <div class="col col-md-6">
                <form action="{{route('groups.update',['id'=>$group->id])}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Grup Adı</label>
                            <input type="text" value="{{$group->name}}" class="form-control" name="name"/>
                        </div>
                        <div class="form-label-group">
                            <label for="about" class=" control-label">Grup Hakkında</label>
                            <textarea class="form-control" rows="3" name="description"> {{$group->description}} </textarea>
                        </div>

                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Grubun Amacı</label>
                            <input type="text" value="{{$group->purpose}}" class="form-control" name="purpose"/>
                        </div>
                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Yer</label>
                            <select class="js-example-placeholder-single" style="width: 100%" required
                                    name="city_id" id="city_id" tabindex="-1">
                                <option></option>
                                @foreach($cities as $city)
                                    <option @if($group->city_id==$city->id) {{'selected'}} @endif
                                            value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>


                    <div class="col-md-2 offset-8">
                        <button type="submit" class="btn btn-success">Düzenle</button>
                    </div>
                </form>
                </div>
            </div>

            <br>
            <hr>


        </div>


    </div>
    @include('includes.user_photo_modal',[
    'modal_id'=>'userPhoto',
    'field'=>'image_path',
    'route'=>$pageUrl.'.update_photo',
    'id'=>['record'=>$group->id],
    'photo_name'=>'image_url'
    ])

@endsection
@section('scripts')
    <script src="{{url('js/bootstrap-datepicker.js')}}"></script>
    <script>


        $(document).ready(function () {


            $("#city_id").select2({
                placeholder: "Şehir seçiniz",
                allowClear: true
            });


            var img = new Image();
            img.onload = function() {
                var ratio=this.width / this.height;
                console.log(ratio);
                $('#blah').height(400/ratio).width(400);
            }
            img.src = $('#blah').attr('src');

        });

    </script>
@endsection
