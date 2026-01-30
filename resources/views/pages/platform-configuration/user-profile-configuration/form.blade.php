@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="User Profile - {{ $accessLevel->name }}" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'User Profile - ' . $accessLevel->name, 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    {{-- <form action="{{ route('user-profile-configuration.update', $id) }}" method="POST"
                        id="user-profile-form">
                        @csrf
                        @method('PUT') --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        User Profile Configuration
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (in_array($accessLevel->name, ['Firm Admin', 'Firm Agent'], true))
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="firm_data_only" data-account_level="{{ $accountLevelId }}"
                                                {{ ($accessLevel->firm_data_only ?? false) ? 'checked' : '' }}>
                                            <label for="firm_data_only">Firm Data only</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Screen</th>
                                        <th>Can be accessed by this profile?</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($navigationLists as $navigation)
                                        {{-- <form action="{{ route('user-profile-configuration.update', $navigation->id) }}">
                                            @csrf
                                            @method('PUT') --}}
                                        <tr>
                                            <td>{{ $navigation->id }}</td>
                                            <td>{{ $navigation->name }}</td>
                                            <td>
                                                <div class="col-md-6">
                                                    <x-select label="" name="navigation"
                                                        id="navigation_{{ $navigation->id }}" :multiple="false"
                                                        data-account_level="{{ $accountLevelId }}"
                                                        data-navigation="{{ $navigation->id }}">
                                                        <option value="1"
                                                            {{ !empty($navigation->userNavigations->where('account_level_id', $accountLevelId)?->first()) ? 'selected' : '' }}>
                                                            {{-- data-account --}}
                                                            Yes
                                                        </option>
                                                        <option value="0"
                                                            {{ empty($navigation->userNavigations->where('account_level_id', $accountLevelId)?->first()) ? 'selected' : '' }}>
                                                            No
                                                        </option>
                                                    </x-select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="offset-md-1 col-md-3">
                                                        <x-radio class="radioPermission" label="View"
                                                            name="permission_{{ $navigation->id }}"
                                                            id="permission_{{ $navigation->id }}_1" :checked="$navigation->userNavigations
                                                                ->where('account_level_id', $accountLevelId)
                                                                ?->first()?->permission === 1
                                                                ? true
                                                                : false"
                                                            value="1" data-account_level="{{ $accountLevelId }}"
                                                            data-navigation="{{ $navigation->id }}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-radio class="radioPermission" label="View/Add/Edit"
                                                            name="permission_{{ $navigation->id }}"
                                                            id="permission_{{ $navigation->id }}_2" :checked="$navigation->userNavigations
                                                                ->where('account_level_id', $accountLevelId)
                                                                ?->first()?->permission === 2
                                                                ? true
                                                                : false"
                                                            value="2" data-account_level="{{ $accountLevelId }}"
                                                            data-navigation="{{ $navigation->id }}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-radio class="radioPermission" label="View/Add/Edit/Delete"
                                                            name="permission_{{ $navigation->id }}"
                                                            id="permission_{{ $navigation->id }}_3" :checked="$navigation->userNavigations
                                                                ->where('account_level_id', $accountLevelId)
                                                                ?->first()?->permission === 3
                                                                ? true
                                                                : false"
                                                            value="3" data-account_level="{{ $accountLevelId }}"
                                                            data-navigation="{{ $navigation->id }}" />
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- </form> --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/global/table.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/user-profile-configuration.js') }}"></script>
@endsection
