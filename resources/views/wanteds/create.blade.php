@extends('layouts.app')
@section('styles')

    <link rel="stylesheet" href="{{url('css/datepicker3.css')}}">
    <link rel="stylesheet" href="{{url('css/create-board.css')}}">
@endsection
@section('content')
    <div class="card stick-create-card offset-3">
        <h5 class="card-header">İsteğin Nedir</h5>
        <form action="{{route($pageUrl.'.wanted.store',['id'=>$id])}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="card-body">

                <div class="form-label-group ">
                    <label for="name" class=" control-label">İçerik</label>
                    <textarea name="content" class="form-control" id="" cols="30" rows="3"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Bitiş</label>
                    <div class="input-group date date1">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" name="deadline" autocomplete="off">
                    </div>
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
    <script src="{{url('js/bootstrap-datepicker.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });


        });

    </script>
@endsection
