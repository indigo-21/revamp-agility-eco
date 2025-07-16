@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('content')
    <x-title-breadcrumbs title="Installer Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Installer Configuration', 'route' => '/installer-configuration', 'active' => ''],
        ['title' => 'Installer Form', 'route' => '', 'active' => 'active'],
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
                                        <i class="fa fa-pencil-alt mr-2"></i>
                                        Create Installer
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST"
                            action="{{ isset($installer) ? route('installer-configuration.update', $installer->id) : route('installer-configuration.store') }}">
                            @if (isset($installer))
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-input name="firstname" label="Name of Installer"
                                                    value="{{ isset($installer) ? $installer->user->firstname : '' }}" />

                                                <x-input name="email" label="Email" type="email"
                                                    value="{{ isset($installer) ? $installer->user->email : '' }}" />

                                                <x-select label="User Profile" name="user_type_id" :multiple="false">
                                                    <option value="{{ $userType->id }}" selected>{{ $userType->name }}
                                                    </option>
                                                </x-select>
                                            </div>

                                            <div class="col-md-6">
                                                <x-radio-layout label="28 Day Reminder">
                                                    <div class="col-md-6">
                                                        <x-radio label="Yes" name="sent_available" id="active_yes"
                                                            :checked="isset($installer) &&
                                                            $installer->sent_available === 1
                                                                ? true
                                                                : true" :value="1" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-radio label="No" name="sent_available" id="active_no"
                                                            :checked="isset($installer) &&
                                                            $installer->sent_available === 0
                                                                ? true
                                                                : false" :value="0" />
                                                    </div>
                                                </x-radio-layout>

                                                <x-input name="mobile" label="Contact Number" type="number"
                                                    value="{{ isset($installer) ? $installer->user->mobile : '' }}" />

                                                <x-input name="organisation" label="Organisation"
                                                    value="{{ isset($installer) ? $installer->user->organisation : '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <x-select label="Client" name="client" :multiple="false">
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                            <div class="col-md-4">
                                                <x-input name="tmln" label="TMLN" />
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end justify-content-center">
                                                <div class="form-group w-100">
                                                    <button type="button" class="btn bg-gradient-primary mr-2 w-100"
                                                        id="addClient">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="installerClientTable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Suffix</th>
                                                            <th>Client</th>
                                                            <th>TMLN</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit"
                                    class="btn btn-primary ">{{ isset($installer) ? 'Update' : 'Submit' }}</button>
                            </div>
                        </form>
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
    @include('includes.datatables-scripts')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Installer Script -->
    <script src="{{ asset('assets/js/installer-configuration.js') }}"></script>
@endsection
