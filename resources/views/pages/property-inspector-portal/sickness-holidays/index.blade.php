@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Sickness and Holidays" :breadcrumbs="[
        ['title' => 'PI Dashboard', 'route' => '/pi-dashboard', 'active' => ''],
        ['title' => 'Sickness and Holidays', 'route' => '', 'active' => 'active'],
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
                                        <i class="fas fa-list mr-2"></i>
                                        List of Leave Requests
                                    </h3>
                                </div>
                                <div class="right">
                                    <a class="btn btn-white mb-2" href="{{ route('sickness-holidays.create') }}">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Add Request
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Reason</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sicknessHolidays as $sicknessHoliday)
                                        <tr>
                                            <td>
                                                {{ $sicknessHoliday->propertyInspector->user->firstname }}
                                                {{ $sicknessHoliday->propertyInspector->user->lastname }}
                                            </td>
                                            <td>
                                                {{ $sicknessHoliday->reason }}
                                            </td>
                                            <td>
                                                {{ $sicknessHoliday->start_date }}
                                            </td>
                                            <td>
                                                {{ $sicknessHoliday->end_date }}
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('sickness-holidays.destroy', $sicknessHoliday->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group">
                                                        <x-button-permission type="update" :permission="$userPermission" as="a"
                                                            :href="route(
                                                                'sickness-holidays.edit',
                                                                $sicknessHoliday->id,
                                                            )" class="btn btn-primary btn-sm"
                                                            label="Edit" />
                                                        <x-button-permission type="delete" :permission="$userPermission"
                                                            class="btn btn-danger btn-sm delete-btn" label="Delete" />
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script>
        var toastType = @json(session('success'));
    </script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <script src="{{ asset('assets/js/sickness-holiday.js') }}"></script>
@endsection
