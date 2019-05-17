<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ url('cms/favicon.ico') }}"/>
    @yield('title')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript"> (function () {
            var css = document.createElement('link');
            css.href = 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
            css.rel = 'stylesheet';
            css.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(css);
        })(); </script>

    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/bootstrap.bundle.min.css')}}">
    <link href="{{ url('css/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/master.css')}}">
    <link rel="stylesheet" href="{{url('css/theme.css')}}">
    <link rel="stylesheet" href="{{url('css/comment.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        var globalBaseUrl = '<?php echo url('/'); ?>';
    </script>
    @yield('styles')
</head>
<body>
@include('layouts._navbar')
<div class="container">
    @yield('content')


</div>
<script src="{{url('js/jquery-3.3.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o"
        crossorigin="anonymous"></script>
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>
<script src="{{ url('js/toastr.min.js') }}"></script>
<script src="{{url('js/comment.js')}}"></script>
@if(Session::has('success') || Session::has('danger'))
    <script>
        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('danger'))
        toastr.error("{{ Session::get('danger') }}");
        @endif
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()

        })
    </script>
@endif
@yield('scripts')
</body>
</html>
