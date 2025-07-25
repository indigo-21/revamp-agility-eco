@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="Make Booking" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Make Booking', 'route' => '/make-booking', 'active' => ''],
        ['title' => $job_number, 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-body container">
                            <form action="{{ route('make-booking.book', ['job_group' => $job_number]) }}" method="POST">
                                @csrf
                                <div class="card card-widget widget-user-2">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header bg-default">
                                        <div class="widget-user-image">
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/profile_images/' . $job->propertyInspector->user->photo) }}"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <!-- /.widget-user-image -->
                                        <h3 class="widget-user-username" data-id="{{ $job->propertyInspector->id }}">
                                            {{ $job->propertyInspector->user->firstname }}
                                            {{ $job->propertyInspector->user->lastname }}</h3>
                                        <h6 class="widget-user-desc">{{ $job->propertyInspector->user->accountLevel->name }}
                                        </h6>
                                    </div>
                                    <div class="card-footer p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Deadline <span
                                                        class="float-right">{{ \Carbon\Carbon::parse($job->deadline)->format('F j, Y') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    First Visit By <span
                                                        class="float-right">{{ \Carbon\Carbon::parse($job->first_visit_by)->format('F j, Y') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <x-date name="booking_date" label="Schedule Date and Time" required />

                                <x-textarea name="booking_notes" label="Notes" rows="5" value="" required />

                                <button class="btn btn-primary mt-4">Submit Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-body container">
                            <div id="calendar"></div>
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
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/make-booking.js') }}"></script>
@endsection
