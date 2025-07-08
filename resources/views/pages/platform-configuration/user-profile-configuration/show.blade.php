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
                    <h1 class="m-0">User Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">User Profile </li>
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
                    <form action="{{ route('user-profile-configuration.update', $id ) }}" method="POST" id="user-profile-form">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <div class="w-100 d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <h3 class="card-title">
                                            <i class="fas fa-list mr-2"></i>
                                            Bordered Table
                                        </h3>
                                    </div>
                                    <div class="right">
                                        <button type="submit" class=" btn btn-white mb-2" data-toggle="modal"
                                            data-target="">
                                            <i class="fa fa-plus-square mr-1" aria-hidden="true"></i>Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
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
                                        @php
                                            // print($navigations);
                                            // die();
                                        @endphp
                                        @foreach ($userNavigations as $userNavigation)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $userNavigation->navigation->name }}</td>
                                                <td>
                                                    <div class="col-md-6">
                                                        <x-select label="" name="accessed[{{ $userNavigation->navigation_id }}]" :multiple="false">
                                                            <option value="1"
                                                                {{ $userNavigation->accessed == 1 ? 'selected' : '' }}> Yes
                                                            </option>
                                                            <option value="0"
                                                                {{ $userNavigation->accessed == 0 ? 'selected' : '' }}> No
                                                            </option>
                                                        </x-select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <x-radio label="View" name="permission" id="permission"
                                                        checked="checked" />
                                                    <x-radio label="View/Add/Edit" name="permission" id="permission" />
                                                    <x-radio label="View/Add/Edit/Delete" name="permission"
                                                        id="permission" />
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
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
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/survey-question-set.js') }}"></script>
@endsection
