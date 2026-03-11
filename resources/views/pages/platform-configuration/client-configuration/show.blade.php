@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Client" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Client Configuration', 'route' => '/client-configuration', 'active' => ''],
        ['title' => 'Client - ' . $client->user->firstname, 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="d-flex flex-column align-items-center">
                                <h6
                                    style="background-color: #e7493a; color: #fff; border-radius: 50%; height: 90px; width: 90px;display: flex; align-items: center; justify-content: center; margin-bottom: 0; font-size: 2rem;">
                                    {{ $client->user->firstname[0] }}
                                </h6>
                            </div>
                            <h3 class="profile-username text-center">{{ $client->user->firstname }}</h3>

                            <p class="text-muted text-center">{{ $client->clientType->name }} -
                                {{ $client->client_abbrevation }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">
                                        @if ($client->clientKeyDetails->is_active === 1)
                                            <span class="right badge badge-success">Active</span>
                                        @else
                                            <span class="right badge badge-danger">Inactive</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $client->user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Contact Number</b> <a class="float-right">
                                        {{ $client->user->mobile }}
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Address</strong>

                            <p class="text-muted">
                                {{ $client->address1 }}
                                {{ $client->address2 }}
                                {{ $client->address3 }}
                                {{ $client->city }}
                                {{ $client->county }}
                                {{ $client->postcode }}

                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Job Types</strong>

                            <p class="text-muted">
                                @foreach ($client->clientJobTypes as $clientJobType)
                                    <span class="right badge badge-danger">{{ $clientJobType->jobType->type }}
                                    </span>
                                @endforeach
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Charging Scheme</strong>

                            <p class="text-muted">{{ $client->clientKeyDetails->chargingScheme->name }}</p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Date Created</strong>

                            <p class="text-muted">
                                {{ $client->created_at->diffForHumans() }}
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
                                        <th>Job Number</th>
                                        <th>Status</th>
                                        <th>Cert#</th>
                                        <th>UMR</th>
                                        <th>Postcode</th>
                                        <th>Installer</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_number }}</td>
                                            <td>
                                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                    {{ $job->jobStatus->description }}
                                                </span>
                                            </td>
                                            <td>{{ $job->cert_no }}</td>
                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->installer->user->firstname }}</td>
                                            <td>{{ $job->deadline }}</td>
                                        </tr>
                                    @endforeach
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
                                    <i class="fas fa-plus"></i>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->clientMeasures as $clientMeasure)
                                        <tr>
                                            <td>{{ $clientMeasure->measure->measure_cat }}</td>
                                            <td>{{ $clientMeasure->measure_fee }}</td>
                                            <td>{{ $clientMeasure->measure_fee_currency }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card card-default collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Installers
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
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
                                        <th>Installer</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Organisation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->clientInstallers as $clientInstaller)
                                        <tr>
                                            <td>{{ $clientInstaller->installer->user->firstname }}</td>
                                            <td>{{ $clientInstaller->installer->user->email }}</td>
                                            <td>{{ $clientInstaller->installer->user->mobile }}</td>
                                            <td>{{ $clientInstaller->installer->user->organisation }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
@endsection
