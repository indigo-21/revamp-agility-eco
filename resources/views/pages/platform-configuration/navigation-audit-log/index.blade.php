@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Navigation Audit Logs" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Navigation Audit Logs', 'route' => '', 'active' => 'active'],
    ]" />

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-history mr-2"></i>
                                        Navigation Audit Logs
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>User (name/email)</label>
                                        <input name="user" value="{{ request('user') }}" class="form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Link</label>
                                        <input name="link" value="{{ request('link') }}" class="form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Allowed?</label>
                                        <select name="allowed" class="form-control">
                                            <option value="">All</option>
                                            <option value="1" {{ request('allowed') === '1' ? 'selected' : '' }}>Allowed</option>
                                            <option value="0" {{ request('allowed') === '0' ? 'selected' : '' }}>Denied</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>From</label>
                                        <input type="date" name="from" value="{{ request('from') }}" class="form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>To</label>
                                        <input type="date" name="to" value="{{ request('to') }}" class="form-control" />
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button class="btn btn-primary w-100" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                {!! $dataTable->table() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('importedScripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @include('includes.datatables-scripts')
@endsection
