@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }

        .nav-link.active {
            color: #000 !important;
        }

        .nav-link {
            color: #fff !important;
        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Document Exception</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Exeception</li>
                        <li class="breadcrumb-item active">Document Exception</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="document-tab" data-toggle="pill" href="#document"
                                        role="tab" aria-controls="document" aria-selected="true">Document Expiry</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" id="qualification-tab" data-toggle="pill"
                                        href="#qualification" role="tab" aria-controls="qualification"
                                        aria-selected="false">Qualification
                                        Expiry</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" id="measure-tab" data-toggle="pill" href="#measure"
                                        role="tab" aria-controls="measure" aria-selected="false">Measure Expiry</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade show active" id="document" role="tabpanel"
                                    aria-labelledby="document-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <h3>Document Expiry Exception</h3> --}}
                                            <table id="installerConfigurationTable"
                                                class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Property Inspector</th>
                                                        <th>Document Type</th>
                                                        <th>Document Name</th>
                                                        <th>Expiry Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($documentExpires as $document)
                                                        <tr>
                                                            <td>{{ $document->user->firstname }}
                                                                {{ $document->user->lastname }}</td>
                                                            <td>PHOTO</td>
                                                            <td>
                                                                <a href="{{ asset("storage/profile_images/{$document->user->photo}") }}"
                                                                    target="_blank">
                                                                    {{ $document->user->photo }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $document->photo_expiry }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.row (main row) -->
                                    </div><!-- /.container-fluid -->
                                </div>
                                <div class="tab-pane fade" id="qualification" role="tabpanel"
                                    aria-labelledby="qualification-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <h3>Qualification Expiry Exception</h3> --}}
                                            <table id="installerConfigurationTable"
                                                class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Property Inspector</th>
                                                        <th>Document Type</th>
                                                        <th>Document Name</th>
                                                        <th>Expiry Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($qualificationExpires as $qualification)
                                                        <tr>
                                                            <td>{{ $qualification->propertyInspector->user->firstname }}
                                                                {{ $qualification->propertyInspector->user->lastname }}</td>
                                                            <td>{{ $qualification->name }}</td>
                                                            <td>
                                                                <a href="{{ asset("storage/qualification_certificate/{$qualification->certificate}") }}"
                                                                    target="_blank">
                                                                    {{ $qualification->certificate }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $qualification->expiry_date }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.row (main row) -->
                                    </div><!-- /.container-fluid -->
                                </div>
                                <div class="tab-pane fade" id="measure" role="tabpanel" aria-labelledby="measure-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <h3>Measure Expiry Exception</h3> --}}
                                            <table id="installerConfigurationTable"
                                                class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Property Inspector</th>
                                                        <th>Document Type</th>
                                                        <th>Document Name</th>
                                                        <th>Expiry Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($measureExpires as $measure)
                                                        <tr>
                                                            <td>{{ $measure->propertyInspector->user->firstname }}
                                                                {{ $measure->propertyInspector->user->lastname }}
                                                            </td>
                                                            <td>{{ $measure->measure->measure_cat }}</td>
                                                            <td>
                                                                <a href="{{ asset("storage/measure_certificate/{$measure->cert}") }}"
                                                                    target="_blank">
                                                                    {{ $measure->cert }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $measure->expiry }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.row (main row) -->
                                    </div><!-- /.container-fluid -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('importedScripts')
    @include('includes.datatables-scripts')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
@endsection
