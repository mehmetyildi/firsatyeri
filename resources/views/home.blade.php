@extends('layouts.app')
@section('content')
    <main role="main">


        <section class="mt-4 mb-5">
            <div class="container mb-4">
                <h1 class="font-weight-bold title">İndirimleri Yakala!</h1>
                <div class="row">
                    <nav class="navbar navbar-expand-lg navbar-light bg-white pl-2 pr-2">
                        <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarsExplore" aria-controls="navbarsDefault" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </nav>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="card-columns">
                        @foreach($sticks as $stick)
                            @include('includes.stick')
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection

@section('scripts')

    <script src="{{url('template/app.js')}}"></script>
    <script src="{{url('template/theme.js')}}"></script>
@endsection
