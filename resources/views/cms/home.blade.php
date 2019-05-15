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
@if(config('app.env') == 'production')
<script>
   $(document).ready(function() {

        var lineData = {
            labels: [
            @foreach($totalVisitorsAndPageViews as $label)
            "{{ $label['date']->format('d.m.y') }}", 
            @endforeach
            ],
            datasets: [
                {
                    label: "Görüntüleme",
                    backgroundColor: "rgba(26,179,148,0.2)",
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: [
                        @foreach($totalVisitorsAndPageViews as $data)
                        {{ $data['pageViews'] }}, 
                        @endforeach
                    ]
                }
            ]
        };

        var lineOptions = {
            responsive: true,
            elements: {
                line: {
                    tension: 0.1
                }
            }
        };


        var ctx = document.getElementById("lineChart").getContext("2d");
        new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


    });
</script>
@endif
@endsection
