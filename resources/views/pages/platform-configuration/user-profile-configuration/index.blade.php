@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="User Profile Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'User Profile Configuration', 'route' => '', 'active' => 'active'],
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
                                        List of User Profile
                                    </h3>
                                </div>
                                {{-- <div class="right">
                                    <button type="button" class=" btn btn-white mb-2" data-toggle="modal"
                                        data-target="#upload-csv">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Add New User Profile
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>User Profiles </th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($accountLevels as $accountLevel)
                                        <tr>
                                            <td>{{ $accountLevel->id }}</td>
                                            <td>{{ $accountLevel->name }}</td>
                                            <td>

                                                {{-- <form
                                                    action="{{ route('user-profile-configuration.destroy', $accountLevel->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE') --}}
                                                <div class="btn-group">
                                                    {{-- <a href="{{ route('user-profile-configuration.show', $accountLevel->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i> View
                                                        </a> --}}
                                                    <x-button-permission type="update" :permission="$userPermission" as="a"
                                                        :href="route('user-profile-configuration.edit', $accountLevel->id)" class="btn btn-primary btn-sm" label="Edit" />
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this user profile?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button> --}}
                                                </div>
                                                {{-- </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/survey-question-set.js') }}"></script>
@endsection
