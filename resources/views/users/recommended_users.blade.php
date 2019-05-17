@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{url('css/comment.css')}}">
@endsection

@section('content')
    <div id="comments" class="mt-5">
        @foreach($users as $user)
            @include('includes.user')
        @endforeach
@endsection

@section('scripts')
    <script src="{{url('js/comment.js')}}"></script>
@endsection
