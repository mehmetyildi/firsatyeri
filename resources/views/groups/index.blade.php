@extends('layouts.app')
@section('content')
    <a href="{{route('groups.create')}}" style="margin-bottom: 20px" class="btn btn-success">Grup Oluştur</a>
    @if($owned->count()>0)
        <div class="card">
            <div class="card-header">
                Sahibi Olduğun Gruplar
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach($owned as $o)
                        <div class="col-md-6" style="border: solid; border-radius: 5px; border-width: 1px">
                            <a href="{{route('groups.detail',['id'=>$o->id])}}">
                            <img src="{{url('storage/'.$o->image_path)}}" alt="profile_image"
                                 onerror="this.src='{{$o->image_path}}'"
                                 style="height: 150px; width: 150px; float:left; border-radius: 50%;margin-right: 25px">
                            <p>{{$o->name}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>

        </div>
    @endif

    @if($group_admin->count()>0)
        <div class="card">
            <div class="card-header">
                Yöneticisi Olduğun Gruplar
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach($group_admin as $admin)
                        <div class="col-md-6" style="border: solid; border-radius: 5px; border-width: 1px">
                            <a href="{{route('groups.detail',['id'=>$admin->id])}}">
                            <img src="{{url('storage/'.$admin->image_path)}}" alt="profile_image"
                                 onerror="this.src='{{$admin->image_path}}'"
                                 style="height: 150px; width: 150px; float:left; border-radius: 50%;margin-right: 25px">
                            <p>{{$admin->name}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>

        </div>
    @endif

    @if($following->count()>0)
        <div class="card">
            <div class="card-header">
                Takip Ettiğin Gruplar
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach($following as $f)
                        <div class="col-md-6" style="border: solid; border-radius: 5px; border-width: 1px">
                            <a href="{{route('groups.detail',['id'=>$f->id])}}">
                            <img src="{{url('storage/'.$f->image_path)}}" alt="profile_image"
                                 onerror="this.src='{{$f->image_path}}'"
                                 style="height: 150px; width: 150px; float:left; border-radius: 50%;margin-right: 25px">
                            <p>{{$f->name}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>

        </div>
    @endif

    @if(count($recommended)>0)
        <div class="card">
            <div class="card-header">
                Size Önerdiğimiz Gruplar
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach($recommended as $f)
                        @if(!Auth::user()->groups->contains($f))
                        <div class="col-md-6" style="border: solid; border-radius: 5px; border-width: 1px">
                            <a href="{{route('groups.detail',['id'=>$f->id])}}">
                                <img src="{{url('storage/'.$f->image_path)}}" alt="profile_image"
                                     onerror="this.src='{{$f->image_path}}'"
                                     style="height: 150px; width: 150px; float:left; border-radius: 50%;margin-right: 25px">
                                <p>{{$f->name}}</p>
                            </a>
                        </div>
                        @endif
                    @endforeach
                </div>


            </div>

        </div>
    @endif
@endsection
