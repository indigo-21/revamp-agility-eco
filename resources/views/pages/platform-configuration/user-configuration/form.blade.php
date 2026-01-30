@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }

        .password-requirements {
            font-size: 0.875rem;
        }

        .password-req {
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }

        .password-req.valid i {
            color: #28a745 !important;
        }

        .password-req.valid span {
            color: #28a745;
            text-decoration: line-through;
        }

        .password-req.valid i:before {
            content: "\f00c";
            /* fa-check */
        }

        .password-strength {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .strength-weak {
            background-color: #dc3545;
            width: 25%;
        }

        .strength-fair {
            background-color: #fd7e14;
            width: 50%;
        }

        .strength-good {
            background-color: #ffc107;
            width: 75%;
        }

        .strength-strong {
            background-color: #28a745;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <x-title-breadcrumbs title="User Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'User Configuration', 'route' => '/user-configuration', 'active' => ''],
        ['title' => isset($user) ? 'Edit User' : 'Create User', 'route' => '', 'active' => 'active'],
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
                                        {{ isset($user) ? 'Edit User' : 'Create User' }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST"
                            action="{{ isset($user) ? route('user-configuration.update', $user->id) : route('user-configuration.store') }}"
                            enctype="multipart/form-data">
                            @if (isset($user))
                                @method('PUT')
                            @endif
                            @csrf

                            <!-- Display validation errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger mx-3 mt-3">
                                    <h5><i class="icon fas fa-ban"></i> Validation Error!</h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-file name="photo" label="Photo" />
                                        @error('photo')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <x-input name="firstname" label="Firstname" :required="true"
                                            value="{{ old('firstname', isset($user) ? $user->firstname : '') }}" />
                                        @error('firstname')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <x-input name="lastname" label="Lastname"
                                            value="{{ old('lastname', isset($user) ? $user->lastname : '') }}" />
                                        @error('lastname')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <x-input name="email" label="Email" type="email" :required="true"
                                            value="{{ old('email', isset($user) ? $user->email : '') }}" />
                                        @error('email')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        {{-- @if (!isset($user))
                                            <x-input name="password" label="Password" type="password" :required="true" id="password" />
                                            @error('password')
                                                <div class="text-danger small mb-2">{{ $message ?? '' }}</div>
                                            @enderror

                                            <!-- Password Requirements -->
                                            <div class="password-requirements mt-2 mb-3">
                                                <small class="text-muted">Password must contain:</small>
                                                <ul class="list-unstyled ml-3 mt-1">
                                                    <li id="length-req" class="password-req">
                                                        <i class="fas fa-times text-danger"></i>
                                                        <span class="ml-1">At least 8 characters</span>
                                                    </li>
                                                    <li id="uppercase-req" class="password-req">
                                                        <i class="fas fa-times text-danger"></i>
                                                        <span class="ml-1">One uppercase letter (A-Z)</span>
                                                    </li>
                                                    <li id="lowercase-req" class="password-req">
                                                        <i class="fas fa-times text-danger"></i>
                                                        <span class="ml-1">One lowercase letter (a-z)</span>
                                                    </li>
                                                    <li id="number-req" class="password-req">
                                                        <i class="fas fa-times text-danger"></i>
                                                        <span class="ml-1">One number (0-9)</span>
                                                    </li>
                                                    <li id="special-req" class="password-req">
                                                        <i class="fas fa-times text-danger"></i>
                                                        <span class="ml-1">One special character (!@#$%^&*)</span>
                                                    </li>
                                                </ul>

                                                <!-- Password Strength Indicator -->
                                                <div class="password-strength">
                                                    <div class="password-strength-bar" id="password-strength-bar"></div>
                                                </div>
                                                <small id="password-strength-text" class="text-muted mt-1 d-block"></small>
                                            </div>

                                            <x-input name="password_confirmation" label="Confirm Password" type="password"
                                                :required="true" id="password_confirmation" />
                                            @error('password_confirmation')
                                                <div class="text-danger small mb-2">{{ $message ?? '' }}</div>
                                            @enderror
                                        @endif --}}
                                    </div>

                                    <div class="col-md-6">
                                        <x-input name="mobile" label="Mobile" type="text" :required="true"
                                            value="{{ old('mobile', isset($user) ? $user->mobile : '') }}" />
                                        @error('mobile')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <x-input name="landline" label="Landline" type="text"
                                            value="{{ old('landline', isset($user) ? $user->landline : '') }}" />
                                        @error('landline')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <x-input name="organisation" label="Organisation" :required="true"
                                            value="{{ old('organisation', isset($user) ? $user->organisation : '') }}" />
                                        @error('organisation')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror
                                        <x-select label="Account Level" name="account_level_id" :multiple="false"
                                            :required="true" :disabled="isset($user) && in_array($user->account_level_id, [4, 5])">
                                            <option selected="selected" disabled value="">- Select Account Level -
                                            </option>
                                            @if (isset($user) && in_array($user->account_level_id, [6, 7, 8]))
                                                @foreach ($piLevels as $piLevel)
                                                    <option value="{{ $piLevel->id }}"
                                                        {{ old('account_level_id', isset($user) ? $user->account_level_id : '') == $piLevel->id ? 'selected' : '' }}>
                                                        {{ $piLevel->name }}
                                                    </option>
                                                @endforeach
                                            @elseif (isset($user) && in_array($user->account_level_id, [1, 2, 3, 9, 10]))
                                                @foreach ($adminLevels as $adminLevel)
                                                    <option value="{{ $adminLevel->id }}"
                                                        {{ old('account_level_id', isset($user) ? $user->account_level_id : '') == $adminLevel->id ? 'selected' : '' }}>
                                                        {{ $adminLevel->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($accountLevels as $accountLevel)
                                                    <option value="{{ $accountLevel->id }}"
                                                        {{ old('account_level_id', isset($user) ? $user->account_level_id : '') == $accountLevel->id ? 'selected' : '' }}>
                                                        {{ $accountLevel->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </x-select>
                                        @if (isset($user) && in_array($user->account_level_id, [4, 5]))
                                            <input type="hidden" name="account_level_id"
                                                value="{{ old('account_level_id', $user->account_level_id) }}">
                                        @endif
                                        @error('account_level_id')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror

                                        <x-select label="User type" name="user_type_id" :multiple="false" :required="true"
                                            :disabled="isset($user) && in_array($user->user_type_id, [3, 4, 5])">
                                            <option selected="selected" disabled value="">- Select User Type -
                                            </option>
                                            @foreach ($userTypes as $userType)
                                                <option value="{{ $userType->id }}"
                                                    {{ old('user_type_id', isset($user) ? $user->user_type_id : '') == $userType->id ? 'selected' : '' }}>
                                                    {{ $userType->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        @if (isset($user) && in_array($user->user_type_id, [3, 4, 5]))
                                            <input type="hidden" name="user_type_id"
                                                value="{{ old('user_type_id', $user->user_type_id) }}">
                                        @endif
                                        @error('user_type_id')
                                            <div class="text-danger small mb-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($user) ? 'Update User' : 'Create User' }}
                                </button>
                                @if (isset($user))
                                    <button type="button" id="resetpassword" class="btn btn-warning"
                                        data-id="{{ $user->id }}">Reset Password</button>
                                    <a href="{{ route('user-configuration.index') }}"
                                        class="btn btn-secondary ml-2">Cancel</a>
                                @endif
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
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/js/user-configuration-form.js') }}"></script>
@endsection
