<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ url('cms/favicon.ico') }}" />
    @yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/bootstrap.bundle.min.css')}}">
    <link href="{{ url('css/toastr.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{url('css/master.css')}}">
    <link rel="stylesheet" href="{{url('css/theme.css')}}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        var globalBaseUrl ='<?php echo url('/'); ?>';
    </script>
    @yield('styles')
</head>
<body>
@yield('content')


<script src="{{url('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ url('js/toastr.min.js') }}"></script>

@if(Session::has('success') || Session::has('danger'))
    <script>
        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('danger'))
        toastr.error("{{ Session::get('danger') }}");
        @endif
    </script>
@endif
@yield('scripts')
</body>

</html>
