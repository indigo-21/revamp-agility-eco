@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
    <x-title-breadcrumbs title="Sickness and Holidays" :breadcrumbs="[
        ['title' => 'PI Dashboard', 'route' => '/pi-dashboard', 'active' => ''],
        ['title' => 'Sickness and Holidays', 'route' => '/sickness-holidays', 'active' => ''],
        ['title' => 'Create Request', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fa fa-pencil-alt mr-2"></i>
                                        Create Request
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST"
                            action="{{ isset($sicknessHoliday) ? route('sickness-holidays.update', $sicknessHoliday->id) : route('sickness-holidays.store') }}">
                            @csrf
                            @if (isset($sicknessHoliday))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-date name="start_date" label="Start Date" required
                                            value="{{ isset($sicknessHoliday) ? $sicknessHoliday->start_date : '' }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-date name="end_date" label="End Date" required
                                            value="{{ isset($sicknessHoliday) ? $sicknessHoliday->end_date : '' }}" />
                                    </div>

                                    <div class="col-md-12">
                                        <x-textarea name="reason" label="Reason" rows="5" required
                                            value="{{ isset($sicknessHoliday) ? $sicknessHoliday->reason : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary d-block float-right">Submit</button>
                            </div>
                        </form>
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
    <!-- Select2 -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2();

            $('.date').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    time: 'far fa-clock'
                },
            });
        });
    </script>
@endsection
