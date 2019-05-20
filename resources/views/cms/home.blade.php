@extends('layouts.cms')

@section('title') <title>{{ 'Panele Hoşgeldiniz' }} | Anasayfa</title> @endsection

@section('styles')
    <link href="{{ url('cms/css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-md-12">
        <h2>Hoşgeldiniz, {{ strtok(auth()->user()->name,  ' ') }}</h2>
    </div>
</div>
<div class="wrapper wrapper-content">


</div>
@endsection

@section('scripts')
<!-- jQuery UI -->
<script src="{{ url('cms/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ url('js/cms_tasks.js') }}"></script>
<!-- ChartJS-->
<script src="{{ url('cms/js/plugins/chartJs/Chart.min.js') }}"></script>

@endsection
