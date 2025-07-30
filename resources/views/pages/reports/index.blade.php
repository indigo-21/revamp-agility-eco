@extends('layouts.app')

@section('importedStyles')
    {{-- <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}"> --}}
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Reports" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Reports', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                List of Reports
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link {{ !isset($id) || $id == 1 ? 'active' : '' }}"
                                            id="jobs-with-nc-tab" href="{{ route('reports.show', 1) }}" role="tab"
                                            aria-controls="jobs-with-nc" aria-selected="true">Jobs with
                                            NC</a>
                                        <a class="nav-link {{ isset($id) && $id == 2 ? 'active' : '' }}"
                                            id="jobs-with-cat1-tab" href="{{ route('reports.show', 2) }}" role="tab"
                                            aria-controls="jobs-with-cat1" aria-selected="false">Jobs with
                                            CAT1</a>
                                        <a class="nav-link {{ isset($id) && $id == 3 ? 'active' : '' }}"
                                            id="unbooked-jobs-tab" href="{{ route('reports.show', 3) }}" role="tab"
                                            aria-controls="unbooked-jobs" aria-selected="false">Unbooked
                                            Jobs</a>
                                        <a class="nav-link  {{ isset($id) && $id == 4 ? 'active' : '' }}"
                                            id="booked-jobs-tab" href="{{ route('reports.show', 4) }}" role="tab"
                                            aria-controls="booked-jobs" aria-selected="false">Booked Jobs</a>
                                        <a class="nav-link  {{ isset($id) && $id == 5 ? 'active' : '' }}" id="completed-tab"
                                            href="{{ route('reports.show', 5) }}" role="tab" aria-controls="completed"
                                            aria-selected="false">Completed during
                                            date range</a>
                                        <a class="nav-link  {{ isset($id) && $id == 6 ? 'active' : '' }}"
                                            id="passed-remedial-tab" href="{{ route('reports.show', 6) }}" role="tab"
                                            aria-controls="passed-remedial" aria-selected="false">Passed
                                            Remedial</a>
                                        <a class="nav-link  {{ isset($id) && $id == 7 ? 'active' : '' }}"
                                            id="failed-questions-tab" href="{{ route('reports.show', 7) }}" role="tab"
                                            aria-controls="failed-questions" aria-selected="false">Failed
                                            Questions</a>
                                        {{-- <a class="nav-link" id="jobs-with-visits-tab" data-toggle="pill"
                                            href="#jobs-with-visits" role="tab" aria-controls="jobs-with-visits"
                                            aria-selected="false">Jobs with Visits</a> --}}

                                    </div>
                                </div>
                                <div class="col-7 col-sm-9">
                                    @if (!isset($id) || $id == 1)
                                        @include('pages.reports.tab.job-with-nc')
                                    @elseif ($id == 2)
                                        @include('pages.reports.tab.job-with-cat1')
                                    @elseif ($id == 3)
                                        @include('pages.reports.tab.unbooked-job')
                                    @elseif ($id == 4)
                                        @include('pages.reports.tab.booked-job')
                                    @elseif ($id == 5)
                                        @include('pages.reports.tab.completed-job')
                                    @elseif ($id == 6)
                                        @include('pages.reports.tab.passed-remedial')
                                    @elseif ($id == 7)
                                        @include('pages.reports.tab.failed-questions')
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    {{-- <script>
        var toastType = @json(session('success'));
    </script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script> --}}
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/scheme.js') }}"></script> --}}
@endsection
