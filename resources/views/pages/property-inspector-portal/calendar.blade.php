@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="PI Calendar" :breadcrumbs="[
        ['title' => 'PI Dashboard', 'route' => '/pi-dashboard', 'active' => ''],
        ['title' => 'PI Calendar', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body container">
                            <div id="calendar" data-id="{{ $propertyInspector->id }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('assets/js/pi-calendar.js') }}"></script>
@endsection
