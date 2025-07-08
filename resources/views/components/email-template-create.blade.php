@props(['messageTemplate' => null, 'url', 'title', 'upholdType' => false, 'remediationType' => false])

<x-title-breadcrumbs title="{{ $title }}" :breadcrumbs="[
    ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
    ['title' => $title, 'route' => '/' . $url, 'active' => ''],
    ['title' => 'Create Template', 'route' => '', 'active' => 'active'],
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
                                    Create Template
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->

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

                    <form method="POST"
                        action="{{ isset($messageTemplate) ? route($url . '.update', $messageTemplate->id) : route($url . '.store') }}">
                        @csrf
                        @if (isset($messageTemplate))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input name="name" label="Template Name"
                                        value="{{ isset($messageTemplate) ? $messageTemplate->name : '' }}"
                                        :required="true" />
                                    <x-input name="subject" label="Subject"
                                        value="{{ isset($messageTemplate) ? $messageTemplate->subject : '' }}"
                                        :required="true" />
                                </div>
                                <div class="col-md-6">
                                    <x-radio-layout label="Active / Inactive">
                                        <div class="col-md-6">
                                            <x-radio label="Active" name="is_active" id="active" :checked="isset($messageTemplate)
                                                ? ($messageTemplate->is_active == 1
                                                    ? true
                                                    : false)
                                                : true"
                                                :value="1" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-radio label="Inactive" name="is_active" id="inactive" :checked="isset($messageTemplate)
                                                ? ($messageTemplate->is_active == 0
                                                    ? true
                                                    : false)
                                                : false"
                                                :value="0" />
                                        </div>
                                    </x-radio-layout>
                                    @error('is_active')
                                        <div class="text-danger mt-1">
                                            <small>{{ $message }}</small>
                                        </div>
                                    @enderror
                                    <br>
                                    @if ($upholdType)
                                        <x-radio-layout label="Uphold Type">
                                            <div class="col-md-6">
                                                <x-radio label="Remediation" name="uphold_type" id="remediation"
                                                    :checked="isset($messageTemplate)
                                                        ? ($messageTemplate->uphold_type == 'remediation'
                                                            ? true
                                                            : false)
                                                        : true" :value="'remediation'" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-radio label="Appeal" name="uphold_type" id="appeal"
                                                    :checked="isset($messageTemplate)
                                                        ? ($messageTemplate->uphold_type == 'appeal'
                                                            ? true
                                                            : false)
                                                        : false" :value="'appeal'" />
                                            </div>
                                        </x-radio-layout>
                                    @endif
                                    
                                    @if ($remediationType)
                                        <x-radio-layout label="Remediation Type">
                                            <div class="col-md-6">
                                                <x-radio label="Non-Compliant/Unable to Validate" name="remediation_type" id="nc"
                                                    :checked="isset($messageTemplate)
                                                        ? ($messageTemplate->remediation_type == 'nc'
                                                            ? true
                                                            : false)
                                                        : true" :value="'nc'" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-radio label="CAT1" name="remediation_type" id="cat1"
                                                    :checked="isset($messageTemplate)
                                                        ? ($messageTemplate->remediation_type == 'cat1'
                                                            ? true
                                                            : false)
                                                        : false" :value="'cat1'" />
                                            </div>
                                        </x-radio-layout>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <textarea id="summernote" name="content" required>
                                           {!! isset($messageTemplate) ? $messageTemplate->content : '' !!}
                                        </textarea>
                                </div>
                                <div class="col-md-4">
                                    <div class="card ">
                                        <div class="card-header">
                                            <h3 class="card-title">Information</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="alert alert-info alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-info"></i> Note</h5>
                                                Use these parameters to dynamically replace placeholder values in the
                                                email
                                                template. Each parameter will be substituted with actual data during the
                                                email generation process.
                                            </div>
                                            {{ $slot }}
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary d-block float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
