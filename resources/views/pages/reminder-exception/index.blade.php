@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <x-title-breadcrumbs title="28 Reminder Exception" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => '28 Reminder Exception', 'route' => '', 'active' => 'active'],
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
                            {{-- <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Number</th>
                                        <th>Job Status</th>
                                        <th>Cert No</th>
                                        <th>UMR</th>
                                        <th>Installer</th>
                                        <th>CAT Measure</th>
                                        <th>Address</th>
                                        <th>Postcode</th>
                                        <th>Non-Comliance Type</th>
                                        <th>Inspection Date</th>
                                        <th>Evidence Submission Date</th>
                                        <th>Remediation Deadline</th>
                                        <th>Reminder Sent</th>
                                        <th>Reinspect Deadline</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_number }}</td>
                                            <td>
                                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                    {{ $job->jobStatus->description }}
                                                </span>
                                            </td>
                                            <td>{{ $job->cert_no }}</td>
                                            <td>{{ $job->jobMeasure->umr }}</td>
                                            <td>{{ $job->installer->user->firstname }}</td>
                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                            <td>{{ $job->property->address1 }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->job_remediation_type }}</td>
                                            <td>{{ $job->schedule_date }}</td>
                                            <td>{{ $job->remediation->last()?->created_at }}</td>
                                            <td>{{ $job->rework_deadline }}</td>
                                            <td>{{ $job->sent_reminder ? 'Yes' : 'No' }}</td>
                                            <td>{{ Carbon\Carbon::parse($job->remediation->last()?->created_at)->addDays(21)->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <x-button-permission type="create" :permission="$userPermission" as="a"
                                                        :href="route('remediation-review.show', $job->id)" class="btn btn-primary btn-sm"
                                                        label="View Details" />
                                                    <x-button-permission type="update" :permission="$userPermission"
                                                        class="btn btn-warning btn-sm createReminder"
                                                        data-id="{{ $job->id }}" label="Create Reminder"
                                                        data-target="#createReminder" data-toggle="modal"
                                                        data-id="{{ $job->id }}"
                                                        data-installer="{{ $job->installer }}" />
                                                    <x-button-permission type="delete" :permission="$userPermission"
                                                        class="btn btn-danger btn-sm closeJob" label="Close Job"
                                                        data-target="#closeJob" data-toggle="modal"
                                                        data-id="{{ $job->id }}" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
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

        <!-- Modal -->
        <div class="modal fade" id="createReminder" role="dialog" aria-labelledby="createReminderLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" class="reminder-exception" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createReminderLabel">Close Job</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="" name="installer_id" id="installer_id" hidden>
                            <input type="text" value="" name="job_id" id="job_id" hidden>
                            <x-input type="text" name="installer_name" label="Installer Name" value=""
                                :disabled="true" />
                            <x-input type="text" name="invoices_outstanding_since" label="Invoices Outstanding Since"
                                value="" required />
                            <div class="row">
                                <div class="col-md-8">
                                    <x-input type="text" name="credit_note_value" label="Credit Note Value"
                                        value="" type="number" required />
                                </div>
                                <div class="col-md-4">
                                    <x-input type="text" name="currency" label="Currency" value="GBP" readonly />
                                </div>
                            </div>
                            <x-file name="attachment" label="Email PDF Attachment" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send Email</button>
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
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/js/reminder-exception.js') }}"></script>
@endsection
