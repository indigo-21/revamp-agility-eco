@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="Edit Property Inspector: " {{ $job_data->propertyInspector->user->firstname }}
        :breadcrumbs="[
            ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
            ['title' => 'Edit PI', 'route' => '/make-booking', 'active' => ''],
            ['title' => $job_number, 'route' => '', 'active' => 'active'],
        ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-danger card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle "
                                    src="{{ asset('storage/profile_images/' . $job_data->propertyInspector->user->photo) }}"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ $job_data->propertyInspector->user->firstname }}
                                {{ $job_data->propertyInspector->user->lastname }}
                            </h3>

                            <p class="text-muted text-center">
                                {{ $job_data->propertyInspector->user->userType->name }}
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Employment Status</b> <a class="float-right">
                                        {{ $job_data->propertyInspector->user->accountLevel->name }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Postcodes will visit</b> <a class="float-right">
                                        @foreach ($job_data->propertyInspector->propertyInspectorPostcodes as $postcode)
                                            <span class="badge badge-info">
                                                {{ $postcode->outwardPostcode->name }}
                                            </span>
                                        @endforeach
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a
                                        class="float-right">{{ $job_data->propertyInspector->user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Contact Number</b> <a
                                        class="float-right">{{ $job_data->propertyInspector->user->mobile }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Address</b>
                                    <a class="float-right">
                                        {{ $job_data->propertyInspector->address1 }}
                                        {{ $job_data->propertyInspector->city }}
                                        {{ $job_data->propertyInspector->county }}
                                        {{ $job_data->propertyInspector->postcode }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-danger card-outline">
                        <div class="card-body box-profile">
                            <div class="callout callout-danger">
                                <h5>Note: </h5>

                                <p>Please select a Property Inspector</p>
                            </div>
                            <div hidden class="new-property-inspector">
                                <div class="text-center img-property-inspector">
                                </div>

                                <h3 class="profile-username text-center">
                                </h3>

                                <p class="text-muted text-center user-type">
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Employment Status</b> <a class="float-right employment-status">
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Postcodes will visit</b> <a class="float-right property-inspector-postcodes">
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right email"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Contact Number</b> <a class="float-right contact-number"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Address</b>
                                        <a class="float-right address">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-md-3">
                    <form action="{{ route('make-booking.editPISubmit', ['job_group' => $job_number]) }}" method="POST">
                        @csrf
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Edit PI</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class=" mb-3">
                                    <h5> <i class="fa fa-ruler "></i> Measures - {{ $job_number }}</h5>
                                    @foreach ($jobs as $job)
                                        <span class="badge badge-info">
                                            {{ $job->jobMeasure->measure->measure_cat }}
                                        </span>
                                    @endforeach
                                </div>

                                <x-select label="List of Property Inspector" name="property_inspector_id" :multiple="false">
                                    <option selected="selected" disabled value="">- Property Inspector -</option>
                                    @foreach ($property_inspectors as $property_inspector)
                                        <option value="{{ $property_inspector->id }}">
                                            {{ $property_inspector->user->firstname }}
                                            {{ $property_inspector->user->lastname }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-save"></i>
                                    Update Property Inspector
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/edit-pi.js') }}"></script>
@endsection
