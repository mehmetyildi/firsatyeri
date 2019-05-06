@extends('layouts.app')
@section('content')

    <form  action="{{route($pageUrl.'.update',['id'=>$record->id])}}" class="col-md-6 offset-3">
        <h1 style="text-align: center">Profilini Düzenle</h1>
        <p>Diğer kullanıcıların seni daha iyi tanıması için aşağdaki bilgilere ihtiyacımız var.</p>
        <div class="button-center">
            <img src="{{url('storage/'.$record->image_url)}}" alt="profile_image"
                 style="height: 150px; width: 150px; float:left; border-radius: 50%;margin-right: 25px">
            <button type="button" data-toggle="modal" data-target="#userPhoto" class="btn btn-gray200">Değiştir</button>

        </div>
        <div class="col" style="text-align: center">
            <h1 class="font-weight-bold title">{{$record->username}}</h1>
        </div>
        <hr>
        <div class="form-actions col-lg-1 offset-9">
            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i>Güncelle</button>

        </div>
        <div class="row">
            <div class="form-label-group col-md-6 col-sm-12">
                <label for="name" class=" control-label">Ad</label>
                <input type="text" value="{{$record->name}}" class="form-control" name="name"/>
            </div>
            <div class="form-label-group col-md-6 col-sm-12">
                <label for="last_name"  class="control-label">Soyad</label>
                <input type="text" value="{{$record->last_name}}" class="form-control" name="last_name"/>
            </div>
        </div>
        <div class="form-label-group ">
            <label for="email"  class=" control-label">Email</label>
            <input type="text" value="{{$record->email}}" class="form-control" name="email"/>
        </div>

        <div class="form-label-group ">
            <label for="username"  class=" control-label">Username</label>
            <input type="text" value="{{$record->username}}" class="form-control" name="username"/>
        </div>

        <div  class="form-label-group">
            <label for="about"  class=" control-label">Profilin hakkında</label>
            <textarea class="form-control" rows="3" name="about">{{$record->about}}</textarea>
        </div>




    </form>
    @include('includes.user_photo_modal',[
    'modal_id'=>'userPhoto',
    'field'=>'image_path',
    'route'=>$pageUrl.'.update_photo',
    'id'=>['record'=>$record->id],
    'photo_name'=>'image_url'
    ])
@endsection


