@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="Manage Booking" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Manage Booking', 'route' => route('manage-booking.index'), 'active' => 'active'],
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
                                        List of Jobs
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="managebookings-table" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>Job Number</th>
                                                <th>Job Status</th>
                                                <th>Job PI</th>
                                                <th>Postcode</th>
                                                <th>Address</th>
                                                <th>Installer</th>
                                                <th>Measures</th>
                                                <th>Schedule Date</th>
                                                <th>Owner Name</th>
                                                <th>Owner Email</th>
                                                <th>Owner Contact Number</th>
                                                <th>Latest Comment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jobs as $job)
                                                @php
                                                    $relatedJobs = \App\Models\Job::where(
                                                        'job_number',
                                                        'LIKE',
                                                        "%{$job->job_group}%",
                                                    )->get();

                                                    $lastBooking = \App\Models\Booking::where(
                                                        'job_number',
                                                        $job->job_group,
                                                    )->orderBy('created_at', 'desc');
                                                @endphp
                                                <tr>
                                                    <td>{{ $job->job_group }}</td>
                                                    <td>
                                                        <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                            {{ $job->jobStatus->description }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $job->propertyInspector->user->firstname }}
                                                        {{ $job->propertyInspector->user->lastname }}
                                                    </td>
                                                    <td>{{ $job->property->postcode }}</td>
                                                    <td>{{ $job->property->house_flat_prefix }}
                                                        {{ $job->property->address1 }}</td>
                                                    <td>{{ $job->installer->user->firstname }}</td>
                                                    <td>
                                                        @foreach ($relatedJobs as $relatedJob)
                                                            <span
                                                                class="badge badge-info">{{ $relatedJob->jobMeasure->measure->measure_cat }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $job->schedule_date }}</td>
                                                    <td>{{ $job->customer->customer_name }}</td>
                                                    <td>{{ $job->customer->customer_email }}</td>
                                                    <td>{{ $job->customer->customer_primary_tel }}</td>
                                                    <td>
                                                        {{ $lastBooking->first()->booking_notes ?? 'No comments' }}
                                                    </td>
                                                    <td>
                                                        <form
                                                            action="{{ route('manage-booking.unbook', ['job_group' => $job->job_group]) }}"
                                                            method="POST" class="unbook-job-form">
                                                            @csrf
                                                            <div class="btn-group">
                                                                <x-button-permission type="create" :permission="$userPermission"
                                                                    as="a" :href="route('manage-booking.edit', [
                                                                        'job_group' => $job->job_group,
                                                                    ])"
                                                                    class="btn btn-sm btn-primary" label="Rebook" />
                                                                <x-button-permission type="update" :permission="$userPermission"
                                                                    class="btn btn-sm btn-warning unbook-job"
                                                                    label="Unbook" />
                                                                <x-button-permission type="delete" :permission="$userPermission"
                                                                    class="btn btn-sm btn-danger closeJob"
                                                                    data-job-number="{{ $job->job_group }}"
                                                                    label="Close" data-target="#closeJob"
                                                                    data-toggle="modal" />
                                                                <x-button-permission type="view" :permission="$userPermission"
                                                                    as="a" :href="route('make-booking.show', [
                                                                        'job_group' => $job->job_group,
                                                                    ])"
                                                                    class="btn btn-sm btn-secondary" label="History" />
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
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="closeJob" role="dialog" aria-labelledby="closeJobLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('make-booking.closeJob') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="closeJobLabel">Close Job</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" value="" name="job_number" id="job_number_closed_job" hidden>
                        <x-select label="Reason" name="booking_outcome" :multiple="false">
                            <option value="Wrong Contact Details">Wrong Contact Details</option>
                            <option value="Customer Refused">Customer Refused</option>
                            <option value="Job Deadline Expired">Job Deadline Expired</option>
                        </x-select>

                        <x-textarea name="booking_notes" label="Notes" rows="5" value="" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('importedScripts')
    <script>
        var toastType = @json(session('success'));
    </script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/booking.js') }}"></script>
@endsection
