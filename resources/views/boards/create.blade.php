@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/create-board.css')}}">
@endsection
@section('content')
    <div class="card stick-create-card offset-3">
        <h5 class="card-header">Board Oluştur</h5>
        <form action="{{route($pageUrl.'.boards.store',['id'=>$id])}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-label-group col-md-9 offset-3">
                <label for="city_id" class="control-label">Ilgi alanları</label>

                    <select class="js-example-tags1" multiple="multiple" style="width: 100%" required name="interests[]" id="interests"
                            tabindex="-1">

                        @foreach($interests as $interest)
                            <option value="{{ $interest->id }}">{{ $interest->name }}</option>
                        @endforeach
                    </select>


            </div>
            <hr>
            <div class="card-body">

                        <div class="form-label-group ">
                            <label for="name" class=" control-label">Board Adı</label>
                            <input type="text" class="form-control" name="name"/>
                        </div>
                <div class="error" style="color: red;">{{ $errors->first('name') }}</div>
                        <div class="form-label-group">
                            <label for="about" class=" control-label">Kısa tanım</label>
                            <textarea class="form-control" rows="3" name="description"></textarea>
                        </div>



                    <br>
                    <hr>
                    <div class="col-md-2 offset-9">
                        <button type="submit" class="btn btn-success">Yükle</button>
                    </div>

            </div>
        </form>

    </div>

@endsection
@section('scripts')

    <script>
        $(document).ready(function () {


            $(".js-example-tags1").select2({
                tags: true,
                placeholder: "Bu board için ilgi alanları seçiniz.",
            });



        });

    </script>
@endsection
