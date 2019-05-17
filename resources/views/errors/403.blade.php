<!DOCTYPE html>
<html>


<head>
    <style>
        { margin: 0; padding: 0; }

        html {
            background: url('../storage/25b4c299594ca3475d67f5ca2e4f7b21106553741a25017a3b41ba46099a5173.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.cms_name') }} | 404 Error</title>

    <link href="{{ url('cms/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('cms/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ url('cms/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('cms/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>403</h1>
        <h3 class="font-bold">İzinsiz Giriş!!</h3>

        <div class="error-desc">
            Çok özür ama bu sayfaya girmeye iznin yok. Busted!!!
            <br>
            <br>
            <a class="btn btn-primary" href="{{ route('cms.home') }}"><i class="fa fa-home"></i> Anasayfaya Git</a>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ url('cms/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('cms/js/bootstrap.min.js') }}"></script>

</body>

</html>
