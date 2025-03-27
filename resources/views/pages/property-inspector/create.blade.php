<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.steps/demo/css/jquery.steps.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" />
        <!-- jquery file upload Frame work -->
        <link href="{{ asset('dist/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('dist/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css"
            rel="stylesheet" />
    </x-slot>

    <x-slot name="content">
        <div class="page-body">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <div class="d-inline">
                                <h4>Property Inspector - Create</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="page-header-breadcrumb">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item" style="float: left;">
                                    <a href="../index.html"> <i class="feather icon-home"></i> </a>
                                </li>
                                <li class="breadcrumb-item" style="float: left;"><a href="#!">Bootstrap Table</a>
                                </li>
                                <li class="breadcrumb-item" style="float: left;"><a href="#!">Basic
                                        Initialization</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Form wizard with validation card start -->
                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="wizard">
                                        <section>
                                            <form class="wizard-form" id="example-advanced-form" action="#">
                                                <h3> Registration </h3>
                                                @include('pages.property-inspector.stepper.job-skills')
                                                <h3> Photo & ID </h3>
                                                @include('pages.property-inspector.stepper.photo-and-id')
                                                <h3> Name & Address </h3>
                                                @include('pages.property-inspector.stepper.name-and-address')
                                                <h3> Commercials </h3>
                                                @include('pages.property-inspector.stepper.commercials')
                                                <h3> Measures </h3>
                                                @include('pages.property-inspector.stepper.measures')
                                                <h3> Qualifications </h3>
                                                @include('pages.property-inspector.stepper.qualifications')
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form wizard with validation card end -->
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="pageScripts">
        <!--Forms - Wizard js-->
        <script src="{{ asset('plugins/jquery.cookie/jquery.cookie.js') }}"></script>
        <script src="{{ asset('plugins/jquery.steps/build/jquery.steps.js') }}"></script>
        <script src="{{ asset('plugins/jquery-validation/dist/jquery.validate.js') }}"></script>
        <!-- jquery file upload js -->
        <script src="{{ asset('dist/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
        <!-- Validation js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="{{ asset('dist/pages/form-validation/validate.js') }}"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
        <!-- Custom js -->
        <script src="{{ asset('assets/js/property-inspector-stepper.js') }}"></script>
    </x-slot>

</x-app-layout>
