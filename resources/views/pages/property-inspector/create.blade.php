<x-app-layout>
    <x-slot name="importedLinks">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.steps/demo/css/jquery.steps.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" />
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
                                                <h3> General information </h3>
                                                <fieldset>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="name-2" class="block">First name
                                                                *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input id="name-2" name="name" type="text"
                                                                class="form-control required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="surname-2" class="block">Last name
                                                                *</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input id="surname-2" name="surname" type="text"
                                                                class="form-control required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="phone-2" class="block">Phone
                                                                #</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input id="phone-2" name="phone" type="number"
                                                                class="form-control required phone">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            <label for="date" class="block">Date Of
                                                                Birth</label>
                                                        </div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <input id="date" name="Date Of Birth" type="text"
                                                                class="form-control required date-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-4 col-lg-2">
                                                            Select Country</div>
                                                        <div class="col-md-8 col-lg-10">
                                                            <select class="form-control required">
                                                                <option>Select State
                                                                </option>
                                                                <option>Gujarat</option>
                                                                <option>Kerala</option>
                                                                <option>Manipur</option>
                                                                <option>Tripura</option>
                                                                <option>Sikkim</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </fieldset>
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
        <!-- Validation js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="{{ asset('dist/pages/form-validation/validate.js') }}"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
        <!-- Custom js -->
        <script src="{{ asset('assets/js/property-inspector-stepper.js') }}"></script>
    </x-slot>

</x-app-layout>
