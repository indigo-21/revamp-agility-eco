
$(function () {

    $('.select2').select2();

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

    $('.table').DataTable({
        "order": [[0, "desc"]],
        responsive: true,
        autoWidth: false,
        filter: true,
    });

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
                $.each(data[0].client_job_type, function (key, value) {
                    console.log(value);
                    $('#job_type_id').append('<option value="' + value.job_type.id + '">' + value.job_type.type + '</option>');
                });
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
        timer: 3000
    });

    if (typeof toastType !== 'undefined' && toastType === 'success') {
        Toast.fire({
            icon: 'success',
            title: 'Job deleted successfully'
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
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
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
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
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
