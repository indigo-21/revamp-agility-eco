@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <x-title-breadcrumbs title="Remediation Review" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Remediation', 'route' => '', 'active' => 'active'],
        ['title' => 'Remediation Review', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Inspected Jobs with Identified Non-Comliance
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->

        <!-- Modal -->
        <div class="modal fade" id="closeJob" role="dialog" aria-labelledby="closeJobLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" class="remediation-form">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="closeJobLabel">Close Job</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="" name="job_status_id" id="job_number_closed_job" hidden>
                            <x-select label="Reason" name="job_status_id" :multiple="false">
                                <option value="32">Remediation Response Time Expired</option>
                                <option value="33">Appeal Response Time Expired</option>
                                <option value="34">Maximum Number of Appeals Reached</option>
                                <option value="35">Maximum Number of Remediation Attempts Reached</option>
                            </x-select>

                            <x-textarea name="notes" label="Notes" rows="5" value="" required />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('importedScripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/global/table.js') }}"></script> --}}
    <script src="{{ asset('assets/js/remediation.js') }}"></script>
@endsection
