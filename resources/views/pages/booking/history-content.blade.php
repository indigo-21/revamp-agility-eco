<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-body container">
                        <div class="card-body">
                            @if ($bookings->count() > 0)
                                @foreach ($bookings as $booking)
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm"
                                                src="../../dist/img/user1-128x128.jpg" alt="user image">
                                            <span class="username">
                                                <a href="#">{{ $booking->user->firstname }}
                                                    {{ $booking->user->lastname }}</a>
                                            </span>
                                            <span class="description">{{ $booking->booking_outcome }} -
                                                {{ $booking->created_at->format('g:i A') }}
                                                {{ $booking->created_at->isToday() ? 'today' : $booking->created_at->format('F j, Y') }}
                                            </span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            {{ $booking->booking_notes }}
                                        </p>
                                    </div>
                                    <!-- /.post -->
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info"></i> No bookings history found!</h5>
                                    You have no bookings yet.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Job Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Job Status</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->jobStatus->description }}
                                </p>
                                <hr>
                                <strong>Lodged By</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->lodged_by_name }}
                                </p>
                                <hr>
                                <strong>Job Requestor</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->client->user->firstname }}
                                    {{ $jobs->first()->client->user->lastname }}
                                </p>
                                <hr>
                                <strong>Job PI</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->propertyInspector->user->firstname }}
                                    {{ $jobs->first()->propertyInspector->user->lastname }}
                                </p>
                                <hr>
                                <strong>Cert No</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->cert_no }}
                                </p>
                                <hr>
                            </div>
                            <div class="col-md-6">

                                <strong>Owner Name</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->customer->customer_name }}
                                </p>
                                <hr>
                                <strong>Owner Email</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->customer->customer_email }}
                                </p>
                                <hr>
                                <strong>Contact Number</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->customer->customer_primary_tel }}
                                </p>
                                <hr>
                                <strong>Property Address</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->property->address1 }}
                                    {{ $jobs->first()->property->city }}

                                </p>
                                <hr>
                                <strong>Property County</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->property->county }}
                                </p>
                                <hr>
                                <strong>Property Postcode</strong>
                                <p class="text-muted">
                                    {{ $jobs->first()->property->postcode }}
                                </p>
                                <hr>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
