@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/interests.css')}}">
@endsection
@section('content')
    <form action="{{route('users.interests.store',['user'=>$user->id])}}" method="POST">
        {{csrf_field()}}
        <div class="col-md-3 offset-9">
            <button type="submit" class="btn btn-success">Devam</button>
        </div>
        <div id="gateway-tiles">
            <div class="cy-container">
                <h1>Alışverişlerinizde İlgilendiğiniz Alanları Seçiniz</h1>
                <div class="cy-tile-container">
                @foreach($interests as $interest)
                    <!-- Primary Multi-Select Tiles -->
                        <div class="primary-gateway-tile">
                            <input name="interests[]" type="checkbox" value="{{$interest->id}}" id="{{$interest->id}}"/>
                            <label class="cy-tile" for="{{$interest->id}}" name="{{'interest'.$interest->id}}">
                                <i class="fas fa-check-circle"></i>

                                <img src="{{url('storage/'.$interest->image_path)}}"
                                     style="height: 150px; width: 150px;"
                                     onerror="this.src='{{$interest->image_path}}'">

                            </label>
                            <div class="text-center">
                                <p>{{$interest->name}}</p>

                            </div>
                        </div>
                    @endforeach


                </div>

            </div>
        </div>
    </form>
@endsection


