<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.cms_name') }} | 404 Error</title>

    <link href="{{ url('/cms/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('/cms/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ url('/cms/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('/cms/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('/css/error.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>404</h1>
    <h3 class="font-bold">A ah!</h3>

    <div class="error-desc">
       Birşeyler ters gitti. Siz en iyisi bu hiç olmamış gibi anasayfaya gidip ordan takılmaya devam edin. Biz hallederiz.<br>
        <br>
        <a class="btn btn-primary" href="{{ route('home') }}"><i class="fa fa-home"></i> Anasayfaya git </a>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ url('/cms/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ url('/cms/js/bootstrap.min.js') }}"></script>

</body>

</html>
