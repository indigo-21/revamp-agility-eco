@extends('layouts.app')

@section('importedStyles')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
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
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        List of Property Inspector
                                    </h3>
                                </div>
                                <div class="right">
                                    <a type="button" class="btn btn-block btn-outline-primary"
                                        href="{{ route('property-inspector.create') }}">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Property Inspector
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="propertyInspectorList" class="table table-bordered table-striped">
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
                                    @foreach ($property_inspectors as $property_inspector)
                                        <tr>
                                            <td>{{ $property_inspector->user->firstname }}
                                                {{ $property_inspector->user->lastname }}</td>
                                            <td>{{ $property_inspector->user->mobile }}
                                            </td>
                                            <td>
                                                @if ($property_inspector->status === 1)
                                                    <span class="right badge badge-success">Active</span>
                                                @else
                                                    <span class="right badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $property_inspector->user->accountLevel->name }}</td>
                                            <td>
                                                @foreach ($property_inspector->propertyInspectorPostcodes as $propertyInspectorPostcode)
                                                    <span
                                                        class="right badge badge-danger">{{ $propertyInspectorPostcode->outwardPostcode->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{ $property_inspector->pi_employer }}</td>
                                            <td>
                                                @if ($property_inspector->qai === 1)
                                                    <span class="right badge badge-info">QAI</span>
                                                @endif
                                                @if ($property_inspector->assessor === 1)
                                                    <span class="right badge badge-info">Assessor</span>
                                                @endif
                                                @if ($property_inspector->surveyor === 1)
                                                    <span class="right badge badge-info">Surveyor</span>
                                                @endif

                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('property-inspector.show', $property_inspector) }}"
                                                        class="btn btn-primary btn-sm">View</a>
                                                    <a href="{{ route('property-inspector.edit', $property_inspector) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('property-inspector.destroy', $property_inspector) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-btn">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </div>
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
    <script src="{{ asset('assets/js/property-inspector.js') }}"></script>
@endsection
