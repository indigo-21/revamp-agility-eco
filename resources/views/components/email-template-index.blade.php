@props(['messageTemplates', 'url', 'title'])

<x-title-breadcrumbs title="{{ $title }}" :breadcrumbs="[
    ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
    ['title' => $title, 'route' => '/' . $url, 'active' => ''],
]" />

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <div class="left">
                                <h3 class="card-title">
                                    <i class="fas fa-list mr-2"></i>
                                    List of Templates
                                </h3>
                            </div>
                            <div class="right">
                                <x-button-permission type="create" :permission="$userPermission" as="a" :href="route($url . '.create')"
                                    class="btn btn-white" label="Add Email Template" />
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible mx-3 mt-3">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Is Active</th>
                                    <th>Subject</th>
                                    <th>Message Content</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messageTemplates as $messageTemplate)
                                    <tr>
                                        <td>{{ $messageTemplate->name }}</td>
                                        <td>
                                            @if ($messageTemplate->is_active === 1)
                                                <span class="right badge badge-success">Active</span>
                                            @else
                                                <span class="right badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $messageTemplate->subject }}</td>
                                        <td>{!! $messageTemplate->content !!}</td>
                                        <td>
                                            <form action="{{ route($url . '.destroy', $messageTemplate->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <div class="btn-group">
                                                    <x-button-permission type="update" :permission="$userPermission" as="a"
                                                        :href="route($url . '.edit', $messageTemplate->id)" class="btn btn-primary btn-sm"
                                                        label="Edit" />
                                                    <x-button-permission type="delete" :permission="$userPermission"
                                                        class="btn btn-danger btn-sm delete-btn" label="Delete" />
                                                </div>
                                            </form>
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
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
