@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Property Inspector</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Property Inspector</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-md-4">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/profile_images/' . $property_inspector->user->photo) }}"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>

                            <h3 class="profile-username text-center">{{ $property_inspector->user->firstname }}
                                {{ $property_inspector->user->lastname }}</h3>

                            <p class="text-muted text-center">{{ $property_inspector->user->organisation }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">
                                        @if ($property_inspector->status === 1)
                                            <span class="right badge badge-success">Active</span>
                                        @else
                                            <span class="right badge badge-danger">Inactive</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $property_inspector->user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Contact Number</b> <a class="float-right">
                                        {{ $property_inspector->user->mobile }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Address</strong>

                            <p class="text-muted">
                                {{ $property_inspector->address1 }}
                                {{ $property_inspector->address2 }}
                                {{ $property_inspector->address3 }}
                                {{ $property_inspector->city }}
                                {{ $property_inspector->county }}
                                {{ $property_inspector->postcode }}

                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Job Types</strong>

                            <p class="text-muted">
                                @if ($property_inspector->qai === 1)
                                    <span class="right badge badge-info">Qai</span>
                                @endif
                                @if ($property_inspector->assessor === 1)
                                    <span class="right badge badge-info">Assessor</span>
                                @endif
                                @if ($property_inspector->surveyor === 1)
                                    <span class="right badge badge-info">Surveyor</span>
                                @endif
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Employement Basis</strong>

                            <p class="text-muted">{{ $property_inspector->user->accountLevel->name }}</p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> List of Postcodes Covered</strong>

                            <p class="text-muted">
                                @foreach ($property_inspector->propertyInspectorPostcodes as $propertyInspectorPostcode)
                                    <span
                                        class="right badge badge-danger">{{ $propertyInspectorPostcode->outwardPostcode->name }}
                                    </span>
                                @endforeach
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Date Created</strong>

                            <p class="text-muted">
                                {{ $property_inspector->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-lg-9 col-md-8">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        List of Jobs
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile Phone Number</th>
                                        <th>Status</th>
                                        <th>Employment Status</th>
                                        <th>List of Postcodes Covered</th>
                                        <th>Employer</th>
                                        <th>Job Types</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card card-default collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Measures
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Measure Cat</th>
                                        <th>Measure Fee Value</th>
                                        <th>Measure Fee Currency</th>
                                        <th>Measure Expiry Date</th>
                                        <th>Measure Certicate</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($property_inspector) && $property_inspector->propertyInspectorMeasures)
                                        @foreach ($property_inspector->propertyInspectorMeasures as $pi_measure)
                                            <tr>
                                                <td>{{ $pi_measure->measure->measure_cat }}</td>
                                                <td>{{ $pi_measure->fee_value }}</td>
                                                <td>{{ $pi_measure->fee_currency }}</td>
                                                <td>{{ $pi_measure->expiry }}</td>
                                                <td>
                                                    <img src="{{ asset("storage/measure_certificate/$pi_measure->cert") }}"
                                                        width="auto" height="150" />
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm deleteRow">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card card-default collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Qualifications
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="qualificationsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Certificate</th>
                                        <th>Issue</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($property_inspector) && $property_inspector->propertyInspectorQualifications)
                                        @foreach ($property_inspector->propertyInspectorQualifications as $qualifications)
                                            <tr>
                                                <td>{{ $qualifications->name }}</td>
                                                <td>{{ $qualifications->issue_date }}</td>
                                                <td>{{ $qualifications->expiry_date }}</td>
                                                <td>
                                                    <img src="{{ asset("storage/qualification_certificate/$qualifications->certificate") }}"
                                                        width="auto" height="150" />
                                                </td>
                                                <td>{{ $qualifications->qualification_issue }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm deleteRow">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/property-inspector.js') }}"></script>
@endsection
