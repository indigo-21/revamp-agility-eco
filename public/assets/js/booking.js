$(function () {
    $('.table').DataTable({
        "order": [[0, "desc"]],
        responsive: true,
        autoWidth: false,
    });

    $('.select2').select2();

});

$(document).on('click', '.closeJob', function () {
    let job_number = $(this).data('job-number');

    $('#job_number_closed_job').val(job_number);
});

$(document).on('click', '.attemptMade', function () {
    let job_number = $(this).data('job-number');

    $('#job_number_attempt_made').val(job_number);
});

$(document).on('click', '.unbook-job', function (e) {
    e.preventDefault();
    const form = $(this).closest('.unbook-job-form');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will unbook the job!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, unbook it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});