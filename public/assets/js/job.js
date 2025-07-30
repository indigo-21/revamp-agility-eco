
$(function () {

    $('.select2').select2({
        sorter: function (data) {
            return data.sort(function (a, b) {
                return a.text.localeCompare(b.text);
            });
        }
    });

    $('#jobDateRange').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        autoUpdateInput: false
    });

    $('#jobDateRange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#jobDateRange').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        // Get current URL and add query parameters
        var url = new URL(window.location.href);
        var params = new URLSearchParams(formData);

        // Clear existing parameters
        url.search = '';

        // Add new parameters
        params.forEach(function (value, key) {
            if (value) {
                url.searchParams.append(key, value);
            }
        });

        // Reload the page with new parameters
        window.location.href = url.toString();
    });

    // Update job count when DataTable is loaded
    $(document).ready(function () {
        // Wait for DataTable to be initialized
        setTimeout(function () {
            if ($.fn.DataTable.isDataTable('#jobs-table')) {
                var table = $('#jobs-table').DataTable();

                // Update count on initial load
                updateJobCount(table);

                // Update count when table is redrawn (search, filter, etc.)
                table.on('draw', function () {
                    updateJobCount(table);
                });
            }
        }, 1000);
    });

    function updateJobCount(table) {
        var filteredRecords = table.page.info().recordsDisplay;

        $('#totalNoOfJobs').text(filteredRecords);
    }

    bsCustomFileInput.init();

    $('#client_id').on('change', function () {
        $.ajax({
            url: '/client/search-job-types',
            type: 'GET',
            data: {
                client_id: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#job_type_id').empty();
                $('#job_type_id').append('<option value="" disabled selected> - Select Job Type - </option>');
                $.each(data[0].client_job_types, function (key, value) {
                    console.log(value);
                    $('#job_type_id').append('<option value="' + value.job_type.id + '">' + value.job_type.type + '</option>');
                });
                $("#job_type_id").prop('disabled', false);
            },
            error: function (xhr, status, error) {
                console.error("There was an error with the request: ", status, error);  // Handle errors
                console.error(xhr.responseText);
            }
        })
    });

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    if (typeof toastType !== 'undefined' && toastType) {
        Toast.fire({
            icon: 'success',
            title: toastType
        });
    }

    $(document).on('click', '.closeJobBtn', function () {
        const jobId = $(this).data('id');
        const closeJobForm = $(".close-job-form");
        closeJobForm.attr('action', '/job/' + jobId + '/closeJob');
    });
});

$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();
    const form = $(this).closest('.delete-form');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        imageUrl: '../assets/images/danger.png', // Use imageUrl instead of icon
        imageWidth: 100, // Optional: set image width
        imageHeight: 90, // Optional: set image height
        imageAlt: 'Custom delete icon', // Optional: alt text for accessibility
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

$('#removeDuplicates').on('click', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will remove duplicate jobs.",
        imageUrl: '../assets/images/danger.png', // Use imageUrl instead of icon
        imageWidth: 80, // Optional: set image width
        imageHeight: 80, // Optional: set image height
        imageAlt: 'Custom delete icon', // Optional: alt text for accessibility
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove duplicates!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/remove-duplicates',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire(
                        'Removed!',
                        response.message,
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'There was an error removing duplicates.',
                        'error'
                    );
                }
            });
        }
    });
});

// Queue Progress Tracking
$(document).ready(function () {
    let progressInterval;
    let progressContainer = $('#queueProgressContainer');

    // Start progress tracking if enabled
    if (showProgress && progressContainer.length > 0) {
        startProgressTracking();
    }

    // Hide progress button
    $('#hideProgressBtn').click(function () {
        stopProgressTracking();
        progressContainer.hide();
        $('#successAlert').find('#hideProgressBtn').hide();
    });

    // Refresh progress button
    $('#refreshProgressBtn').click(function () {
        updateProgress();
    });

    function startProgressTracking() {
        // Initial update
        updateProgress();

        // Set up interval for updates every 3 seconds
        progressInterval = setInterval(function () {
            updateProgress();
        }, 3000);
    }

    function stopProgressTracking() {
        if (progressInterval) {
            clearInterval(progressInterval);
            progressInterval = null;
        }
    }

    function updateProgress() {
        $.ajax({
            url: "api/queue-status",
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    updateProgressUI(response.data);

                    // Stop tracking if completed
                    if (response.data.status === 'completed') {
                        stopProgressTracking();
                        showCompletionMessage();
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch progress:', error);
                $('#statusText').text('Error fetching progress. Please refresh the page.');
            }
        });
    }

    function updateProgressUI(data) {
        // Update progress bar
        let percentage = Math.max(0, Math.min(100, data.progress_percentage));
        $('#progressBar').css('width', percentage + '%');
        $('#progressBar').attr('aria-valuenow', percentage);
        $('#progressPercentage').text(percentage.toFixed(1) + '%');

        // Update statistics
        $('#totalJobs').text(data.initial_count || initialDataCount);
        $('#processedJobs').text(data.processed);
        $('#pendingJobs').text(data.total_pending);
        $('#failedJobs').text(data.failed_jobs);

        // Update status text
        let statusText = '';
        if (data.is_processing) {
            statusText = `Processing ${data.total_pending} remaining jobs...`;
            $('#progressBar').addClass('progress-bar-animated');
        } else {
            statusText = 'All jobs completed successfully!';
            $('#progressBar').removeClass('progress-bar-animated');
        }

        if (data.failed_jobs > 0) {
            statusText += ` (${data.failed_jobs} failed)`;
        }

        $('#statusText').text(statusText);

        // Update progress text
        let progressText = `${data.processed}/${data.initial_count || initialDataCount} completed`;
        if (data.failed_jobs > 0) {
            progressText += ` (${data.failed_jobs} failed)`;
        }
        $('#progressText').text(progressText);

        // Change progress bar color based on status
        if (data.failed_jobs > 0) {
            $('#progressBar').removeClass('bg-primary bg-success').addClass('bg-warning');
        } else if (!data.is_processing) {
            $('#progressBar').removeClass('bg-primary bg-warning').addClass('bg-success');
        } else {
            $('#progressBar').removeClass('bg-warning bg-success').addClass('bg-primary');
        }
    }

    function showCompletionMessage() {
        // Update the alert to show completion
        setTimeout(function () {
            $('#successAlert').removeClass('alert-success').addClass('alert-info');
            $('#successAlert').html(`
                        <i class="fas fa-check-circle"></i> All jobs have been processed successfully! 
                        <button type="button" class="btn btn-sm btn-outline-secondary ml-2" onclick="location.reload()">
                            Refresh Page
                        </button>
                    `);

            // Optionally refresh the DataTable
            if (typeof window.LaravelDataTables !== 'undefined' && window.LaravelDataTables[
                'jobs-table']) {
                window.LaravelDataTables['jobs-table'].ajax.reload();
            }
        }, 1000);
    }

    // Clean up interval when page is being unloaded
    $(window).on('beforeunload', function () {
        stopProgressTracking();
    });
});
