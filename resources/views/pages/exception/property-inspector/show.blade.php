@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('content')
    <x-title-breadcrumbs title="Assign Property Inspector" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Property Inspector Exception', 'route' => '/property-inspector-exception', 'active' => ''],
        ['title' => 'Assign Property Inspector', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-body">
                            <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Property Inspector</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($propertyInspectors as $propertyInspector)
                                        <tr>
                                            <td>{{ $propertyInspector->user->firstname }}
                                                {{ $propertyInspector->user->lastname }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary viewDetails btn-sm"
                                                    data-id="{{ $propertyInspector->id }}">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom" hidden>
                        <div class="row mb-4">
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-block allocatePi"
                                    data-job-number="{{ $job_number }}" data-id="">Allocate PI</button>
                            </div>
                            {{-- <div class="col">
                                <a href="{{ route('job.show', $job->id) }}" class="btn btn-warning btn-block">View Job
                                    Details</a>
                            </div> --}}
                            <div class="col">
                                <a href="#" class="btn btn-info btn-block viewPi">View PI Details</a>
                            </div>
                        </div>
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user shadow">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username">Alexander Pierce</h3>
                                <h5 class="widget-user-desc">Founder &amp; CEO</h5>
                            </div>
                            <div class="widget-user-image">
                                {{-- <img class="img-circle elevation-2" src="../dist/img/user1-128x128.jpg" alt="User Avatar"> --}}

                                {{-- <h6
                                style="background-color: #e7493a; color: #fff; border-radius: 50%; height: 90px; width: 90px;display: flex; align-items: center; justify-content: center; margin-bottom: 0; font-size: 2rem;">
                                CJ
                            </h6> --}}
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header bookedJobs"></h5>
                                            <span class="description-text">Booked</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header unbookedJobs"></h5>
                                            <span class="description-text">Unbooked</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header otherJobs"></h5>
                                            <span class="description-text">Others</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                    <!-- /.widget-user -->

                    <div class="default">
                        <div class="callout callout-danger">
                            <h5>Note:</h5>

                            <p>Please select a property inspector to allocate on this Job.</p>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/assign-pi.js') }}"></script>
@endsection
