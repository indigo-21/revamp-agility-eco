<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Job Notes</h3>
    </div>
    <div class="col-md-12">
        <div class="card">
            <p class="p-3">
                {{ $job->notes ?? 'N/A' }}
            </p>
        </div>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Booking History</h3>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @forelse ($bookings as $booking)
                    <!-- Post -->
                    <div class="post">
                        <div class="user-block d-flex ">
                            <h6
                                style="background-color: #e7493a; color: #fff; border-radius: 50%; height: 40px; width: 40px;display: flex; align-items: center; justify-content: center; margin-bottom: 0;">
                                {{ Str::substr($booking->user?->firstname, 0, 1) }}{{ Str::substr($booking->user?->lastname, 0, 1) }}
                            </h6>
                            <div>
                                <span class="username" style="margin-left: 15px;">
                                    <a href="#">{{ $booking->user?->firstname }} {{ $booking->user?->lastname }} -
                                        {{ $booking->user?->accountLevel->name }}</a>
                                </span>
                                <span class="description" style="margin-left: 15px;">
                                    {{ Carbon\Carbon::parse($booking->created_at)->format('F j, Y') }}
                                    {{ $booking->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            <strong>Outcome: </strong>{{ $booking->booking_outcome }}
                            <br>
                            <strong>Comment: </strong>{!! $booking->booking_notes !!}
                        </p>
                    </div>
                    <!-- /.post -->
                @empty
                    <div>
                        <span class="text-muted">No bookings found.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
